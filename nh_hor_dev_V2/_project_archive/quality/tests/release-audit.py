#!/usr/bin/env python3
from pathlib import Path
import re, sys

ROOT = Path(__file__).resolve().parents[3]
WEB = ROOT / 'nh_hor'
errors=[]

def fail(msg): errors.append(msg)

# Deployment hygiene
for ext in ('*.sql','*.zip','*.md','*.ppj','*.bak','*.tmp'):
    for p in WEB.rglob(ext): fail(f'Nicht erlaubte Webroot-Datei: {p.relative_to(WEB)}')
if (WEB/'sitemap.xml').exists(): fail('Statische sitemap.xml vorhanden; nur dynamische Sitemap zulässig.')
if not (WEB/'sitemap-xml.php').exists(): fail('Dynamische sitemap-xml.php fehlt.')
if not (WEB/'.htaccess').exists(): fail('Produktive .htaccess fehlt.')

# Canonical/host strategy
site=(WEB/'config/site.php').read_text(encoding='utf-8')
if "'base_url' => 'https://easyit-leipzig.de'" not in site: fail('Kanonische Basisdomain ist nicht fest konfiguriert.')
func=(WEB/'includes/functions.php').read_text(encoding='utf-8')
if 'HTTP_HOST' in func and 'never trusts HTTP_HOST' not in func: fail('Canonical-Code scheint HTTP_HOST zu verwenden.')

# noindex requirements
checks={
 'offline.php':'noindex,nofollow',
 'anfrage-erfolgreich.php':'noindex,follow',
 'suche.php':'noindex,follow',
 'errors/404.php':'noindex,nofollow',
 'errors/500.php':'noindex,nofollow',
}
for rel,token in checks.items():
    text=(WEB/rel).read_text(encoding='utf-8')
    if token not in text: fail(f'{rel}: erwartetes robots-Attribut {token} fehlt.')

# Security essentials
allphp='\n'.join(p.read_text(encoding='utf-8', errors='ignore') for p in WEB.rglob('*.php'))
for token,label in [('SameSite','SameSite-Cookie'),('httponly','HttpOnly-Cookie')]:
    if token.lower() not in allphp.lower(): fail(f'{label} nicht nachweisbar.')
if 'mail(' in allphp: fail('Direkter mail()-Aufruf vorhanden.')

# Asset strategy
manifest=(WEB/'config/asset-manifest.php').read_text(encoding='utf-8')
for logical, hashed in re.findall(r"'([^']+)'\s*=>\s*'([^']+)'", manifest):
    if logical.endswith(('.css','.js')):
        if not re.search(r'\.[0-9a-f]{12}\.(css|js)$', hashed): fail(f'Asset nicht gehasht: {hashed}')
        if not (WEB/hashed).exists(): fail(f'Manifestziel fehlt: {hashed}')
if (WEB/'css').exists() or (WEB/'js').exists(): fail('Doppelte Asset-Verzeichnisse css/ oder js/ vorhanden.')

# DB archive checks
DB=ROOT/'_project_archive/database'
for p in DB.rglob('*.sql'):
    text=p.read_text(encoding='utf-8', errors='ignore')
    if re.search(r'ENGINE\s*=\s*MyISAM|\bMyISAM\b', text, re.I): fail(f'MyISAM in {p.relative_to(ROOT)}')

if errors:
    print('RELEASE-AUDIT FEHLGESCHLAGEN')
    for e in errors: print('-',e)
    sys.exit(1)
print('RELEASE-AUDIT OK')
print('Webroot:', WEB)
