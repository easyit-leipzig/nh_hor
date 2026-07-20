import { chromium } from 'playwright';
import AxeBuilder from '@axe-core/playwright';

const urls = process.argv.slice(2);
if (urls.length === 0) throw new Error('Mindestens eine URL angeben.');
const browser = await chromium.launch({ headless: true });
let failed = false;
try {
  const page = await browser.newPage();
  for (const url of urls) {
    await page.goto(url, { waitUntil: 'networkidle' });
    const result = await new AxeBuilder({ page }).withTags(['wcag2a','wcag2aa','wcag21aa','wcag22aa']).analyze();
    const serious = result.violations.filter(v => ['serious','critical'].includes(v.impact));
    if (serious.length) {
      failed = true;
      console.error(`FAIL ${url}`);
      for (const violation of serious) console.error(`- ${violation.id}: ${violation.help} (${violation.nodes.length})`);
    } else console.log(`OK   ${url}`);
  }
} finally { await browser.close(); }
process.exit(failed ? 1 : 0);
