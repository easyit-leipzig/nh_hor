<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$site = require __DIR__ . '/config/site.php';
$areas = require __DIR__ . '/config/areas.php';

$pageTitle = 'Nachhilfe in Leipzig und Stadtteilen | easyIT';
$pageDescription = 'Lokale Übersicht der Nachhilfeangebote von easyIT für Leipzig, Gohlis, Südvorstadt, Connewitz, Schleußig, Plagwitz und weitere Stadtteile.';
$pageCanonical = $site['base_url'] . '/nachhilfe-in-leipzig.php';
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head>
    <?php require __DIR__ . '/includes/meta.php'; ?>
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="hauptinhalt">
        <div class="content-wrap">
            <nav class="breadcrumbs" aria-label="Brotkrumen">
                <a href="<?= e(app_path('/index.php')) ?>">Startseite</a>
                <span>›</span>
                <span aria-current="page">Nachhilfe in Leipzig</span>
            </nav>

            <section class="hero local-hero">
                <div>
                    <span class="eyebrow">Local SEO · echte Inhalte</span>
                    <h1>Nachhilfe in Leipzig und Stadtteilen</h1>
                    <p>Die lokalen Seiten bündeln das Angebot nach Stadtteilen, ohne identische Texte zu vervielfältigen. Jeder Schwerpunkt beschreibt einen tatsächlichen Lernbedarf.</p>
                    <div class="hero-actions">
                        <a class="button button--gold" href="<?= e(app_path('/kontakt.php')) ?>">Nachhilfe anfragen</a>
                    </div>
                </div>
                <aside class="hero-panel">
                    <span class="local-pin" aria-hidden="true">⌖</span>
                    <h2>Leipzig im Mittelpunkt</h2>
                    <p>Fächer, Schulformen und Stadtteilseiten sind sinnvoll miteinander verknüpft.</p>
                </aside>
            </section>

            <section class="section" aria-labelledby="stadtteile-heading">
                <header class="section-heading">
                    <div>
                        <span class="eyebrow">Stadtteile</span>
                        <h2 id="stadtteile-heading">Lokale Übersichten</h2>
                    </div>
                </header>

                <div class="local-link-grid">
                    <?php foreach ($areas as $areaKey => $area): ?>
                        <?php
                        $file = trim((string)($area['file'] ?? ''));
                        $name = trim((string)($area['name'] ?? $areaKey));
                        if ($file === '') {
                            continue;
                        }
                        ?>
                        <a href="<?= e(app_path('/' . ltrim($file, '/'))) ?>">
                            <strong><?= e($name) ?></strong>
                            <span aria-hidden="true">→</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <?php require __DIR__ . '/includes/footer.php'; ?>
    </main>
</div>
</body>
</html>
