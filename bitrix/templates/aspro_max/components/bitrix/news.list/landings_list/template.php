<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>
	<?$i = 0;?>
	<?$bFilled = ($arParams['BG_FILLED'] == 'Y');?>
	<div class="landings-list <?=$templateName;?>">
		<?if($arParams["TITLE_BLOCK"]):?>
			<div class="landings-list__title darken font_mlg"><?=$arParams["TITLE_BLOCK"];?></div>
		<?endif;?>
		<div class="landings-list__info">
			<?$compare_field = (isset($arParams["COMPARE_FIELD"]) && $arParams["COMPARE_FIELD"] ? $arParams["COMPARE_FIELD"] : "DETAIL_PAGE_URL");
			$bProp = (isset($arParams["COMPARE_PROP"]) && $arParams["COMPARE_PROP"] == "Y");?>
			<?foreach($arResult['ITEMS'] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

				++$i;
				$bHidden = ($i > $arParams["SHOW_COUNT"]);
				$url = $arItem[$compare_field];
				if($bProp)
					$url = $arItem["PROPERTIES"][$compare_field]["VALUE"];
				?>
				<?if($bHidden && !$bHiddenOK):?>
					<?$bHiddenOK = true;?>
					<div class="landings-list__item-more hidden">
				<?endif?>
				<div class="landings-list__item<?=((($i+1 > $arParams["SHOW_COUNT"]) && !$bHiddenOK) ? ' last' : '');?> font_xs" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?if(strlen($url)):?>
						<?if(strpos($APPLICATION->GetCurDir(), $url) !== false):?>
							<span class="landings-list__name rounded3 landings-list__item--active"><span><?=$arItem['NAME']?></span></span>
						<?else:?>
							<a class="landings-list__name<?=($bFilled ? ' landings-list__item--filled-bg box-shadow-sm' : ' landings-list__item--hover-bg');?> rounded3" href="<?=$url?>"><span><?=$arItem['NAME']?></span></a>
						<?endif;?>
					<?else:?>
						<span class="landings-list__name<?=($bFilled ? ' landings-list__item--filled-bg box-shadow-sm' : ' landings-list__item--hover-bg');?> rounded3"><span><?=$arItem['NAME']?></span></span>
					<?endif?>
				</div>
			<?endforeach?>
			<?if($bHidden):?>
				</div>
				<div class="landings-list__item font_xs">
					<span class="landings-list__name landings-list__item--js-more colored_theme_text_with_hover">
						<span data-opened="N" data-text="<?=Loc::getMessage("HIDE");?>"><?=Loc::getMessage("SHOW_ALL");?></span><?=CMax::showIconSvg("wish ncolor", SITE_TEMPLATE_PATH."/images/svg/arrow_showmoretags.svg");?>
					</span>
				</div>
			<?endif?>
		</div>
	</div>
<?endif?>