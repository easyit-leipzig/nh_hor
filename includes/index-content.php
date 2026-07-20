<?php
declare(strict_types=1);
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../config/bootstrap.php';

/** @return array<int,array<string,list<array<string,mixed>>>> */
function index_content_blocks(): array
{
    static $grouped = null;
    if (is_array($grouped)) {
        return $grouped;
    }
    $grouped = [];
    if (!db_available()) {
        return $grouped;
    }
    try {
        $sql = "SELECT id,internal_name,title,position_no,placement,html_content,css_content,js_content,wrapper_class,sort_order
                FROM add_index_content
                WHERE active=1
                  AND (valid_from IS NULL OR valid_from<=NOW())
                  AND (valid_until IS NULL OR valid_until>=NOW())
                ORDER BY position_no, FIELD(placement,'before','replace','after'), sort_order, id";
        foreach (db()->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $position = (int)$row['position_no'];
            $placement = (string)$row['placement'];
            if (!in_array($placement, ['before','after','replace'], true)) {
                continue;
            }
            $grouped[$position][$placement][] = $row;
        }
    } catch (Throwable $e) {
        error_log('[easyIT index content] ' . $e->getMessage());
    }
    return $grouped;
}

function index_content_has_replace(int $position): bool
{
    return !empty(index_content_blocks()[$position]['replace']);
}

function render_index_content(int $position, string $placement): void
{
    $blocks = index_content_blocks()[$position][$placement] ?? [];
    foreach ($blocks as $block) {
        $id = (int)$block['id'];
        $classes = trim('dynamic-index-content ' . (string)$block['wrapper_class']);
        $safeClasses = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $classes) ?: 'dynamic-index-content';
        echo '<section class="' . e($safeClasses) . '" data-index-content-id="' . $id . '" data-index-position="' . $position . '">';
        echo (string)$block['html_content'];
        echo '</section>';
        $css = trim((string)($block['css_content'] ?? ''));
        if ($css !== '') {
            echo '<style nonce="' . e(security_csp_nonce()) . '" data-index-content-style="' . $id . '">' . $css . '</style>';
        }
        $js = trim((string)($block['js_content'] ?? ''));
        if ($js !== '') {
            echo '<script nonce="' . e(security_csp_nonce()) . '" data-index-content-script="' . $id . '">' . $js . '</script>';
        }
    }
}
