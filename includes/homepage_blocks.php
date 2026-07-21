<?php
declare(strict_types=1);

function homepage_blocks(): array
{
    static $blocks=null;
    if ($blocks!==null) return $blocks;
    $blocks=[];
    if (!db_available()) return $blocks;
    try {
        $stmt=db()->query("SELECT * FROM homepage_blocks WHERE active=1 AND (valid_from IS NULL OR valid_from<=CURDATE()) AND (valid_until IS NULL OR valid_until>=CURDATE()) ORDER BY position,id");
        $blocks=$stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) { error_log('[homepage blocks] '.$e->getMessage()); }
    return $blocks;
}

function render_homepage_blocks(): void
{
    foreach(homepage_blocks() as $block){
        $type=(string)$block['block_type'];
        $class='homepage-block homepage-block--'.preg_replace('/[^a-z0-9_-]/i','',$type);
        echo '<section class="'.e($class).'">';
        echo '<div class="homepage-block__media">';
        if(!empty($block['image'])){
            $crop=!empty($block['image_crop']) ? ' homepage-block__image--'.preg_replace('/[^a-z0-9_-]/i','',(string)$block['image_crop']) : '';
            $imagePath=(string)$block['image'];
            if(str_starts_with($imagePath,'blocks/') || str_starts_with($imagePath,'img/blocks/')){
                $imagePath='assets/img/'.$imagePath;
            }
            echo '<img src="'.e($imagePath).'" alt="'.e($block['title']??'').'" class="homepage-block__image'.e($crop).'">';
        }
        if(!empty($block['sticker'])){
            $pos=!empty($block['sticker_position']) ? preg_replace('/[^a-z0-9_-]/i','',(string)$block['sticker_position']) : 'top-right';
            $src=!empty($block['sticker_image']) ? $block['sticker_image'] : 'assets/img/blocks/sticker_sheet.png';
            if(str_starts_with($src,'blocks/') || str_starts_with($src,'img/blocks/')){
                $src='assets/img/'.$src;
            }
            echo '<div class="homepage-block__sticker homepage-block__sticker--'.e($pos).' homepage-block__sticker--'.e($block['sticker']).'">';
            echo '<img src="'.e($src).'" alt="'.e($block['sticker']).'">';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="homepage-block__content">';
        echo '<h2>'.e($block['title']??'').'</h2>';
        echo '<p>'.nl2br(e($block['content']??'')).'</p>';
        if(!empty($block['button_url'])) echo '<a class="button button--blue" href="'.e($block['button_url']).'">'.e($block['button_text']??'Mehr erfahren').'</a>';
        echo '</div></section>';
    }
}
