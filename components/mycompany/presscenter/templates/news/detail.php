<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$code = $arResult["VARIABLES"]["ELEMENT_CODE"];
$res = CIBlockElement::GetList(
    [],
    ["IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "CODE" => $code],
    false,
    false,
    ["ID", "NAME", "DETAIL_PICTURE", "DETAIL_TEXT", "DATE_ACTIVE_FROM", "PROPERTY_THEME"]
);
if (!$row = $res->GetNext()) {
    ShowError("Новость не найдена.");
    return;
}
?>
<div class="page">
    <section class="article-section" data-controller="article-content">
        <header class="article__header">
            <h1 class="article__title"><?= $row["NAME"] ?></h1>
            <div class="article__header-info">
                <div class="article__publication-info content-block">
                    <time class="article__publication-date"><?= FormatDate("d F Y", MakeTimeStamp($row["DATE_ACTIVE_FROM"])) ?></time>
                </div>
            </div>
        </header>
        <div class="article__content-wrapper">
            <div class="article__content content-block">
                <?php if ($row["DETAIL_PICTURE"]): ?>
                    <img src="<?= CFile::GetPath($row["DETAIL_PICTURE"]) ?>" class="article__image" alt="<?= htmlspecialchars($row['NAME']) ?>">
                <?php endif; ?>
                <?php if ($row["DETAIL_TEXT"]): ?><?= $row["DETAIL_TEXT"] ?><?php endif; ?>
            </div>
        </div>
        <?php if (!empty($row["PROPERTY_THEME_VALUE"])): ?>
            <section class="article-section">
                <div class="article__content-wrapper article__topics-wrapper">
                    <h3 class="article__topics-title">Темы</h3>
                    <ul class="article__topics">
                        <?php foreach ((array)$row["PROPERTY_THEME_VALUE"] as $theme): ?>
                            <li class="article__topic-item">
                                <span class="article__topic-link button button--secondary button--tiny"><?= htmlspecialchars($theme) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        <?php endif; ?>
    </section>
</div>