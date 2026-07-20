#!/usr/bin/env python3
from pathlib import Path
import argparse, re, sys, urllib.request, urllib.parse, urllib.error
from html.parser import HTMLParser

ROOT = Path(__file__).resolve().parents[3]
WEB = ROOT / 'nh_hor'
ARCHIVE = ROOT / '_project_archive'
errors=[]; warnings=[]; passed=[]

def ok(msg): passed.append(msg)
def fail(msg): errors.append(msg)
def warn(msg): warnings.append(msg)

def read(path): return path.read_text(encoding='utf-8', errors='ignore')

# 1 placeholders / production config
placeholder_re = re.compile(r'(example\.(?:com|org|net)|changeme|replace[_ -]?me|todo\b|0123[ /-]?456|ihre telefonnummer)', re.I)
allowed = {'.env.example','database.example.php','forms.example.php','site.example.php'}
for p in WEB.rglob('*'):
    if p.is_file() and p.suffix.lower() in {'.php','.html','.js','.css','.json','.xml','.txt','.webmanifest'}:
        text=read(p)
        if placeholder_re.search(text): fail(f'Platzhalter im Webroot: {p.relative_to(WEB)}')
if not errors: ok('Keine offensichtlichen Platzhalterwerte im Webroot')

# 2 URL strategy + canonical
site=read(WEB/'config/site.php')
if "'base_url' => 'https://easyit-leipzig.de'" in site and "'base_path' => ''" in site:
    ok('Öffentliche URL-Strategie ist Domain-Root')
else: fail('URL-Strategie ist nicht eindeutig auf https://easyit-leipzig.de/ festgelegt')
func=read(WEB/'includes/functions.php')
if 'HTTP_HOST' not in func or 'never trusts HTTP_HOST' in func: ok('Canonical-Erzeugung vertraut nicht auf HTTP_HOST')
else: fail('Canonical-Erzeugung verwendet HTTP_HOST')
canonical_body = func[func.find('function canonical_url'):func.find('function asset_url') if 'function asset_url' in func else len(func)]
if re.search(r'\$_GET\s*\[', canonical_body): fail('Canonical übernimmt Requestparameter direkt')
else: ok('Keine direkte Übernahme von Suchparametern in Canonicals gefunden')

# 3 state-changing admin GET + CSRF
admin_text='\n'.join(read(p) for p in (WEB/'admin').rglob('*.php'))
danger_files = []
for pth in (WEB/'admin').rglob('*.php'):
    txt=read(pth)
    if re.search(r'href=[\"\'][^\"\']*(delete|archive)', txt, re.I): danger_files.append(pth)
delete_file = WEB/'admin/delete.php'
if delete_file.exists():
    delete_text=read(delete_file)
    if not (re.search(r"REQUEST_METHOD", delete_text) and re.search(r"\$method\s*!==\s*['\"]POST['\"]", delete_text)):
        danger_files.append(delete_file)
else:
    danger_files.append(delete_file)
if danger_files: fail('Mögliche zustandsändernde Adminaktion per GET: '+', '.join(str(x.relative_to(WEB)) for x in sorted(set(danger_files))))
else: ok('Keine offensichtliche zustandsändernde Adminaktion per GET')
if 'csrf' in admin_text.lower() and "REQUEST_METHOD" in admin_text:
    ok('POST-/CSRF-Prüfung im Adminbereich nachweisbar')
else: fail('POST-/CSRF-Prüfung im Adminbereich nicht vollständig nachweisbar')

# 4 robots/sitemap/indexability
robots=read(WEB/'robots.txt')
if 'Sitemap: https://easyit-leipzig.de/sitemap.xml' in robots: ok('robots.txt verweist auf kanonische Sitemap')
else: fail('robots.txt enthält keinen korrekten Sitemap-Verweis')
if (WEB/'sitemap.xml').exists(): fail('Statische sitemap.xml liegt im Webroot')
elif (WEB/'sitemap-xml.php').exists(): ok('Dynamische XML-Sitemap ist einzige Sitemap-Quelle')
checks={'offline.php':'noindex,nofollow','anfrage-erfolgreich.php':'noindex,follow','suche.php':'noindex,follow','errors/404.php':'noindex,nofollow','errors/500.php':'noindex,nofollow'}
for rel, token in checks.items():
    if token in read(WEB/rel): ok(f'{rel}: {token}')
    else: fail(f'{rel}: {token} fehlt')

# 5 deployment hygiene
bad=[]
for patt in ('*.sql','*.zip','*.md','*.ppj','*.bak','*.backup','*.old','*.orig','*.tmp','*.log'):
    bad.extend(WEB.rglob(patt))
if bad: fail('Nicht deploybare Dateien im Webroot: '+', '.join(str(p.relative_to(WEB)) for p in bad[:10]))
else: ok('Keine Entwicklungs-, SQL-, Archiv- oder Backup-Dateien im Webroot')

# 6 session/csrf
allphp='\n'.join(read(p) for p in WEB.rglob('*.php'))
for token,label in [("session_start([",'Zentrale Cookieparameter'),('cookie_httponly','HttpOnly'),('cookie_samesite','SameSite'),('use_strict_mode','Session Strict Mode')]:
    if token.lower() in allphp.lower(): ok(label)
    else: fail(f'{label} nicht nachweisbar')
if re.search(r'inactivity|idle|last_activity', allphp, re.I): ok('Inaktivitäts-Timeout nachweisbar')
else: fail('Inaktivitäts-Timeout nicht nachweisbar')

# 7 keyboard/menu/forms static evidence
header=read(WEB/'includes/header.php'); js='\n'.join(read(p) for p in (WEB/'assets/js').glob('*.js'))
if 'aria-expanded' in header and '<button' in header: ok('Semantische Menüschalter vorhanden')
else: fail('Semantische Menüschalter fehlen')
for token in ('Escape','ArrowDown','ArrowUp'):
    if token in js: ok(f'Menütastatur: {token}')
    else: fail(f'Menütastatur: {token} fehlt')
css='\n'.join(read(p) for p in (WEB/'assets/css').glob('*.css'))
if ':focus-visible' in css: ok(':focus-visible vorhanden')
else: fail(':focus-visible fehlt')

# 8 DB
DB=ARCHIVE/'database'
myisam=[]
for p in DB.rglob('*.sql'):
    if re.search(r'\bMyISAM\b', read(p), re.I): myisam.append(p)
if myisam: fail('MyISAM in Datenbankdateien: '+', '.join(str(p.relative_to(ROOT)) for p in myisam))
else: ok('Datenbankschemata ausschließlich InnoDB')
if (DB/'migrate.php').exists() and (DB/'check.php').exists(): ok('Migration und Datenbankprüfung vorhanden')
else: fail('Migration oder Datenbankprüfung fehlt')

# 9 contact SMTP
if 'mail(' in allphp: fail('Direkter mail()-Aufruf vorhanden')
else: ok('Kein direkter mail()-Aufruf')
if 'smtp' in allphp.lower(): ok('SMTP-Versand implementiert')
else: fail('SMTP-Versand nicht nachweisbar')

# Optional staging HTTP checks
class HeadParser(HTMLParser):
    def __init__(self): super().__init__(); self.canon=[]; self.robots=[]
    def handle_starttag(self, tag, attrs):
        d=dict(attrs)
        if tag=='link' and d.get('rel')=='canonical': self.canon.append(d.get('href',''))
        if tag=='meta' and d.get('name','').lower()=='robots': self.robots.append(d.get('content',''))

def fetch(url):
    req=urllib.request.Request(url, headers={'User-Agent':'easyIT-V3-Audit/1.0'})
    with urllib.request.urlopen(req, timeout=20) as r:
        return r.status, dict(r.headers), r.read().decode('utf-8','replace')

ap=argparse.ArgumentParser(); ap.add_argument('--base-url', default=''); args=ap.parse_args()
if args.base_url:
    base=args.base_url.rstrip('/')+'/'
    pages=['','suche.php?q=mathe','sitemap.php','kontakt.php','admin/login.php','sitemap.xml']
    for rel in pages:
        try:
            status,h,b=fetch(urllib.parse.urljoin(base,rel))
            if status<500: ok(f'Staging {rel or "/"}: HTTP {status}')
            else: fail(f'Staging {rel}: HTTP {status}')
            if rel.endswith('.php') or rel=='':
                parser=HeadParser(); parser.feed(b)
                if rel.startswith('suche.php') and not any('noindex' in x for x in parser.robots): fail('Staging-Suche ohne noindex')
                if parser.canon and any('?' in x for x in parser.canon): fail(f'Canonical mit Parametern auf {rel}')
        except Exception as e: fail(f'Staging {rel or "/"} nicht erreichbar: {e}')
else:
    warn('Staging-Lauf nicht ausgeführt; --base-url wurde nicht angegeben')

print('REVISION V3 – DEFINITION OF DONE')
for x in passed: print('[OK]',x)
for x in warnings: print('[OFFEN]',x)
for x in errors: print('[FEHLER]',x)
print(f'\nErgebnis: {len(passed)} OK, {len(warnings)} offen, {len(errors)} Fehler')
sys.exit(1 if errors else 0)
