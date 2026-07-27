<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/database.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Tutorenteam | Olaf Thiele | Nachhilfe Leipzig | easyIT';
$pageDescription = 'Olaf Thiele begleitet Lernende in Mathematik, Physik, Chemie und Informatik. Reale Bewertungen heben Vorbereitung, Geduld, Struktur und Lernerfolge hervor.';
$pageCanonical = canonical_url($site, '/ueber-mich.php');

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

    $excerptStatement = db()->prepare(
        "SELECT tutor_id, reviewer_name, reviewer_context, review_text, stars
         FROM tutor_reviews
         WHERE tutor_id IN ($placeholders) AND is_published = 1
         ORDER BY review_date DESC, id DESC"
    );
    $excerptStatement->execute($ids);

    $excerpts = [];
    foreach ($excerptStatement->fetchAll() as $review) {
        $tutorId = (int)$review['tutor_id'];
        if (count($excerpts[$tutorId] ?? []) < 3) {
            $excerpts[$tutorId][] = $review;
        }
    }

    foreach ($tutors as &$tutor) {
        $id = (int)$tutor['id'];
        $tutor['competencies'] = $competencies[$id] ?? [];
        $tutor['review_count'] = (int)($ratings[$id]['review_count'] ?? 0);
        $tutor['average_rating'] = (float)($ratings[$id]['average_rating'] ?? 0);
        $tutor['review_excerpts'] = $excerpts[$id] ?? [];
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
<head>
<?php require __DIR__ . '/includes/meta.php'; ?>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/tutor-thiele.css')) ?>">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="<?= e(app_path('/index.php')) ?>">Startseite</a><span>›</span><span aria-current="page">Tutorenteam</span></nav>

<section class="content-hero tutor-team-hero">
    <span class="eyebrow">Persönlich, vorbereitet und verständnisorientiert</span>
    <h1>Unser Tutorenteam</h1>
    <p class="lead">Im Mittelpunkt stehen nicht vorgefertigte Standardlösungen, sondern die konkrete Lernsituation. Reale Rückmeldungen zu Olaf Thiele heben besonders die sorgfältige Vorbereitung, den klaren Stundenaufbau, geduldige Erklärungen und die persönliche Begleitung hervor.</p>
</section>

<?php if ($tutors === []): ?>
<section class="section">
    <div class="info-panel">
        <h2>Die Tutorprofile konnten nicht geladen werden</h2>
        <p>Bitte prüfen Sie die Datenbankverbindung sowie die Tabellen <code>tutors</code>, <code>tutor_competencies</code> und <code>tutor_reviews</code>.</p>
    </div>
</section>
<?php else: ?>
<section class="section tutor-list" aria-label="Tutorinnen und Tutoren">
<?php foreach ($tutors as $index => $tutor): ?>
    <article class="tutor-profile<?= $index % 2 === 1 ? ' tutor-profile--reverse' : '' ?>">
        <div class="tutor-profile__rating" aria-label="Bewertung: <?= number_format((float)$tutor['average_rating'], 1, ',', '.') ?> von 5 Sternen">
            <span class="star-rating" aria-hidden="true">★★★★★</span>
            <strong><?= number_format((float)$tutor['average_rating'], 1, ',', '.') ?> / 5</strong>
            <span><?= (int)$tutor['review_count'] ?> <?= (int)$tutor['review_count'] === 1 ? 'veröffentlichte Bewertung' : 'veröffentlichte Bewertungen' ?></span>
        </div>

        <div class="tutor-profile__portrait">
            <img src="<?= e(app_path((string)$tutor['image_path'])) ?>" alt="<?= e((string)$tutor['image_alt']) ?>" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>" decoding="async">
            <a class="tutor-profile__reviews-link"
               href="<?= e(app_path('/tutor-bewertungen.php')) ?>?tutor=<?= rawurlencode((string)$tutor['slug']) ?>">
                Alle Bewertungen lesen
            </a>
            <a class="button button--primary tutor-profile__trial-button"
               href="<?= e(app_path('/kontakt.php')) ?>?anliegen=probestunde&amp;tutor=<?= rawurlencode((string)$tutor['slug']) ?>">
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

            <div class="review-strengths" aria-label="Aus realen Bewertungen abgeleitete Stärken">
                <h3>Was Lernende und Eltern konkret hervorheben</h3>
                <div class="review-strengths__grid">
                    <div><strong>Vorbereitet</strong><span>Individuelle Aufgaben liegen bereits vor Unterrichtsbeginn bereit.</span></div>
                    <div><strong>Strukturiert</strong><span>Einstieg, Arbeitsphase und Reflexion geben jeder Stunde einen klaren Rahmen.</span></div>
                    <div><strong>Geduldig</strong><span>Fragen dürfen wiederholt gestellt werden; Inhalte werden auf neuen Wegen erklärt.</span></div>
                    <div><strong>Wirksam</strong><span>Mehrere Eltern berichten über deutlich verbesserte Mathematiknoten.</span></div>
                </div>
            </div>

            <?php if (($tutor['review_excerpts'] ?? []) !== []): ?>
            <div class="tutor-inline-reviews">
                <h3>Ausgewählte reale Bewertungen</h3>
                <div class="tutor-inline-reviews__grid">
                <?php foreach ($tutor['review_excerpts'] as $review): ?>
                    <blockquote>
                        <div class="star-rating" aria-hidden="true"><?= str_repeat('★', (int)$review['stars']) ?></div>
                        <p>„<?= e((string)$review['review_text']) ?>“</p>
                        <footer>
                            <strong><?= e((string)$review['reviewer_name']) ?></strong>
                            <?php if (!empty($review['reviewer_context'])): ?><span><?= e((string)$review['reviewer_context']) ?></span><?php endif; ?>
                        </footer>
                    </blockquote>
                <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

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

<section class="section tutor-transparency">
    <span class="eyebrow">Transparenz</span>
    <h2>Grundlage der dargestellten Aussagen</h2>
    <p>Die veröffentlichten Bewertungen beruhen auf tatsächlich vorliegenden Rückmeldungen. Öffentliche Online-Bewertungen werden mit dem dort verwendeten Namen geführt. Persönlich übermittelte Rückmeldungen erscheinen nur anonymisiert. Texte können aus Gründen der Lesbarkeit behutsam gekürzt werden; die Kernaussage bleibt unverändert.</p>
</section>

<section class="section">
    <div class="cta">
        <div><span class="eyebrow">Passende Unterstützung finden</span><h2>Passt Olaf Thiele zum Lernziel?</h2><p>In einem ersten Gespräch werden Fach, Schulform, Lernstand und Zielsetzung geklärt.</p></div>
        <a class="button button--primary" href="<?= e(app_path('/kontakt.php')) ?>">Kontakt aufnehmen</a>
    </div>
</section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>
