<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
    return;

$IBLOCK_ID = 1; 

$arSections = [];
$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC', 'NAME' => 'ASC'), 
    array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y'),
    false,
    array('ID', 'NAME', 'SECTION_PAGE_URL', 'CODE')
);

while($arSection = $rsSections->GetNext())
{
    $url = '/news/?SECTION_ID=' . (int)$arSection['ID'];
    ?>
    <li class="presscenter-menu__item">
        <a href="<?= htmlspecialcharsbx($url) ?>" class="presscenter-menu__link">
            <?= htmlspecialcharsbx($arSection['NAME']) ?>
        </a>
    </li>
    <?php
}
?>