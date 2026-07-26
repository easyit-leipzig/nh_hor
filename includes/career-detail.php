<?php
declare(strict_types=1);

if (!isset($careerJob) || !is_array($careerJob)) {
    http_response_code(404);
    exit('Stellenprofil nicht gefunden.');
}

$gallery = $careerJob['detail_images'] ?? $careerJob['images'] ?? [];
$faq = $careerJob['faq'] ?? [
    ['q' => 'Ist Unterrichtserfahrung zwingend erforderlich?', 'a' => 'Wichtiger als eine bestimmte Anzahl an Berufsjahren sind sichere Fachkenntnisse, eine verständliche Ausdrucksweise und die Bereitschaft, Unterricht sorgfältig vorzubereiten.'],
    ['q' => 'Wie werden die Unterrichtszeiten abgestimmt?', 'a' => 'Die Einsatzzeiten werden transparent und verbindlich vereinbart. Dabei berücksichtigen wir die Verfügbarkeit der Lehrkraft und den tatsächlichen Förderbedarf.'],
    ['q' => 'Welche Unterrichtsformen gibt es?', 'a' => 'Je nach Fach, Lernziel und Situation sind Einzelunterricht, kleine Lerngruppen sowie begleitete Prüfungsvorbereitung möglich.'],
    ['q' => 'Wie läuft die Bewerbung ab?', 'a' => 'Nach einer kurzen Kontaktaufnahme folgt ein persönliches Gespräch. Dabei klären wir Fachbereiche, Verfügbarkeit, Erfahrungen und die gemeinsame Vorstellung von gutem Unterricht.'],
];
?>
<section class="career-detail-hero" aria-labelledby="career-title">
  <div class="career-detail-hero__media">
    <?php if (!empty($gallery[0])): $hero = $gallery[0]; ?>
      <img src="<?= e(app_path($hero['src'])) ?>" alt="<?= e($hero['alt']) ?>" width="1200" height="800" fetchpriority="high">
    <?php endif; ?>
  </div>
  <div class="career-detail-hero__copy">
    <span class="job-code job-code--large"><?= e($careerJob['code']) ?></span>
    <span class="eyebrow">Stellenprofil bei easyIT Nachhilfe</span>
    <h1 id="career-title"><?= e($careerJob['title']) ?></h1>
    <p class="career-lead"><?= e($careerJob['claim']) ?></p>
    <p><?= e($careerJob['intro']) ?></p>
    <div class="jobs-hero__actions">
      <a class="button button--gold" href="<?= e(app_path('/kontakt.php?subject=' . rawurlencode('Bewerbung ' . $careerJob['code']))) ?>">Jetzt Interesse mitteilen</a>
      <a class="button" href="#profil">Profil ansehen</a>
    </div>
  </div>
</section>

<section class="section career-value-strip" aria-label="easyIT Arbeitgeberwerte">
  <article><strong>Individuell vorbereitet</strong><span>Keine Standardschablonen, sondern Unterricht mit Blick auf den konkreten Lernweg.</span></article>
  <article><strong>Verständlich erklärt</strong><span>Zusammenhänge werden Schritt für Schritt sichtbar und nachvollziehbar gemacht.</span></article>
  <article><strong>Auf Augenhöhe</strong><span>Fragen, Unsicherheiten und eigene Lösungswege werden ernst genommen.</span></article>
</section>

<section class="section career-story" aria-labelledby="story-title">
  <span class="eyebrow">Einblick in den Arbeitsalltag</span>
  <h2 id="story-title">Unterrichten, vorbereiten und gemeinsam weiterentwickeln</h2>
  <p class="jobs-section-intro">Die Bildserie zeigt die drei Bereiche, die bei easyIT zusammengehören: persönliche Lernbegleitung, sorgfältige Vorbereitung und kollegialer Austausch.</p>
  <div class="career-gallery" data-career-gallery>
    <?php foreach ($gallery as $index => $image): ?>
      <figure class="career-gallery__item<?= $index === 0 ? ' career-gallery__item--wide' : '' ?>">
        <button type="button" class="career-gallery__button" data-gallery-index="<?= (int)$index ?>" aria-label="Bild vergrößern: <?= e($image['caption']) ?>">
          <img src="<?= e(app_path($image['src'])) ?>" alt="<?= e($image['alt']) ?>" width="720" height="720" loading="<?= $index < 3 ? 'eager' : 'lazy' ?>" decoding="async">
          <span><?= e($image['caption']) ?></span>
        </button>
      </figure>
    <?php endforeach; ?>
  </div>
</section>

<section class="section career-profile" id="profil" aria-labelledby="profile-title">
  <span class="eyebrow">Das Stellenprofil</span>
  <h2 id="profile-title">Was du einbringst und was dich erwartet</h2>
  <div class="career-profile-grid">
    <article><h3>Fachbereiche</h3><ul><?php foreach ($careerJob['subjects'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></article>
    <article><h3>Unsere Werte</h3><ul><?php foreach ($careerJob['values'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></article>
    <article><h3>Anforderungen</h3><ul><?php foreach ($careerJob['requirements'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></article>
    <article><h3>Passende Profile</h3><ul><?php foreach ($careerJob['profiles'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></article>
  </div>
</section>

<section class="section career-process" aria-labelledby="process-title">
  <span class="eyebrow">Von der Anfrage zum Unterricht</span>
  <h2 id="process-title">So lernen wir uns kennen</h2>
  <ol class="career-steps">
    <li><span>1</span><div><strong>Kurze Kontaktaufnahme</strong><p>Du nennst Fachbereiche, Qualifikation, mögliche Einsatzzeiten und deine Motivation.</p></div></li>
    <li><span>2</span><div><strong>Persönliches Gespräch</strong><p>Wir sprechen über Unterrichtsverständnis, Erwartungen und die konkrete Zusammenarbeit.</p></div></li>
    <li><span>3</span><div><strong>Fachliche Zuordnung</strong><p>Gemeinsam legen wir fest, welche Klassenstufen, Themen und Lernformen gut zu dir passen.</p></div></li>
    <li><span>4</span><div><strong>Begleiteter Einstieg</strong><p>Du erhältst einen klaren organisatorischen Rahmen und beginnst mit passenden Lernenden.</p></div></li>
  </ol>
</section>

<section class="section career-faq" aria-labelledby="faq-title">
  <span class="eyebrow">Häufige Fragen</span>
  <h2 id="faq-title">Fragen zur Mitarbeit</h2>
  <div class="career-faq-list">
    <?php foreach ($faq as $item): ?>
      <details><summary><?= e($item['q']) ?></summary><p><?= e($item['a']) ?></p></details>
    <?php endforeach; ?>
  </div>
</section>

<section class="section career-cta">
  <div><span class="eyebrow">Teil des Teams werden</span><h2><?= e($careerJob['title']) ?></h2><p>Fachwissen ist wichtig. Entscheidend ist, dass du Lernende ernst nimmst, sorgfältig vorbereitest und verständlich erklärst.</p></div>
  <a class="button button--gold" href="<?= e(app_path('/kontakt.php?subject=' . rawurlencode('Bewerbung ' . $careerJob['code']))) ?>">Bewerbung anfragen</a>
</section>

<div class="career-lightbox" data-career-lightbox hidden aria-hidden="true" role="dialog" aria-modal="true" aria-label="Vergrößerte Bildergalerie">
  <button class="career-lightbox__close" type="button" data-lightbox-close aria-label="Galerie schließen">×</button>
  <button class="career-lightbox__nav career-lightbox__nav--prev" type="button" data-lightbox-prev aria-label="Vorheriges Bild">‹</button>
  <figure><img src="" alt="" data-lightbox-image><figcaption data-lightbox-caption></figcaption></figure>
  <button class="career-lightbox__nav career-lightbox__nav--next" type="button" data-lightbox-next aria-label="Nächstes Bild">›</button>
</div>
