<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<?php
$main = [];
$others = [];
$res = CIBlockElement::GetList(
    ["PROPERTY_MAIN" => "DESC", "ACTIVE_FROM" => "DESC"],
    ["IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"],
    false,
    false,
    ["ID", "NAME", "CODE", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE", "PROPERTY_THEME", "PROPERTY_MAIN"]
);
while ($row = $res->GetNext()) {
    $row["DETAIL_PAGE_URL"] = $arResult["FOLDER"] . $row["CODE"] . '/';
    if ($row['PROPERTY_MAIN_VALUE'] === 'Y') $main[] = $row;
    else $others[] = $row;
}
?>
<div class="news-page">
    <?php if (!empty($main)): ?>
        <div class="news-page__main">
            <?php foreach ($main as $news): ?>
                <article class="news news--main">
                    <?php if ($news["PREVIEW_PICTURE"]): ?>
                        <div class="news__illustration">
                            <img src="<?= CFile::GetPath($news["PREVIEW_PICTURE"]) ?>" alt="<?= htmlspecialchars($news['NAME']) ?>">
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

    <div class="news-page__list">
        <?php foreach ($others as $news): ?>
            <article class="news">
                <?php if ($news["PREVIEW_PICTURE"]): ?>
                    <div class="news__illustration">
                        <img src="<?= CFile::GetPath($news["PREVIEW_PICTURE"]) ?>" alt="<?= htmlspecialchars($news['NAME']) ?>">
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
</div>
</section>