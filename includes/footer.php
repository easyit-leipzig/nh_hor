<?php $site = $site ?? require __DIR__ . '/../config/site.php'; ?>
<footer class="site-footer">
    <div>
        <strong><?= e($site['site_name']) ?></strong>
        <p>Individuelle Nachhilfe für Leipzig und Umgebung.</p>
    </div>
    <nav aria-label="Rechtliches">
        <a href="<?= e(app_path('/impressum.php')) ?>">Impressum</a>
        <a href="<?= e(app_path('/datenschutz.php')) ?>">Datenschutz</a>
        <a href="<?= e(app_path('/sitemap.php')) ?>">Sitemap</a>
    </nav>
    <p>© <?= date('Y') ?> easyIT</p>
</footer>
<script src="<?= e(asset_url('assets/js/app.js')) ?>" defer></script>
<script src="<?= e(asset_url('assets/js/search-index.js')) ?>" defer></script>
<script src="<?= e(asset_url('assets/js/search.js')) ?>" defer></script>
<script src="<?= e(asset_url('assets/js/consent.js')) ?>" defer></script>
<script src="<?= e(asset_url('assets/js/analytics.js')) ?>" defer></script>
<script src="<?= e(app_path('/assets/js/menu-flag.js')) ?>" defer></script>
<script nonce="<?= e(security_csp_nonce()) ?>">
if ("serviceWorker" in navigator) { window.addEventListener("load", () => navigator.serviceWorker.register("<?= e(app_path('/service-worker.js')) ?>")); }
</script>
