<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$isProp = intval($propertyId) > 0;
$isField = !$isProp;
?>
<? if ($isProp): ?>
    <? if (empty($arParams['CUSTOM_TITLE_'.$propertyId])): ?>
        <?= $arResult["PROPERTY_LIST_FULL"][$propertyId]["NAME"] ?>
    <? else: ?>
        <?= $arParams['~CUSTOM_TITLE_'.$propertyId] ?>
    <? endif; ?>
<?else:?>
    <?= !empty($arParams["CUSTOM_TITLE_".$propertyId]) ? $arParams["CUSTOM_TITLE_".$propertyId] : GetMessage("IBLOCK_FIELD_".$propertyId) ?>
<? endif; ?>
<? if(in_array($propertyId, $arResult["PROPERTY_REQUIRED"])): ?>
    <span class="starrequired">*</span>
<? endif; ?>