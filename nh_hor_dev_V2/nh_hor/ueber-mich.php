<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/database.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Unser Tutorenteam | Nachhilfe in Leipzig | easyIT';
$pageDescription = 'Lernen Sie die Tutorinnen und Tutoren von easyIT Leipzig mit ihren fachlichen, methodischen und didaktischen Kompetenzen kennen.';
$pageCanonical = $site['base_url'] . '/ueber-mich.php';

/** @return array<int,array<string,mixed>> */
function loadTutors(): array
{
    if (!db_available()) {
        return [];
    }

    $tutors = db()->query(
        "SELECT id, slug, display_name, professional_title, short_intro, biography,
                teaching_approach, image_path, image_alt
         FROM tutors
         WHERE is_active = 1
         ORDER BY sort_order ASC, display_name ASC"
    )->fetchAll();

    if (!$tutors) {
        return [];
    }

    $ids = array_map(static fn(array $tutor): int => (int)$tutor['id'], $tutors);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $statement = db()->prepare(
        "SELECT tutor_id, category, title, description
         FROM tutor_competencies
         WHERE tutor_id IN ($placeholders)
         ORDER BY tutor_id ASC, sort_order ASC, id ASC"
    );
    $statement->execute($ids);

    $competencies = [];
    foreach ($statement->fetchAll() as $item) {
        $competencies[(int)$item['tutor_id']][$item['category']][] = $item;
    }

    $reviewStatement = db()->prepare(
        "SELECT tutor_id, COUNT(*) AS review_count, ROUND(AVG(stars), 1) AS average_rating
         FROM tutor_reviews
         WHERE tutor_id IN ($placeholders) AND is_published = 1
         GROUP BY tutor_id"
    );
    $reviewStatement->execute($ids);
    $ratings = [];
    foreach ($reviewStatement->fetchAll() as $rating) {
        $ratings[(int)$rating['tutor_id']] = $rating;
    }

    foreach ($tutors as &$tutor) {
        $tutor['competencies'] = $competencies[(int)$tutor['id']] ?? [];
        $tutor['review_count'] = (int)($ratings[(int)$tutor['id']]['review_count'] ?? 0);
        $tutor['average_rating'] = (float)($ratings[(int)$tutor['id']]['average_rating'] ?? 0);
    }
    unset($tutor);

    return $tutors;
}

$tutors = loadTutors();
$categoryLabels = [
    'fach' => 'Fachliche Schwerpunkte',
    'methodik' => 'Methodische Kompetenzen',
    'didaktik' => 'Didaktische Kompetenzen',
    'faehigkeit' => 'Besondere Fähigkeiten',
    'qualifikation' => 'Qualifikationen und Erfahrung',
];
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Unser Tutorenteam</span></nav>
<section class="content-hero">
    <span class="eyebrow">Fachlich fundiert und pädagogisch durchdacht</span>
    <h1>Unser Tutorenteam</h1>
    <p class="lead">Jeder Tutor bringt eigene Fachkenntnisse, methodische Stärken und didaktische Erfahrungen ein. Die Profile werden direkt aus der Datenbank geladen und lassen sich dadurch zentral pflegen und erweitern.</p>
</section>

<?php if ($tutors === []): ?>
<section class="section">
    <div class="info-panel">
        <h2>Die Tutorprofile werden vorbereitet</h2>
        <p>Momentan konnten keine aktiven Tutorprofile aus der Datenbank geladen werden. Bitte prüfen Sie die Datenbankverbindung und den veröffentlichten Datenbestand.</p>
    </div>
</section>
<?php else: ?>
<section class="section tutor-list" aria-label="Tutorinnen und Tutoren">
<?php foreach ($tutors as $index => $tutor): ?>
    <article class="tutor-profile<?= $index % 2 === 1 ? ' tutor-profile--reverse' : '' ?>">
        <div class="tutor-profile__rating" aria-label="Bewertung: <?= number_format((float)$tutor['average_rating'], 1, ',', '.') ?> von 5 Sternen">
            <span class="star-rating" aria-hidden="true">★★★★★</span>
            <strong><?= number_format((float)$tutor['average_rating'], 1, ',', '.') ?> / 5</strong>
            <span><?= (int)$tutor['review_count'] ?> <?= (int)$tutor['review_count'] === 1 ? 'Bewertung' : 'Bewertungen' ?></span>
        </div>
        <div class="tutor-profile__portrait">
            <img src="<?= e((string)$tutor['image_path']) ?>" alt="<?= e((string)$tutor['image_alt']) ?>" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>" decoding="async">
            <a class="tutor-profile__reviews-link"
               href="tutor-bewertungen.php?tutor=<?= rawurlencode((string)$tutor['slug']) ?>"
               aria-label="Bewertungen für <?= e((string)$tutor['display_name']) ?> lesen">
                Bewertungen zu diesem Tutor lesen
            </a>
            <a class="button button--primary tutor-profile__trial-button"
               href="kontakt.php?anliegen=probestunde&amp;tutor=<?= rawurlencode((string)$tutor['slug']) ?>"
               aria-label="Probestunde bei <?= e((string)$tutor['display_name']) ?> vereinbaren">
                Probestunde vereinbaren
            </a>
        </div>
        <div class="tutor-profile__content">
            <span class="eyebrow">Tutorprofil</span>
            <h2><?= e((string)$tutor['display_name']) ?></h2>
            <p class="tutor-profile__title"><?= e((string)$tutor['professional_title']) ?></p>
            <p class="lead tutor-profile__intro"><?= e((string)$tutor['short_intro']) ?></p>

            <div class="tutor-profile__text">
                <div>
                    <h3>Fachlicher Hintergrund</h3>
                    <p><?= e((string)$tutor['biography']) ?></p>
                </div>
                <div>
                    <h3>Unterrichtsansatz</h3>
                    <p><?= e((string)$tutor['teaching_approach']) ?></p>
                </div>
            </div>

            <div class="tutor-competency-grid">
            <?php foreach ($categoryLabels as $category => $label): ?>
                <?php $items = $tutor['competencies'][$category] ?? []; ?>
                <?php if ($items !== []): ?>
                <section class="tutor-competency-card">
                    <h3><?= e($label) ?></h3>
                    <ul>
                    <?php foreach ($items as $item): ?>
                        <li>
                            <strong><?= e((string)$item['title']) ?></strong>
                            <?php if (!empty($item['description'])): ?><span><?= e((string)$item['description']) ?></span><?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </section>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        </div>
    </article>
<?php endforeach; ?>
</section>
<?php endif; ?>

<section class="section">
    <div class="cta">
        <div><span class="eyebrow">Passende Unterstützung finden</span><h2>Welcher Tutor passt zum Lernziel?</h2><p>In einem ersten Gespräch klären wir Fach, Schulform, Lernstand und Zielsetzung. Anschließend wird die fachlich und pädagogisch passende Begleitung ausgewählt.</p></div>
        <a class="button button--primary" href="kontakt.php">Kontakt aufnehmen</a>
    </div>
</section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>
