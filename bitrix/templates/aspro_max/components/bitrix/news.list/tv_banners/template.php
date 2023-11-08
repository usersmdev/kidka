<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
if(empty($arResult['ITEMS'])) {
	return;	
}
?>
<?$this->setFrameMode(true);?>

<section class="project-video-wrap">

<h3>ROOMBE &mdash; участник TV-проектов</h3>	
<img src="/upload/design-new/kvartira.jpg" style="width: 500px;">
<?$count = count($arResult['ITEMS']);?>
<div class="project-video  owl-theme owl-drag" data-plugin-options='{"items": "1", "autoplay" : false, "autoplayTimeout" : "2000", "smartSpeed":1000, "dots": false, "nav": true, "loop": true, "rewind":true, video: false, center: true, stagePadding: 495, responsiveClass: true, responsive: {
	0: {
		stagePadding: 0
	},
	1025: {
		stagePadding: 350
	},
	1281: {
		stagePadding: 495
	}
}}'>
<?foreach($arResult['ITEMS'] as $i => $arItem):?>
	<?
		// edit/add/delete buttons for edit mode
		// $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
		// $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		// // show preview picture?
		// $bImage = isset($arItem['FIELDS']['PREVIEW_PICTURE']) && strlen($arItem['PREVIEW_PICTURE']['SRC']);
		// $imageSrc = ($bImage ? $arItem['PREVIEW_PICTURE']['SRC'] : false);

	$videoLink = VideoUrlUtils::getUrl($arItem['PROPERTIES']['VIDEO']['VALUE']);
	// $imageSrc = VideoUrlUtils::getImg($arItem['PROPERTIES']['VIDEO']['VALUE']);
	?>
		<div class="item-video" id="<?=$this->GetEditAreaId($arItem['ID'])?>" data-detail-url="<?= $arItem['DETAIL_PAGE_URL'] ?>">
			<a class="owl-video" href="<?= $videoLink ?>?feature=oembed" style="display: none;"></a>
		</div>
	<?/*<div class="banner item" >
		<?if($arItem['PROPERTIES']['LINK']['VALUE']):?>
			<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" <?=($arItem["PROPERTIES"]["TARGET"]["VALUE_XML_ID"] ? "target='".$arItem["PROPERTIES"]["TARGET"]["VALUE_XML_ID"]."'" : "");?>>
		<?endif;?>
			<img src="<?=$imageSrc?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" class="<?=$arItem['PROPERTIES']['SIZING']['VALUE_XML_ID']=='CROP'?'':'img-responsive'?>" />
		<?if($arItem['PROPERTIES']['LINK']['VALUE']):?>
			</a>
		<?endif;?>
	</div>*/?>
<?endforeach;?>
</div>

</section>