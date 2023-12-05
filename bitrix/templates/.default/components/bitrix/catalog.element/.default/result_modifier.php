<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arFilter = Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "ID"=>$arResult['ID']);
$res = CIBlockElement::GetList(Array(), $arFilter);
if ($ob = $res->GetNextElement()){;
    $arProps = $ob->GetProperties();
}
if($arProps["MORE_PHOTO"]["VALUE"]) {
    $arResult['PICTURE'] = array();
    foreach ($arProps["MORE_PHOTO"]["VALUE"] as $key => &$arItem) {
        $picture = $arItem;
        if($picture) {
            $arFileTmp = \CFile::ResizeImageGet(
                $picture,
                array('width' => 128, 'height' => 100),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            if($arFileTmp['src'])
                $arFileTmp['src'] = \CUtil::GetAdditionalFileURL($arFileTmp['src'], true);
            $arResult['PICTURE'][] = array_change_key_case($arFileTmp, CASE_UPPER);;

        }

    }
}
if($arProps["FIRST_TAB_IMG"]["VALUE"]) {
    $arResult['PICTURE_FIRST_TAB'] = array();
    foreach ($arProps["FIRST_TAB_IMG"]["VALUE"] as $key => &$arItem) {
        $picture = $arItem;
        if($picture) {
            $arFileTmp2 = \CFile::ResizeImageGet(
                $picture,
                array('width' => 128, 'height' => 100),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            if($arFileTmp2['src'])
                $arFileTmp2['src'] = \CUtil::GetAdditionalFileURL($arFileTmp2['src'], true);
            $arResult['PICTURE_FIRST_TAB'][] = array_change_key_case($arFileTmp2, CASE_UPPER);;

        }

    }
}
if($arProps["SECOND_TAB_IMG"]["VALUE"]) {
    $arResult['PICTURE_SECOND_TAB'] = array();
    foreach ($arProps["SECOND_TAB_IMG"]["VALUE"] as $key => &$arItem) {
        $picture = $arItem;
        if($picture) {
            $arFileTmp3 = \CFile::ResizeImageGet(
                $picture,
                array('width' => 128, 'height' => 100),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            if($arFileTmp3['src'])
                $arFileTmp3['src'] = \CUtil::GetAdditionalFileURL($arFileTmp3['src'], true);
            $arResult['PICTURE_SECOND_TAB'][] = array_change_key_case($arFileTmp3, CASE_UPPER);;

        }

    }
}
if($arProps["THIRD_TAB_IMG"]["VALUE"]) {
    $arResult['PICTURE_HIRD_TAB'] = array();
    foreach ($arProps["THIRD_TAB_IMG"]["VALUE"] as $key => &$arItem) {
        $picture = $arItem;
        if($picture) {
            $arFileTmp4 = \CFile::ResizeImageGet(
                $picture,
                array('width' => 128, 'height' => 100),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            if($arFileTmp4['src'])
                $arFileTmp4['src'] = \CUtil::GetAdditionalFileURL($arFileTmp4['src'], true);
            $arResult['PICTURE_THIRD_TAB'][] = array_change_key_case($arFileTmp4, CASE_UPPER);;

        }

    }
}


