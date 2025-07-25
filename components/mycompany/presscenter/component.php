<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    ShowError('Модуль инфоблоков не установлен');
    return;
}

$iblockType = $arParams['IBLOCK_TYPE'] ?? 'news';
$iblockCode = $arParams['IBLOCK_CODE'] ?? 'press_center'; // или параметр
$iblockId = (int)($arParams['IBLOCK_ID'] ?? 0);

if (!$iblockId) {
    $res = CIBlock::GetList([], [
        'TYPE' => $iblockType,
        'ACTIVE' => 'Y',
        'CODE' => $iblockCode
    ]);
    if ($iblock = $res->Fetch()) {
        $iblockId = (int)$iblock['ID'];
    }
}

if(!$iblockId) {
    ShowError("Инфоблок не найден");
    return;
}

$arParams['SEF_FOLDER'] = trim((string)($arParams['SEF_FOLDER'] ?? '/press-center/'), '/').'/';
$sefFolder = '/'.$arParams['SEF_FOLDER'];

$curPage = $APPLICATION->GetCurPage();
$relativeUrl = substr($curPage, strlen($sefFolder));
$relativeUrl = ltrim($relativeUrl, '/');

$arVariables = [];
$componentPage = 'list';

if ($relativeUrl !== '' && $relativeUrl !== 'index.php') {
    $componentPage = 'detail';
    $arVariables['ELEMENT_CODE'] = trim($relativeUrl, '/');
}


if ($componentPage == 'list') {
    $arSections = [];
    $rsSections = CIBlockSection::GetList(
        ['SORT'=>'ASC','NAME'=>'ASC'],
        ['IBLOCK_ID'=>$iblockId, 'ACTIVE'=>'Y', 'GLOBAL_ACTIVE'=>'Y'],
        false,
        ['ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL']
    );
    while ($arSection = $rsSections->GetNext()) {
        $arSections[$arSection['ID']] = $arSection;
        $arSections[$arSection['ID']]['ELEMENTS'] = [];
    }

    $rsElements = CIBlockElement::GetList(
        ['SORT'=>'ASC'],
        ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
        false, false,
        ['ID', 'NAME', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID']
    );

    while ($arItem = $rsElements->GetNext()) {
        if($arItem['IBLOCK_SECTION_ID'] && isset($arSections[$arItem['IBLOCK_SECTION_ID']])) {
            $arSections[$arItem['IBLOCK_SECTION_ID']]['ELEMENTS'][] = $arItem;
        } else {
            $arSections[0]['ELEMENTS'][] = $arItem; 
        }
    }

    $arResult['SECTIONS'] = $arSections;
}

if ($componentPage == 'detail' && !empty($arVariables['ELEMENT_CODE'])) {
    $arSelect = ["ID", "NAME", "DETAIL_PICTURE", "DETAIL_TEXT", "DETAIL_PAGE_URL"];
    $arFilter = [
        "IBLOCK_ID" => $iblockId,
        "ACTIVE" => "Y",
        "CODE" => $arVariables['ELEMENT_CODE']
    ];
    $rsElement = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
    if ($arElement = $rsElement->GetNext()) {
        $arResult['ELEMENT'] = $arElement;
    } else {
        ShowError("Элемент не найден");
        return;
    }
}

$arResult["FOLDER"] = $sefFolder;
$arResult["VARIABLES"] = $arVariables;

$main = [];
$others = [];
$rs = CIBlockElement::GetList(
    ["PROPERTY_MAIN" => "DESC", "ACTIVE_FROM" => "DESC"],
    ["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"],
    false,
    false,
    ["ID", "NAME", "CODE", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE", "PROPERTY_THEME", "PROPERTY_MAIN"]
);
while ($row = $rs->GetNext()) {
    $row["DETAIL_PAGE_URL"] = $arResult["FOLDER"] . $row["CODE"] . '/';
    if ($row['PROPERTY_MAIN_VALUE'] === 'Y') $main[] = $row;
    else $others[] = $row;
}
$arResult['ELEMENTS_MAIN'] = $main;
$arResult['ELEMENTS_OTHERS'] = $others;

$this->IncludeComponentTemplate($componentPage);
?>