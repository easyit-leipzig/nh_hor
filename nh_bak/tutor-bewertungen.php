<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/database.php';
$site = require __DIR__ . '/config/site.php';

$slug = trim((string)($_GET['tutor'] ?? ''));
$tutor = null;
$reviews = [];

if ($slug !== '' && db_available()) {
    $statement = db()->prepare(
        "SELECT id, slug, display_name, professional_title, image_path, image_alt
         FROM tutors
         WHERE slug = ? AND is_active = 1
         LIMIT 1"
    );
    $statement->execute([$slug]);
    $tutor = $statement->fetch() ?: null;

    if ($tutor) {
        $reviewStatement = db()->prepare(
            "SELECT reviewer_name, reviewer_context, review_date, stars, review_text
             FROM tutor_reviews
             WHERE tutor_id = ? AND is_published = 1
             ORDER BY review_date DESC, id DESC"
        );
        $reviewStatement->execute([(int)$tutor['id']]);
        $reviews = $reviewStatement->fetchAll();
    }
}

if (!$tutor) {
    http_response_code(404);
    $pageTitle = 'Tutor nicht gefunden | easyIT Nachhilfe Leipzig';
    $pageDescription = 'Das angeforderte Tutorprofil wurde nicht gefunden.';
    $pageCanonical = $site['base_url'] . '/ueber-mich.php';
} else {
    $pageTitle = 'Bewertungen für ' . $tutor['display_name'] . ' | easyIT Leipzig';
    $pageDescription = 'Erfahrungen und Bewertungen von Lernenden für ' . $tutor['display_name'] . '.';
    $pageCanonical = canonical_url($site, '/tutor-bewertungen.php', ['tutor' => (string)$tutor['slug']]);
}

$average = $reviews ? array_sum(array_map(static fn(array $review): int => (int)$review['stars'], $reviews)) / count($reviews) : 0;
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><a href="ueber-mich.php">Tutorenteam</a><span>›</span><span aria-current="page">Bewertungen</span></nav>

<?php if (!$tutor): ?>
<section class="content-hero"><span class="eyebrow">Nicht gefunden</span><h1>Tutorprofil nicht gefunden</h1><p class="lead">Das angeforderte Tutorprofil ist nicht verfügbar.</p></section>
<section class="section"><a class="button button--primary" href="ueber-mich.php">Zum Tutorenteam</a></section>
<?php else: ?>
<section class="content-hero tutor-review-hero">
    <img src="<?= e((string)$tutor['image_path']) ?>" alt="<?= e((string)$tutor['image_alt']) ?>">
    <div>
        <span class="eyebrow">Erfahrungen von Lernenden</span>
        <h1>Bewertungen für <?= e((string)$tutor['display_name']) ?></h1>
        <p class="tutor-profile__title"><?= e((string)$tutor['professional_title']) ?></p>
        <div class="tutor-review-summary" aria-label="Durchschnittliche Bewertung <?= number_format($average, 1, ',', '.') ?> von 5 Sternen">
            <span class="star-rating" aria-hidden="true">★★★★★</span>
            <strong><?= number_format($average, 1, ',', '.') ?> / 5</strong>
            <span>aus <?= count($reviews) ?> <?= count($reviews) === 1 ? 'Bewertung' : 'Bewertungen' ?></span>
        </div>
    </div>
</section>

<section class="section">
<?php if ($reviews === []): ?>
    <div class="info-panel"><h2>Noch keine veröffentlichten Bewertungen</h2><p>Für diesen Tutor liegen derzeit keine freigegebenen Bewertungen vor.</p></div>
<?php else: ?>
    <div class="tutor-review-grid">
    <?php foreach ($reviews as $review): ?>
        <article class="tutor-review-card">
            <div class="tutor-review-card__stars" aria-label="<?= (int)$review['stars'] ?> von 5 Sternen">
                <span class="star-rating" aria-hidden="true"><?= str_repeat('★', (int)$review['stars']) ?><span class="star-rating--empty"><?= str_repeat('★', 5 - (int)$review['stars']) ?></span></span>
            </div>
            <blockquote>“<?= e((string)$review['review_text']) ?>”</blockquote>
            <footer>
                <strong><?= e((string)$review['reviewer_name']) ?></strong>
                <?php if (!empty($review['reviewer_context'])): ?><span><?= e((string)$review['reviewer_context']) ?></span><?php endif; ?>
                <time datetime="<?= e((string)$review['review_date']) ?>"><?= e(date('d.m.Y', strtotime((string)$review['review_date']))) ?></time>
            </footer>
        </article>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
</section>

<section class="section"><div class="cta"><div><span class="eyebrow">Unverbindlich kennenlernen</span><h2>Probestunde mit <?= e((string)$tutor['display_name']) ?> vereinbaren</h2><p>Im ersten Termin klären wir Lernstand, Ziel und die passende Form der Unterstützung.</p></div><a class="button button--primary" href="kontakt.php?anliegen=probestunde&amp;tutor=<?= rawurlencode((string)$tutor['slug']) ?>">Probestunde vereinbaren</a></div></section>
<?php endif; ?>
</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>
