<?php $site = $site ?? require __DIR__ . '/../config/site.php'; ?>
<footer class="site-footer">
    <div>
        <strong><?= e($site['site_name']) ?></strong>
        <p>Individuelle Nachhilfe für Leipzig und Umgebung.</p>
    </div>
    <nav aria-label="Rechtliches">
        <a href="/nh_hor/impressum.php">Impressum</a>
        <a href="/nh_hor/datenschutz.php">Datenschutz</a>
        <a href="/nh_hor/sitemap.php">Sitemap</a>
    </nav>
    <p>© <?= date('Y') ?> easyIT</p>
</footer>
<script src="/nh_hor/assets/js/nojquery_3.1.1.js" defer></script>
<script src="/nh_hor/assets/js/app.js" defer></script>
<script src="/nh_hor/assets/js/search-index.js" defer></script>
<script src="/nh_hor/assets/js/search.js" defer></script>
<script src="/nh_hor/assets/js/consent.js" defer></script>
<script src="/nh_hor/assets/js/analytics.js" defer></script>
<script>
if ("serviceWorker" in navigator) { window.addEventListener("load", () => navigator.serviceWorker.register("/nh_hor/service-worker.js")); }
</script>
