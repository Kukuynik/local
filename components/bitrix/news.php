<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="page-section events-page">
    <div class="page-section__heading">
        <h1>Пресс центр</h1>
    </div>
    <div data-controller="tabs" class="tabs">
        <div class="tabs__buttons-scroll-wrapper">
            <div class="tabs__buttons-wrapper">
                <button data-tabs-target="button" data-controller="wave" class="tabs__button active">
                    <span class="tabs__button-text"> Все </span>
                </button>
            </div>
        </div>
        <div class="tabs__content-wrapper">
            <div data-tabs-target="wrapper" id="all" class="tabs__content" data-controller="view-more">
                <div class="news-list event-list" data-view-more-target="container">
                    <?php
                    // Сначала главная новость (MAIN == Y), потом остальные
                    $main = [];
                    $others = [];
                    foreach ($arResult["ITEMS"] as $item) {
                        if ($item["PROPERTIES"]["MAIN"]["VALUE"] == "Y") $main[] = $item;
                        else $others[] = $item;
                    }
                    $displayItems = array_merge($main, $others);
                    foreach ($displayItems as $arItem): 
                        // Анонс
                        $img = is_array($arItem["PREVIEW_PICTURE"]) ? $arItem["PREVIEW_PICTURE"]["SRC"] : "";
                        $alt = is_array($arItem["PREVIEW_PICTURE"]) ? $arItem["PREVIEW_PICTURE"]["ALT"] : "";
                        ?>
                        <article class="news<?=($arItem["PROPERTIES"]["MAIN"]["VALUE"]=="Y"?' news--main':'')?>">
                            <?php if ($img): ?>
                                <div class="news__illustration<?=($arItem["PREVIEW_PICTURE"]["HEIGHT"] > $arItem["PREVIEW_PICTURE"]["WIDTH"] ? ' news__illustration--vertical' : '')?>">
                                    <img src="<?=$img?>" alt="<?=htmlspecialchars($alt ?: $arItem['NAME'])?>" class="news__illustration-image"/>
                                </div>
                            <?php endif; ?>
                            <a class="news__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                <h2 class="news__title"><?=htmlspecialchars($arItem["NAME"])?></h2>
                            </a>
                            <?php if (!empty($arItem["PROPERTIES"]["THEMES"]["VALUE"])): ?>
                                <div class="news__publication-info">
                                    <?php foreach ((array)$arItem["PROPERTIES"]["THEMES"]["VALUE"] as $theme): ?>
                                        <span class="news__topic-link"><?=htmlspecialchars($theme)?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="news__publication-detail">
                                <svg class="icon" role="img">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/icons.svg#clock"/>
                                </svg>
                                <?=$arItem["DISPLAY_ACTIVE_FROM"]?>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
                <?php if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                    <?=$arResult["NAV_STRING"]?>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>