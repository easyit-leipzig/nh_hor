<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function career_config_jobs(): array
{
    $jobs = require __DIR__ . '/../config/jobs.php';
    return is_array($jobs) ? $jobs : [];
}

function career_tables_available(): bool
{
    if (!db_available()) return false;
    try {
        db()->query('SELECT 1 FROM career_jobs LIMIT 1');
        return true;
    } catch (Throwable $e) {
        return false;
    }
}

function career_all_jobs(bool $includeDrafts = false): array
{
    $fallback = career_config_jobs();
    if (!career_tables_available()) return $fallback;

    try {
        $sql = 'SELECT * FROM career_jobs' . ($includeDrafts ? '' : " WHERE status = 'published'") . ' ORDER BY sort_order, id';
        $rows = db()->query($sql)->fetchAll();
        if (!$rows) return $fallback;
        $result = [];
        foreach ($rows as $row) {
            $key = (string)$row['job_key'];
            $result[$key] = career_hydrate_job($row, $fallback[$key] ?? []);
        }
        return $result;
    } catch (Throwable $e) {
        error_log('[career repository] ' . $e->getMessage());
        return $fallback;
    }
}

function career_job(string $key, bool $includeDrafts = false): ?array
{
    $jobs = career_all_jobs($includeDrafts);
    return $jobs[$key] ?? null;
}

function career_hydrate_job(array $row, array $fallback): array
{
    $jobId = (int)$row['id'];
    $job = array_replace($fallback, [
        'id' => $jobId,
        'key' => (string)$row['job_key'],
        'code' => (string)$row['code'],
        'slug' => (string)$row['slug'],
        'title' => (string)$row['title'],
        'claim' => (string)$row['claim'],
        'intro' => (string)$row['intro'],
        'status' => (string)$row['status'],
        'sort_order' => (int)$row['sort_order'],
    ]);

    foreach (['subject'=>'subjects','value'=>'values','requirement'=>'requirements','profile'=>'profiles'] as $type => $target) {
        $stmt = db()->prepare('SELECT item_text FROM career_job_items WHERE career_job_id=:id AND item_type=:type ORDER BY sort_order,id');
        $stmt->execute(['id'=>$jobId,'type'=>$type]);
        $items = array_map(static fn(array $r): string => (string)$r['item_text'], $stmt->fetchAll());
        if ($items) $job[$target] = $items;
    }

    $stmt = db()->prepare("SELECT image_role,image_path AS src,alt_text AS alt,caption FROM career_images WHERE career_job_id=:id AND is_active=1 ORDER BY FIELD(image_role,'hero','card','gallery'),sort_order,id");
    $stmt->execute(['id'=>$jobId]);
    $images = $stmt->fetchAll();
    if ($images) {
        $card = []; $gallery = [];
        foreach ($images as $image) {
            $entry = ['src'=>(string)$image['src'],'alt'=>(string)$image['alt'],'caption'=>(string)($image['caption'] ?? '')];
            if ($image['image_role'] === 'card' && count($card) < 3) $card[] = $entry;
            if (in_array($image['image_role'], ['hero','gallery'], true)) $gallery[] = $entry;
        }
        if ($card) $job['images'] = $card;
        if ($gallery) $job['detail_images'] = $gallery;
    }

    $stmt = db()->prepare('SELECT question AS q,answer AS a FROM career_faq WHERE career_job_id=:id AND is_active=1 ORDER BY sort_order,id');
    $stmt->execute(['id'=>$jobId]);
    $faq = $stmt->fetchAll();
    if ($faq) $job['faq'] = $faq;
    return $job;
}
