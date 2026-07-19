<?php $site = $site ?? require __DIR__ . '/../config/site.php'; ?>
<footer class="site-footer">
    <div>
        <strong><?= e($site['site_name']) ?></strong>
        <p>Individuelle Nachhilfe für Leipzig und Umgebung.</p>
    </div>
    <nav aria-label="Rechtliches">
        <a href="/impressum.php">Impressum</a>
        <a href="/datenschutz.php">Datenschutz</a>
        <a href="/sitemap.php">Sitemap</a>
    </nav>
    <p>© <?= date('Y') ?> easyIT</p>
</footer>
<script src="/assets/js/nojquery_3.1.1.js" defer></script>
<script src="/assets/js/app.js" defer></script>
<script src="/assets/js/search-index.js" defer></script>
<script src="/assets/js/search.js" defer></script>
<script src="/assets/js/consent.js" defer></script>
<script src="/assets/js/analytics.js" defer></script>
<script nonce="<?= e(security_csp_nonce()) ?>">
if ("serviceWorker" in navigator) { window.addEventListener("load", () => navigator.serviceWorker.register("/service-worker.js")); }
</script>
