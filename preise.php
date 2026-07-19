<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Preise und Ablauf der Nachhilfe in Leipzig | easyIT';
$pageDescription = 'Transparente Informationen zu Kennenlernen, Einzelunterricht, Prüfungsvorbereitung, Absagen und individueller Vereinbarung bei easyIT Leipzig.';
$pageCanonical = $site['base_url'] . '/nh_hor/preise.php';
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

<section class="section"><div class="info-box"><h2>Preisangaben vor Veröffentlichung ergänzen</h2><p>In Phase 2 ist die Preisstruktur vollständig vorbereitet. Trage die verbindlichen Beträge erst ein, wenn Dauer, Unterrichtsform und steuerliche Angaben endgültig feststehen.</p></div><div class="price-grid" style="margin-top:1.5rem">
<article class="price-card"><span class="badge">Kennenlernen</span><h2>Erstgespräch</h2><p class="price">kostenfrei*</p><p>Kurze Klärung von Fach, Ziel, Stand und organisatorischem Rahmen.</p><ul class="icon-list"><li>Bedarf einschätzen</li><li>passende Unterrichtsform klären</li><li>offene Fragen beantworten</li></ul></article>
<article class="price-card featured"><span class="badge">Kernangebot</span><h2>Einzelunterricht</h2><p class="price">Preis eintragen</p><p>Individuelle Nachhilfe mit Vorbereitung und passender Lernstruktur.</p><ul class="icon-list"><li>persönlicher Schwerpunkt</li><li>flexible Fachinhalte</li><li>gezielte Rückmeldung</li></ul></article>
<article class="price-card"><span class="badge">Intensiv</span><h2>Prüfungsvorbereitung</h2><p class="price">individuell</p><p>Planbare Vorbereitung auf Klausur, Abschlussprüfung oder Abitur.</p><ul class="icon-list"><li>Bestandsaufnahme</li><li>Lernplan</li><li>Prüfungssimulation</li></ul></article>
</div><p><small>* Formulierung und Umfang des kostenfreien Kennenlernens bitte vor Veröffentlichung verbindlich festlegen.</small></p></section>
<section class="section"><header class="section-heading"><div><span class="eyebrow">Organisation</span><h2>So entsteht eine verlässliche Zusammenarbeit</h2></div></header><div class="steps"><article class="step"><div><h3>Anfrage</h3><p>Fach, Klassenstufe, Thema und gewünschter Zeitraum werden kurz beschrieben.</p></div></article><article class="step"><div><h3>Abstimmung</h3><p>Unterrichtsform, Dauer, Termin und Preis werden vor Beginn eindeutig vereinbart.</p></div></article><article class="step"><div><h3>Unterricht</h3><p>Die Stunde orientiert sich an Ziel und aktuellem Lernstand.</p></div></article><article class="step"><div><h3>Rückmeldung</h3><p>Fortschritt und nächste Schritte werden transparent besprochen.</p></div></article></div></section>
<section class="section prose"><h2>Absagen und Terminänderungen</h2><p>Eine faire Absageregel schützt beide Seiten. Die konkrete Frist und mögliche Ausfallkosten müssen vor Veröffentlichung verbindlich eingetragen und bei der Terminvereinbarung deutlich kommuniziert werden.</p></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>