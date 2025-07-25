<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Если явно нужно меню разделов — подключаем
include($_SERVER["DOCUMENT_ROOT"]."/local/include/presscenter_sections_menu.php"); 
?>

<section class="news-catalog">

<?php
if (!empty($arResult['ELEMENTS_MAIN'])): ?>
    <div class="news-page__main">
        <?php foreach ($arResult['ELEMENTS_MAIN'] as $news): ?>
            <article class="news news--main">
                <?php if ($news["PREVIEW_PICTURE"]): ?>
                    <div class="news__illustration">
                        <img src="<?= CFile::GetPath($news["PREVIEW_PICTURE"]) ?>" alt="<?= htmlspecialchars($news['NAME']) ?>" class="news__illustration-image">
                    </div>
                <?php endif; ?>
                <a class="news__link" href="<?= $news["DETAIL_PAGE_URL"] ?>">
                    <h2 class="news__title"><?= htmlspecialchars($news["NAME"]) ?></h2>
                </a>
                <?php if ($news["PROPERTY_THEME_VALUE"]): ?>
                    <div class="news__publication-info">
                        <?php foreach ((array)$news["PROPERTY_THEME_VALUE"] as $theme): ?>
                            <span class="news__topic-link"><?= htmlspecialchars($theme) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="news__publication-detail">
                    <svg class="icon" role="img">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/icons.svg#clock"></use>
                    </svg>
                    <?= FormatDate("d F Y", MakeTimeStamp($news["DATE_ACTIVE_FROM"])) ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
// --- "Остальные" новости ---
if (!empty($arResult['ELEMENTS_OTHERS'])): ?>
    <div class="news-page__list">
        <?php foreach ($arResult['ELEMENTS_OTHERS'] as $news): ?>
            <article class="news">
                <?php if ($news["PREVIEW_PICTURE"]): ?>
                    <div class="news__illustration">
                        <img src="<?= CFile::GetPath($news["PREVIEW_PICTURE"]) ?>" alt="<?= htmlspecialchars($news['NAME']) ?>" class="news__illustration-image">
                    </div>
                <?php endif; ?>
                <a class="news__link" href="<?= $news["DETAIL_PAGE_URL"] ?>">
                    <h2 class="news__title"><?= htmlspecialchars($news["NAME"]) ?></h2>
                </a>
                <?php if ($news["PROPERTY_THEME_VALUE"]): ?>
                    <div class="news__publication-info">
                        <?php foreach ((array)$news["PROPERTY_THEME_VALUE"] as $theme): ?>
                            <span class="news__topic-link"><?= htmlspecialchars($theme) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="news__publication-detail">
                    <svg class="icon" role="img">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/icons.svg#clock"></use>
                    </svg>
                    <?= FormatDate("d F Y", MakeTimeStamp($news["DATE_ACTIVE_FROM"])) ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</section>