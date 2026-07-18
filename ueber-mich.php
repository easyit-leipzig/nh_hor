<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Über mich | Tutor für MINT-Nachhilfe in Leipzig | easyIT';
$pageDescription = 'Olaf Thiele begleitet Lernende in Mathematik, Physik, Chemie und Informatik mit fachübergreifender Erfahrung und persönlicher Methodik.';
$pageCanonical = $site['base_url'] . '/nh_hor/ueber-mich.php';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><span aria-current="page">Über mich</span></nav>
<section class="content-hero"><span class="eyebrow">Tutor, Erklärer und Lernbegleiter</span><h1>Über mich</h1><p class="lead">Olaf Thiele begleitet Lernende in Mathematik, Physik, Chemie und Informatik mit fachübergreifender Erfahrung und persönlicher Methodik.</p></section>

<section class="section split"><div class="prose"><h2>Unterrichten heißt für mich: gemeinsam denken</h2>
<p>Ich begleite Lernende in Mathematik, Physik, Chemie und Informatik. Dabei sehe ich mich nicht nur als klassischen Nachhilfelehrer, sondern als Tutor: jemand, der Orientierung gibt, Fragen aufnimmt und dabei hilft, einen eigenen Zugang zu schwierigen Inhalten zu entwickeln.</p>
<p>Mein fachübergreifender Hintergrund ist besonders dann hilfreich, wenn ein Problem nicht sauber in ein einzelnes Schulfach passt. Eine mathematische Formel kann eine physikalische Aussage beschreiben, ein chemischer Prozess braucht Mengenverständnis und eine informatische Lösung verlangt strukturiertes Denken. Solche Verbindungen mache ich im Unterricht sichtbar.</p>
<h2>Ich muss nicht jede Antwort sofort wissen</h2><p>Glaubwürdiger Unterricht bedeutet auch, Unsicherheit offen zu benennen. Wenn eine Frage nicht sofort sicher beantwortet werden kann, wird sie sauber recherchiert und nachvollziehbar geklärt. Lernende erleben dadurch, dass Wissen nicht nur aus fertigen Antworten besteht, sondern auch aus guten Suchwegen, überprüfbaren Quellen und der Bereitschaft, die eigene Annahme zu korrigieren.</p></div>
<aside class="hero-panel"><h2>Fachliche Schwerpunkte</h2><ul class="tag-list"><li>Mathematik</li><li>Physik</li><li>Chemie</li><li>Informatik</li><li>Prüfungsvorbereitung</li><li>Studienbegleitung</li></ul><p>Für Sprachen und weitere Fachgebiete wird das Team perspektivisch durch passende Honorarkräfte ergänzt.</p></aside></section>
<section class="section"><header class="section-heading"><div><span class="eyebrow">Arbeitsweise</span><h2>Was Lernende erwarten können</h2></div></header><div class="card-grid"><article class="card"><h3>Geduld</h3><p>Ein Gedanke darf mehrfach und auf unterschiedlichen Wegen erklärt werden.</p></article><article class="card"><h3>Direktheit</h3><p>Probleme werden benannt, ohne Lernende abzuwerten.</p></article><article class="card"><h3>Verlässlichkeit</h3><p>Absprachen, Aufgaben und Rückfragen werden nachvollziehbar behandelt.</p></article><article class="card"><h3>Neugier</h3><p>Auch unerwartete Fragen dürfen den Unterricht sinnvoll erweitern.</p></article></div></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>