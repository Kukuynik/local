<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>


<?php
$componentPage = '';
if (!empty($arResult["VARIABLES"]["ELEMENT_CODE"]) || !empty($arResult["VARIABLES"]["ELEMENT_ID"])) {
    $componentPage = "detail";
} else {
    $componentPage = "news";
}

if ($componentPage === "detail") {
    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "", // имя шаблона detail (например, "custom_detail")
        $arParams,
        $component
    );
} else {
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "", // имя шаблона list (например, "custom_list")
        $arParams,
        $component
    );
}
?>