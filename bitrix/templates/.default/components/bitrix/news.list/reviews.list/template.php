<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

    <div class="list_reviews_top">
        <h4>Отзыв о <span class="lager_review"></span></h4>
        <?if ($arItem["DISPLAY_PROPERTIES"]['REITING']['CODE']){?>
            <span class="rating" data-value="<?=$arItem["DISPLAY_PROPERTIES"]['REITING']['VALUE'];?>" style="pointer-events: none;"></span>
        <? }?>
    </div>
    <div class="content_review">
        <?=$arItem["DISPLAY_PROPERTIES"]['REVIEW']['VALUE']['TEXT'];?><br><br>
        <?if ($arItem["DISPLAY_PROPERTIES"]['ANSWER_ADMIN']):?>
        <b>Ответ: </b> <?=$arItem["DISPLAY_PROPERTIES"]['ANSWER_ADMIN']['VALUE']['TEXT'];?>
        <?endif;?>
    </div>
    <?$dateCreate = CIBlockFormatProperties::DateFormat(
        'j F Y',
        MakeTimeStamp(
            $arItem["TIMESTAMP_X"],
            CSite::GetDateFormat()
        )
    );
    ?>
    <div class="list_reviews_botttom">
        <div class="name"><?echo $arItem["NAME"]?></div>
        <div class="date"><?echo $dateCreate;?></div>
    </div>
    <div class="border_line"></div>
	</p>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
