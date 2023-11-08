<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
$this->setFrameMode(false);

$existsProps = is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"]);
$fieldList = [];
$propList = [];
$propGroupList = [];
$propCodes = [];
$propCommentList = [];
$monthKeyId = false;
foreach ($arResult["PROPERTY_LIST"] as $propertyId) {
	$isProp = intval($propertyId) > 0;
	$isField = !$isProp;
	if ($isField) {
		$fieldList[] = $propertyId;
	}
	else {
		$propCode = $arResult["PROPERTY_LIST_FULL"][$propertyId]['CODE'];
		$propCodes[$propertyId] = $propCode;

		if ($propCode == 'MONTH_KEY') {
			$monthKeyId = $propertyId;
			continue;
		}

		$isPropComment = $propCode && (strpos($propCode, 'REPORT_COMMENT_') === 0);
		if ($isPropComment) {
			$propCommentList[] = $propertyId;
			continue;
		}

		$propList[] = $propertyId;
		$groupId = intval($arResult["PROPERTY_LIST_FULL"][$propertyId]['SORT'] / 100);
		$propGroupList[$groupId][] = $propertyId;
	}
}

if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if (strlen($arResult["MESSAGE"]) > 0):?>
	<?ShowNote($arResult["MESSAGE"])?>
<?endif?>
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>

	<? if ($existsProps): ?>
		<? /*foreach ($fieldList as $propertyId): ?>
			<?
			$isProp = false;
			$isField = true;
			?>
			<? include('_prop_name.php'); ?><br>
			<? include('_prop.php'); ?>
			<br>
			<br>
		<? endforeach;*/ ?>
		<? if (empty($arResult['ELEMENT'])): ?>
			<input type="hidden" name="PROPERTY[NAME][0]" value="<?= $arParams['MONTH_NAME'] ?>">
			<? if ($monthKeyId): ?>
				<input type="hidden" name="PROPERTY[<?= $monthKeyId ?>][0]" value="<?= $arParams['MONTH_CODE'] ?>">
			<? endif; ?>
		<? else: ?>
			<input type="hidden" name="PROPERTY[NAME][0]" value="<?= $arResult['ELEMENT']['NAME'] ?>">
			<? if ($monthKeyId): ?>
				<input type="hidden" name="PROPERTY[<?= $monthKeyId ?>][0]" value="<?= $arResult['ELEMENT_PROPERTIES'][$monthKeyId][0]['VALUE'] ?>">
			<? endif; ?>
		<? endif; ?>
	<? endif; ?>
	
	<div class="fl-row">
		<? if ($existsProps): ?>
		<div class="col">
			<? foreach ($propGroupList as $propIds): ?>
			<table width="100%" cellspacing="0" cellpadding="0">
				<?foreach ($propIds as $propertyId): ?>
					<?
					$isProp = true;
					$isField = false;
					?>
					<tr>
						<td><? include('_prop_name.php'); ?></td>
						<td>
							<? include('_prop.php'); ?>
						</td>
					</tr>
				<?endforeach;?>
			</table>
			<?endforeach;?>
		</div>
		<? endif; ?>
		<div class="col">
			<div class="col-title">Комментарий к отчету</div>

			<? if (!empty($propCommentList)): ?>
				<div class="select-bl">
					<?foreach ($propCommentList as $propertyId): ?>
						<?
						$isProp = true;
						$isField = false;
						$activeComment = $propertyId;
						?>
						<div class="title"><span><? include('_prop_name.php'); ?></span></div>
						<? break; ?>
					<?endforeach;?>
					<ul>
					<?foreach ($propCommentList as $propertyId): ?>
						<?
						$isProp = true;
						$isField = false;
						$isActiveComment = $propertyId == $activeComment;
						?>
						<li class="<?= $isActiveComment ? 'active' : '' ?>"><span><? include('_prop_name.php'); ?></span></li>
					<?endforeach;?>
					</ul>
				</div>
			<? endif; ?>
			
			<?foreach ($propCommentList as $propertyId): ?>
				<?
				$isProp = true;
				$isField = false;
				$isActiveComment = $propertyId == $activeComment;
				?>
				<div class="sett-info <?= $isActiveComment ? 'active' : '' ?>">
					<? include('_prop.php'); ?>
				</div>
			<?endforeach;?>

			<!-- <div class="sett-info">
				<p>Известность бренда незначительно снизилась. Количество поискового трафика выросло. Средняя глубна пиосмотра растет — хороший показатель.</p>
				<p>Область для добавления произвольного комментария к  результатам отчета.<br />Известность бренда незначительно снизилась. Количество поискового трафика выросло. Средняя глубна пиосмотра растет — хороший показатель.</p>
				<p>Область для добавления произвольного комментария к  результатам отчета.</p>
			</div> -->

			<? include('_captcha.php'); ?>

			<input type="submit" name="iblock_submit" value="Сохранить изменения" />
			<?/*if (strlen($arParams["LIST_URL"]) > 0):?>
				<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
				<input
					type="button"
					name="iblock_cancel"
					value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
					onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
				>
			<?endif*/?>
		</div>
	</div>
</form>