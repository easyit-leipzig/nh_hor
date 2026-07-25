<?php
declare(strict_types=1);

/**
 * easyIT Nachhilfe Leipzig – Bildnachweis
 * Öffentliche, vollständig datenbankgestützte Seite.
 */

require_once __DIR__ . '/includes/functions.php';

$site = require __DIR__ . '/config/site.php';

$pageTitle = 'Bildnachweis | easyIT Nachhilfe Leipzig';
$pageDescription = 'Bildquellen, Urheber, Lizenzen und Verwendungsorte der auf easyIT Nachhilfe Leipzig eingesetzten Bilder.';
$pageCanonical = rtrim((string) ($site['base_url'] ?? ''), '/')
    . rtrim((string) ($site['base_path'] ?? '/nh_hor'), '/')
    . '/bildnachweis.php';

/**
 * Nutzt die im Projekt vorhandene PDO-Funktion.
 * Unterstützt die üblichen Funktionsnamen db() und getDb().
 */
function imageCreditsPdo(): PDO
{
    if (function_exists('db')) {
        $pdo = db();
        if ($pdo instanceof PDO) {
            return $pdo;
        }
    }

    if (function_exists('getDb')) {
        $pdo = getDb();
        if ($pdo instanceof PDO) {
            return $pdo;
        }
    }

    $config = require __DIR__ . '/config/database.php';

    if (isset($config['dsn'], $config['user'], $config['password'])) {
        return new PDO(
            (string) $config['dsn'],
            (string) $config['user'],
            (string) $config['password'],
            (array) ($config['options'] ?? [])
        );
    }

    throw new RuntimeException('Keine Datenbankverbindung verfügbar.');
}

/** @return array<int,array<string,mixed>> */
function loadImageCredits(): array
{
    $sql = <<<'SQL'
        SELECT
            id,
            image_name,
            image_path,
            credit_from,
            credit_to,
            page_name,
            page_url,
            index_nr,
            author_name,
            author_url,
            source_name,
            source_url,
            license_name,
            license_url,
            note
        FROM image_credits
        WHERE active = 1
          AND (valid_from IS NULL OR valid_from <= CURRENT_DATE)
          AND (valid_until IS NULL OR valid_until >= CURRENT_DATE)
        ORDER BY
            page_name ASC,
            COALESCE(index_nr, 2147483647) ASC,
            image_name ASC,
            id ASC
    SQL;

    return imageCreditsPdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function imageCreditE(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function imageCreditLink(?string $url, ?string $label): string
{
    $url = trim((string) $url);
    $label = trim((string) $label);

    if ($label === '') {
        return '–';
    }

    if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
        return imageCreditE($label);
    }

    return '<a href="' . imageCreditE($url)
        . '" target="_blank" rel="noopener noreferrer">'
        . imageCreditE($label) . '</a>';
}

$credits = [];
$loadError = null;

try {
    $credits = loadImageCredits();
} catch (Throwable $exception) {
    $loadError = 'Der Bildnachweis konnte derzeit nicht aus der Datenbank geladen werden.';
}
?>
<!doctype html>
<html lang="de">
<head>
    <?php require __DIR__ . '/includes/meta.php'; ?>
    <link rel="stylesheet" href="<?= imageCreditE(rtrim((string) ($site['base_path'] ?? '/nh_hor'), '/')) ?>/assets/css/bildnachweis.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<div class="page-shell">
    <?php if (is_file(__DIR__ . '/includes/sidebar.php')): ?>
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    <?php endif; ?>

    <main class="main-content" id="hauptinhalt">
        <div class="content-wrap">
            <nav class="breadcrumbs" aria-label="Brotkrumen">
                <a href="<?= imageCreditE(rtrim((string) ($site['base_path'] ?? '/nh_hor'), '/')) ?>/">Startseite</a>
                <span>›</span>
                <span>Sonstiges</span>
                <span>›</span>
                <span aria-current="page">Bildnachweis</span>
            </nav>

            <section class="content-hero">
                <span class="eyebrow">Quellen und Nutzungsrechte</span>
                <h1>Bildnachweis</h1>
                <p class="lead">
                    Auf dieser Seite werden Urheber, Quellen, Lizenzen und Verwendungsorte
                    der auf dieser Website eingesetzten Bilder aufgeführt.
                </p>
            </section>

            <?php if ($loadError !== null): ?>
                <section class="section">
                    <div class="notice notice--error" role="alert">
                        <strong>Bildnachweis nicht verfügbar</strong>
                        <p><?= imageCreditE($loadError) ?></p>
                    </div>
                </section>
            <?php elseif ($credits === []): ?>
                <section class="section">
                    <div class="notice">
                        <strong>Noch keine aktiven Einträge</strong>
                        <p>In der Datenbank sind derzeit keine veröffentlichten Bildnachweise hinterlegt.</p>
                    </div>
                </section>
            <?php else: ?>
                <section class="section">
                    <div class="image-credits-summary">
                        <?= count($credits) ?> aktive<?= count($credits) === 1 ? 'r' : '' ?> Bildnachweis<?= count($credits) === 1 ? '' : 'e' ?>
                    </div>

                    <div class="image-credits-table-wrap">
                        <table class="image-credits-table">
                            <thead>
                            <tr>
                                <th scope="col">Index-Nr.</th>
                                <th scope="col">Bild</th>
                                <th scope="col">Von</th>
                                <th scope="col">Bis</th>
                                <th scope="col">Seite</th>
                                <th scope="col">Urheber</th>
                                <th scope="col">Quelle</th>
                                <th scope="col">Lizenz</th>
                                <th scope="col">Hinweis</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($credits as $credit): ?>
                                <tr>
                                    <td data-label="Index-Nr.">
                                        <?= $credit['index_nr'] === null ? '–' : (int) $credit['index_nr'] ?>
                                    </td>
                                    <td data-label="Bild">
                                        <strong><?= imageCreditE($credit['image_name']) ?></strong>
                                        <?php if (!empty($credit['image_path'])): ?>
                                            <small><?= imageCreditE($credit['image_path']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Von"><?= imageCreditE($credit['credit_from'] ?: '–') ?></td>
                                    <td data-label="Bis"><?= imageCreditE($credit['credit_to'] ?: '–') ?></td>
                                    <td data-label="Seite">
                                        <?php if (!empty($credit['page_url'])): ?>
                                            <a href="<?= imageCreditE($credit['page_url']) ?>">
                                                <?= imageCreditE($credit['page_name'] ?: $credit['page_url']) ?>
                                            </a>
                                        <?php else: ?>
                                            <?= imageCreditE($credit['page_name'] ?: '–') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Urheber">
                                        <?= imageCreditLink($credit['author_url'], $credit['author_name']) ?>
                                    </td>
                                    <td data-label="Quelle">
                                        <?= imageCreditLink($credit['source_url'], $credit['source_name']) ?>
                                    </td>
                                    <td data-label="Lizenz">
                                        <?= imageCreditLink($credit['license_url'], $credit['license_name']) ?>
                                    </td>
                                    <td data-label="Hinweis"><?= imageCreditE($credit['note'] ?: '–') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <?php require __DIR__ . '/includes/footer.php'; ?>
    </main>
</div>
</body>
</html>
