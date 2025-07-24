<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="article-section" data-controller="article-content">
    <header class="article__header">
        <h1 class="article__title">
            <?=$arResult["NAME"]?>
        </h1>
        <div class="article__header-info">
            <div class="article__publication-info content-block">
                <time class="article__publication-date" datetime="<?=$arResult["ACTIVE_FROM"]?>">
                    <?=$arResult["DISPLAY_ACTIVE_FROM"]?>
                </time>
                <?php if(!empty($arResult["PROPERTIES"]["THEMES"]["VALUE"])): ?>
                    <div class="article__publication-place"><?=implode(", ", $arResult["PROPERTIES"]["THEMES"]["VALUE"]);?></div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div class="article__content-wrapper">
        <div class="article__content content-block">
            <?php if(is_array($arResult["DETAIL_PICTURE"])): ?>
                <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="article__image" alt="<?=htmlspecialchars($arResult["DETAIL_PICTURE"]["ALT"])?>" />
            <?php endif;?>
            <?php if($arResult["DETAIL_TEXT"]): ?>
                <?=$arResult["DETAIL_TEXT"]?>
            <?php endif;?>
        </div>
    </div>
</section>
<?php if (!empty($arResult["PROPERTIES"]["THEMES"]["VALUE"])): ?>
<section class="article-section">
    <div class="article__content-wrapper article__topics-wrapper">
        <h3 class="article__topics-title">Темы</h3>
        <ul class="article__topics">
            <?php foreach ($arResult["PROPERTIES"]["THEMES"]["VALUE"] as $theme): ?>
                <li class="article__topic-item">
                    <span class="article__topic-link button button--secondary button--tiny"><?=htmlspecialchars($theme)?></span>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</section>
<?php endif;?>