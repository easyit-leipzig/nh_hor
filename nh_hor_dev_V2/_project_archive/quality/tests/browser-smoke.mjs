import { chromium, firefox, webkit } from 'playwright';

const base = (process.env.TEST_BASE_URL || process.argv[2] || 'http://127.0.0.1:8080').replace(/\/$/, '');
const browsers = { chromium, firefox, webkit };
const viewports = [
  { name: '320', width: 320, height: 800 },
  { name: '375', width: 375, height: 812 },
  { name: '768', width: 768, height: 1024 },
  { name: '1024', width: 1024, height: 768 },
  { name: 'desktop', width: 1440, height: 900 },
];
const pages = ['/', '/faecher.php', '/suche.php?q=mathe', '/kontakt.php', '/admin/login.php', '/errors/404.php'];
let failed = false;

for (const [browserName, launcher] of Object.entries(browsers)) {
  const browser = await launcher.launch({ headless: true });
  try {
    for (const viewport of viewports) {
      const context = await browser.newContext({ viewport: { width: viewport.width, height: viewport.height } });
      const page = await context.newPage();
      for (const path of pages) {
        const response = await page.goto(base + path, { waitUntil: 'domcontentloaded' });
        const status = response?.status() ?? 0;
        if (status >= 500 || status === 0) {
          failed = true; console.error(`FAIL ${browserName}/${viewport.name} ${path}: HTTP ${status}`); continue;
        }
        const h1 = await page.locator('h1').count();
        if (h1 !== 1) { failed = true; console.error(`FAIL ${browserName}/${viewport.name} ${path}: h1=${h1}`); }
        const overflow = await page.evaluate(() => document.documentElement.scrollWidth > document.documentElement.clientWidth + 2);
        if (overflow) { failed = true; console.error(`FAIL ${browserName}/${viewport.name} ${path}: horizontaler Overflow`); }
      }
      // Tastatur-Menü: Fokus, Öffnen, Escape.
      await page.goto(base + '/', { waitUntil: 'domcontentloaded' });
      const toggle = page.locator('button[aria-controls][aria-expanded]').first();
      if (await toggle.count()) {
        await toggle.focus(); await page.keyboard.press('Enter');
        if ((await toggle.getAttribute('aria-expanded')) !== 'true') { failed=true; console.error(`FAIL ${browserName}/${viewport.name}: Menü öffnet nicht per Tastatur`); }
        await page.keyboard.press('Escape');
        if ((await toggle.getAttribute('aria-expanded')) !== 'false') { failed=true; console.error(`FAIL ${browserName}/${viewport.name}: Menü schließt nicht mit Escape`); }
      }
      await context.close();
    }
  } finally { await browser.close(); }
}
process.exit(failed ? 1 : 0);
