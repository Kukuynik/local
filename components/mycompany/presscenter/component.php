<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    ShowError('Модуль инфоблоков не установлен');
    return;
}

$arParams['IBLOCK_ID'] = (int)($arParams['IBLOCK_ID'] ?? 0);
$arParams['SEF_FOLDER'] = trim((string)($arParams['SEF_FOLDER'] ?? '/press-center/'), '/').'/';

$arVariables = [];
$componentPage = 'list'; // по-умолчанию список

$curPage = $APPLICATION->GetCurPage();
$sefFolder = '/'.$arParams['SEF_FOLDER'];
$relativeUrl = substr($curPage, strlen($sefFolder));
$relativeUrl = ltrim($relativeUrl, '/');

if ($relativeUrl !== '' && $relativeUrl !== 'index.php') {
    // Детальная
    $componentPage = 'detail';
    $arVariables['ELEMENT_CODE'] = trim($relativeUrl, '/');
}
$arResult["FOLDER"] = $sefFolder;
$arResult["VARIABLES"] = $arVariables;

$this->IncludeComponentTemplate($componentPage);