<div class="reviews-block" id="review_<?=$arParams['ELEMENT_ID']?>">
	<?if (count($arResult['ELEMENTS']) > 0) {?>
		<?foreach ($arResult['ELEMENTS'] as $arElement) {?>
			<div class="review">
				<div class="info">
					<div class="name"><?=$arElement['NAME']?></div>
					<div class="date"><?=date('d.m.Y', $arElement['DATE_CREATE_UNIX'])?></div>
					<div class="rank" style="margin: 0;"><?=GetMessage('RW_RANK')?>: <?=$arElement['PROPERTIES']['RANK']['VALUE']?></div>
				</div>
				<div class="description">
					<?=$arElement['PREVIEW_TEXT']?>
				</div>
			</div>
			<div class="clear"></div>
		<?}?>
	<?} else {?>
		<p><?=GetMessage('RW_EMPTY')?></p>
	<?}?>
	<div class="reviews">
		<div class="form" id="form">
			<div class="row">
				<div class="label"><?=GetMessage('NAME')?></div>
				<div class="control">
					<input id="name" type="text" class="control-text" />
				</div>
			</div>
			<div class="row">
				<div class="label"><?=GetMessage('DESCRIPTION')?></div>
				<div class="control">
					<textarea id="description" class="control-text" style="height: 100px"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="label"><?=GetMessage('RW_RANK')?></div>
				<div class="control">
					<span style="vertical-align: middle"><?=GetMessage('RW_RANK_POOR')?></span>
					<? foreach ($arResult['RANK'] as $key => $val) {
						?>
						<input type="radio" value="<?=$key?>" class="rank" name="rank">
						<?
					}
					?>
					<span style="vertical-align: middle"><?=GetMessage('RW_RANK_GOOD')?></span>
				</div>
			</div>
			<div class="row">
				<div class="label"></div>
				<div class="control">
					<button class="button right" onClick="return review<?=$arParams['ELEMENT_ID']?>.Send(function(){ review<?=$arParams['ELEMENT_ID']?>.formHide(); })"><?=GetMessage('SEND_REVIEW')?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<?include_once('script.php')?>
<?	$arJsParams = array();
	$arJsParams['ELEMENT'] = '#review_'.$arParams['ELEMENT_ID'];
	$arJsParams['PARAMETERS']['FILTER_FIELDS'] = true;
	$arJsParams['PARAMETERS']['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
	$arJsParams['PARAMETERS']['ELEMENT_ID'] = $arParams['ELEMENT_ID'];
	$arJsParams['PARAMETERS']['CHARSET'] = SITE_CHARSET;?>
<script>
	var review<?=$arParams['ELEMENT_ID']?> = new DefaultReview(<?=CUtil::PhpToJSObject($arJsParams)?>);
</script>