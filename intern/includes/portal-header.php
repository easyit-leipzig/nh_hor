<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_login();
$user = internal_user();
$role = (string)$user['role_key'];

$menus = [
    'mitarbeiter' => [
        ['label' => 'Übersicht', 'url' => '/intern/mitarbeiter/index.php', 'permission' => null],
        ['label' => 'Schüler', 'url' => '/intern/mitarbeiter/index.php#schueler', 'permission' => 'students.manage'],
        ['label' => 'Termine', 'url' => '/intern/mitarbeiter/index.php#termine', 'permission' => 'appointments.manage'],
        ['label' => 'Nachrichten', 'url' => '/intern/mitarbeiter/index.php#nachrichten', 'permission' => 'messages.manage'],
        ['label' => 'Angebote', 'url' => '/intern/mitarbeiter/index.php#angebote', 'permission' => 'offers.manage'],
    ],
    'lehrer' => [
        ['label' => 'Übersicht', 'url' => '/intern/lehrer/index.php', 'permission' => null],
        ['label' => 'Meine Schüler', 'url' => '/intern/lehrer/index.php#schueler', 'permission' => 'students.view_own'],
        ['label' => 'Meine Termine', 'url' => '/intern/lehrer/index.php#termine', 'permission' => 'appointments.view_own'],
        ['label' => 'Dokumentation', 'url' => '/intern/lehrer/index.php#dokumentation', 'permission' => 'lessons.document'],
        ['label' => 'Nachrichten', 'url' => '/intern/lehrer/index.php#nachrichten', 'permission' => 'messages.use'],
    ],
    'schueler' => [
        ['label' => 'Übersicht', 'url' => '/intern/schueler/index.php', 'permission' => null],
        ['label' => 'Termine', 'url' => '/intern/schueler/index.php#termine', 'permission' => 'appointments.view_own'],
        ['label' => 'Aufgaben', 'url' => '/intern/schueler/index.php#aufgaben', 'permission' => 'tasks.view_own'],
        ['label' => 'Dokumente', 'url' => '/intern/schueler/index.php#dokumente', 'permission' => 'documents.view_own'],
        ['label' => 'Nachrichten', 'url' => '/intern/schueler/index.php#nachrichten', 'permission' => 'messages.use'],
    ],
    'eltern' => [
        ['label' => 'Übersicht', 'url' => '/intern/eltern/index.php', 'permission' => null],
        ['label' => 'Zugeordnete Schüler', 'url' => '/intern/eltern/index.php#schueler', 'permission' => 'children.view'],
        ['label' => 'Termine', 'url' => '/intern/eltern/index.php#termine', 'permission' => 'appointments.view_children'],
        ['label' => 'Mitteilungen', 'url' => '/intern/eltern/index.php#mitteilungen', 'permission' => 'messages.use'],
        ['label' => 'Angebote', 'url' => '/intern/eltern/index.php#angebote', 'permission' => 'offers.view_own'],
    ],
    'viewer' => [
        ['label' => 'Übersicht', 'url' => '/intern/viewer/index.php', 'permission' => null],
        ['label' => 'Freigegebene Inhalte', 'url' => '/intern/viewer/index.php#inhalte', 'permission' => 'content.view'],
        ['label' => 'Downloads', 'url' => '/intern/viewer/index.php#downloads', 'permission' => 'downloads.view'],
    ],
];

$items = $menus[$role] ?? [];
?><!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($portalTitle ?? 'Interner Bereich') ?> | easyIT</title>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/internal.css')) ?>">
</head>
<body class="internal-portal">
<header class="internal-topbar">
<a href="<?= e(internal_start_path()) ?>" class="internal-topbar__brand">easyIT intern</a>
<div>
<span><?= e((string)$user['display_name']) ?> · <?= e((string)$user['role_name']) ?></span>
<a href="<?= e(app_path('/intern/logout.php')) ?>">Abmelden</a>
</div>
</header>
<div class="internal-shell">
<nav class="internal-nav" aria-label="Interne Navigation">
<?php foreach ($items as $item): ?>
<?php if ($item['permission'] === null || internal_can($item['permission'])): ?>
<a href="<?= e(app_path($item['url'])) ?>"><?= e($item['label']) ?></a>
<?php endif; ?>
<?php endforeach; ?>
</nav>
<main class="internal-main">
