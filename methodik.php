<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Methodik der Nachhilfe in Leipzig | Verstehen lernen | easyIT';
$pageDescription = 'Die easyIT-Methodik verbindet Diagnose, bildhafte Erklärungen, gezielte Fragen, Übung, Recherchekompetenz und eigenständigen Transfer.';
$pageCanonical = $site['base_url'] . '/nh_hor/methodik.php';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><span aria-current="page">Meine Methodik</span></nav>
<section class="content-hero"><span class="eyebrow">Vom ersten Verständnis bis zur sicheren Anwendung</span><h1>Meine Methodik</h1><p class="lead">Die easyIT-Methodik verbindet Diagnose, bildhafte Erklärungen, gezielte Fragen, Übung, Recherchekompetenz und eigenständigen Transfer.</p></section>

<section class="section"><header class="section-heading"><div><span class="eyebrow">Ablauf</span><h2>Fünf Schritte, die Orientierung geben</h2></div></header><div class="steps">
<article class="step"><div><h3>Stand klären</h3><p>Wir prüfen nicht nur, welche Aufgabe Schwierigkeiten macht, sondern welche Voraussetzung dafür fehlt.</p></div></article>
<article class="step"><div><h3>Ein verständliches Bild entwickeln</h3><p>Skizzen, Beispiele, Einheiten, Modelle oder Alltagssituationen machen abstrakte Inhalte greifbar.</p></div></article>
<article class="step"><div><h3>Den Lösungsweg gemeinsam aufbauen</h3><p>Gezielte Fragen führen zum nächsten sinnvollen Schritt, ohne die gesamte Lösung vorwegzunehmen.</p></div></article>
<article class="step"><div><h3>Selbstständig anwenden</h3><p>Neue Aufgaben zeigen, ob der Gedanke wirklich verstanden wurde und übertragen werden kann.</p></div></article>
<article class="step"><div><h3>Ergebnisse sichern</h3><p>Merksätze, Lösungsblätter und passende Wiederholungen helfen, den Fortschritt dauerhaft zu stabilisieren.</p></div></article>
</div></section>
<section class="section split"><div class="prose"><h2>Die Recherche-Regel</h2><p>Nicht jede Frage muss sofort an die Lehrkraft weitergereicht werden. Zuerst wird geprüft, ob sich die Antwort im Tafelwerk, in vorhandenen Unterlagen oder durch eine kurze, gezielte Internetrecherche finden lässt. Nach wenigen Minuten wird entschieden: Ist die Antwort belastbar, braucht es eine Rückfrage oder muss die Suche anders strukturiert werden?</p><p>So entsteht nicht nur Fachwissen, sondern eine Fähigkeit, die weit über die nächste Klausur hinausreicht: Informationen selbstständig zu finden, zu bewerten und sinnvoll anzuwenden.</p></div><aside class="info-box"><h2>Handy im Unterricht</h2><p>Für Recherche und Lernanwendungen kann das Smartphone ein Werkzeug sein. Private Kommunikation gehört dagegen in die Pause, damit die gemeinsame Arbeitszeit konzentriert bleibt.</p></aside></section>
<section class="section"><header class="section-heading"><div><span class="eyebrow">Je nach Ziel</span><h2>Methodik ist kein starres Schema</h2></div></header><div class="card-grid"><article class="card"><h3>Akute Klausur</h3><p>Prioritäten, typische Aufgabentypen und ein realistischer Zeitplan stehen im Vordergrund.</p></article><article class="card"><h3>Langfristige Lücken</h3><p>Grundlagen werden schrittweise rekonstruiert und mit dem aktuellen Stoff verbunden.</p></article><article class="card"><h3>Abitur</h3><p>Wissen, Strategie, Zeitmanagement und sichere Darstellung werden gemeinsam trainiert.</p></article><article class="card"><h3>Studium</h3><p>Komplexe Inhalte werden strukturiert, Voraussetzungen aufgearbeitet und Übungswege geplant.</p></article></div></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>