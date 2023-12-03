<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if($arResult['PROPERTY_1160']) {
    $arResult['PICTURE'] = array();
    foreach ($arResult['PROPERTY_1160'] as $key => &$arItem) {
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
if($arResult['PROPERTY_1236']) {
    $arResult['PICTURE_1236'] = array();
    foreach ($arResult['PROPERTY_1236'] as $key => &$arItem) {
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
            $arResult['PICTURE_1236'][] = array_change_key_case($arFileTmp2, CASE_UPPER);;

        }

    }
}
if($arResult['PROPERTY_1237']) {
    $arResult['PICTURE_1237'] = array();
    foreach ($arResult['PROPERTY_1237'] as $key => &$arItem) {
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
            $arResult['PICTURE_1237'][] = array_change_key_case($arFileTmp3, CASE_UPPER);;

        }

    }
}
if($arResult['PROPERTY_1238']) {
    $arResult['PICTURE_1238'] = array();
    foreach ($arResult['PROPERTY_1238'] as $key => &$arItem) {
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
            $arResult['PICTURE_1238'][] = array_change_key_case($arFileTmp4, CASE_UPPER);;

        }

    }
}


