<?php
use Bitrix\Main\Loader;

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "SetUniqueMainNews");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "SetUniqueMainNews");

function SetUniqueMainNews($arFields) {
    $IBLOCK_ID = 1;
    $PROPERTY_CODE = 'MAIN';
    $MAIN_VALUE = 'Y';   

    if (!Loader::includeModule('iblock'))
        return;

    $ELEMENT_ID = 0;
    if (is_array($arFields) && isset($arFields['ID'])) {
        $ELEMENT_ID = intval($arFields['ID']);
    } elseif (is_numeric($arFields)) {
        $ELEMENT_ID = intval($arFields);
    } else {
        return;
    }

    $res = CIBlockElement::GetList(
        [],
        ["ID" => $ELEMENT_ID, "IBLOCK_ID" => $IBLOCK_ID],
        false,
        false,
        ["ID", "PROPERTY_".$PROPERTY_CODE]
    );
    if ($element = $res->GetNext()) {
        if ($element["PROPERTY_{$PROPERTY_CODE}_VALUE"] == $MAIN_VALUE) {
            $rsOther = CIBlockElement::GetList(
                [],
                [
                    "IBLOCK_ID" => $IBLOCK_ID,
                    "!ID" => $ELEMENT_ID,
                    "PROPERTY_".$PROPERTY_CODE => $MAIN_VALUE
                ],
                false,
                false,
                ["ID"]
            );

            while ($arOther = $rsOther->Fetch()) {
                CIBlockElement::SetPropertyValuesEx(
                    $arOther['ID'],
                    $IBLOCK_ID,
                    [ $PROPERTY_CODE => false ] // Сбрасываем
                );
            }
        }
    }
}