<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true);

// Function for order
function sortArray($arSource, $arOrder, $arUserFields = Array()) {
    $arFirst      = Array();
    $arUserProps   = Array();
    if(is_array($arUserFields) && count($arUserFields)) {
        foreach($arUserFields as $keyFiels=>$arField) {
            $arUserProps[] = $keyFiels;
        }
    }
    $arUsedFields = array_merge($arSource, $arUserProps);

    foreach($arOrder as $sField) {
        if(in_array($sField, $arUsedFields)) {
            $arFirst[] = $sField;

            foreach($arUsedFields as $keySource=>$sSource) {
                if($sSource == $sField) {
                    unset($arUsedFields[$keySource]);
                }
            }
        }
    }

    $arResult = array_merge($arFirst, $arUsedFields);

    return $arResult;
}

// Set array of order fields
$arOrder = Array(
    "NAME",
    "LAST_NAME",
    "PERSONAL_BIRTHDAY",
    "PHONE_NUMBER",
    "EMAIL",
    "PERSONAL_STATE",
    "PERSONAL_CITY",
    "PERSONAL_STREET",
     "PASSWORD",
    "CONFIRM_PASSWORD"
);

// Order of array
$arResult["SHOW_FIELDS"] = sortArray($arResult["SHOW_FIELDS"], $arOrder, $arResult["USER_PROPERTIES"]["DATA"]);
