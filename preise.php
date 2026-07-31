<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

// Die Angebotsseite darf nach Änderungen im Adminbereich nicht aus einem
// Browser- oder Proxy-Cache ausgeliefert werden.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
require_once __DIR__ . '/includes/offer-repository.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Preise und Ablauf der Nachhilfe in Leipzig | easyIT';
$pageDescription = 'Transparente Informationen zu Kennenlernen, Einzelunterricht, Prüfungsvorbereitung, Absagen und individueller Vereinbarung bei easyIT Leipzig.';
$pageCanonical = $site['base_url'] . '/preise.php';
$offers = offer_list(true);
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Preise und Ablauf</span></nav>
<section class="content-hero"><span class="eyebrow">Transparent, planbar und passend zum tatsächlichen Bedarf</span><h1>Preise und Ablauf</h1><p class="lead">Transparente Informationen zu Kennenlernen, Einzelunterricht, Prüfungsvorbereitung, Absagen und individueller Vereinbarung bei easyIT Leipzig.</p></section>

<section class="section">
<?php if ($offers === []): ?>
    <div class="info-box">
        <h2>Angebote werden derzeit überarbeitet</h2>
        <p>Bitte frage den passenden Unterricht und den aktuellen Preis direkt über das Kontaktformular an.</p>
    </div>
<?php else: ?>
    <div class="price-grid" style="margin-top:1.5rem">
    <?php foreach ($offers as $offer): ?>
        <article class="price-card<?= (int)$offer['featured'] === 1 ? ' featured' : '' ?>">
            <?php if (trim((string)$offer['badge']) !== ''): ?><span class="badge"><?= e((string)$offer['badge']) ?></span><?php endif; ?>
            <h2><?= e((string)$offer['title']) ?></h2>
            <p class="price"><?= e(offer_price_label($offer)) ?></p>
            <p><?= e((string)$offer['description']) ?></p>
            <?php if (!empty($offer['features'])): ?>
                <ul class="icon-list">
                    <?php foreach ($offer['features'] as $feature): ?><li><?= e((string)$feature) ?></li><?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
    </div>

    <?php $footnotes = array_values(array_filter(array_map(static fn(array $offer): string => trim((string)($offer['footnote'] ?? '')), $offers))); ?>
    <?php if ($footnotes): ?><div class="offer-footnotes"><?php foreach ($footnotes as $footnote): ?><p><small><?= e($footnote) ?></small></p><?php endforeach; ?></div><?php endif; ?>
<?php endif; ?>
</section>

<section class="section"><header class="section-heading"><div><span class="eyebrow">Organisation</span><h2>So entsteht eine verlässliche Zusammenarbeit</h2></div></header><div class="steps"><article class="step"><div><h3>Anfrage</h3><p>Fach, Klassenstufe, Thema und gewünschter Zeitraum werden kurz beschrieben.</p></div></article><article class="step"><div><h3>Abstimmung</h3><p>Unterrichtsform, Dauer, Termin und Preis werden vor Beginn eindeutig vereinbart.</p></div></article><article class="step"><div><h3>Unterricht</h3><p>Die Stunde orientiert sich an Ziel und aktuellem Lernstand.</p></div></article><article class="step"><div><h3>Rückmeldung</h3><p>Fortschritt und nächste Schritte werden transparent besprochen.</p></div></article></div></section>
<section class="section prose"><h2>Absagen und Terminänderungen</h2><p>Eine faire Absageregel schützt beide Seiten. Die konkrete Frist und mögliche Ausfallkosten werden bei der Terminvereinbarung eindeutig kommuniziert.</p></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>