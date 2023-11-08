<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);
$useMontageSumColumn = true;
$useDesignSumColumn = true;

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-montage-template" type="text/html">
	<tr class="basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}}"
		id="basket-item-montage-{{ID}}" data-entity="basket-montage-item" data-id="{{ID}}">
		{{#SHOW_RESTORE}}{{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
			<td class="basket-items-list-item-descriptions">
				<div class="basket-items-list-item-descriptions-inner" id="basket-item-height-aligner-{{ID}}">
					<?
					if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
					{
						?>
						<div class="basket-item-block-image<?=(!isset($mobileColumns['PREVIEW_PICTURE']) ? ' hidden-xs' : '')?>">
							{{#DETAIL_PAGE_URL}}
								<a href="{{DETAIL_PAGE_URL}}" class="basket-item-image-link">
							{{/DETAIL_PAGE_URL}}

							<img class="basket-item-image" alt="{{NAME}}"
								src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}">

							{{#SHOW_LABEL}}
								<div class="basket-item-label-text basket-item-label-big <?=$labelPositionClass?>">
									{{#LABEL_VALUES}}
										<div{{#HIDE_MOBILE}} class="hidden-xs"{{/HIDE_MOBILE}}>
											<span title="{{NAME}}">{{NAME}}</span>
										</div>
									{{/LABEL_VALUES}}
								</div>
							{{/SHOW_LABEL}}

							{{#DETAIL_PAGE_URL}}
								</a>
							{{/DETAIL_PAGE_URL}}
						</div>
						<?
					}
					?>
					<div class="basket-item-block-info">
						<h2 class="basket-item-info-name">
							{{#DETAIL_PAGE_URL}}
								<a href="{{DETAIL_PAGE_URL}}" class="basket-item-info-name-link">
							{{/DETAIL_PAGE_URL}}
	
							<span data-entity="basket-item-name">{{NAME}}</span>

							{{#DETAIL_PAGE_URL}}
								</a>
							{{/DETAIL_PAGE_URL}}
						</h2>
						{{#NOT_AVAILABLE}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning text-center">
									<?=Loc::getMessage('SBB_BASKET_ITEM_NOT_AVAILABLE')?>.
								</div>
							</div>
						{{/NOT_AVAILABLE}}
						{{#DELAYED}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning text-center">
									<?=Loc::getMessage('SBB_BASKET_ITEM_DELAYED')?>.
									<a href="javascript:void(0)" data-entity="basket-item-remove-delayed">
										<?=Loc::getMessage('SBB_BASKET_ITEM_REMOVE_DELAYED')?>
									</a>
								</div>
							</div>
						{{/DELAYED}}
						{{#WARNINGS.length}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning alert-dismissable" data-entity="basket-item-warning-node">
									<span class="close" data-entity="basket-item-warning-close">&times;</span>
										{{#WARNINGS}}
											<div data-entity="basket-item-warning-text">{{{.}}}</div>
										{{/WARNINGS}}
								</div>
							</div>
						{{/WARNINGS.length}}
						<div class="basket-item-block-properties">
							<div class="basket-item-property?>">
								<div class="basket-item-property-name">
									Количество:
								</div>
								<div class="basket-item-property-value"
									data-entity="basket-item-property-value">
									{{{QUANTITY}}} {{MEASURE_TEXT}}
								</div>
							</div>
							<?
							if (false && !empty($arParams['PRODUCT_BLOCKS_ORDER']))
							{
								foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
								{
									switch (trim((string)$blockName))
									{
										case 'props':
											if (in_array('PROPS', $arParams['COLUMNS_LIST']))
											{
												?>
												{{#PROPS}}
													<div class="basket-item-property<?=(!isset($mobileColumns['PROPS']) ? ' hidden-xs' : '')?>">
														<div class="basket-item-property-name">
															{{{NAME}}}
														</div>
														<div class="basket-item-property-value"
															data-entity="basket-item-property-value" data-property-code="{{CODE}}">
															{{{VALUE}}}
														</div>
													</div>
												{{/PROPS}}
												<?
											}

											break;
										case 'sku':
											?>
											{{#SKU_BLOCK_LIST}}
												{{#IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-image"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																				<span class="basket-item-scu-item-inner"
																					style="background-image: url({{PICT}});"></span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}

												{{^IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-text"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																		<span class="basket-item-scu-item-inner">{{NAME}}</span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}
											{{/SKU_BLOCK_LIST}}

											{{#HAS_SIMILAR_ITEMS}}
												<div class="basket-items-list-item-double" data-entity="basket-item-sku-notification">
													<div class="alert alert-info alert-dismissable text-center">
														{{#USE_FILTER}}
															<a href="javascript:void(0)"
																class="basket-items-list-item-double-anchor"
																data-entity="basket-item-show-similar-link">
														{{/USE_FILTER}}
														<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P1')?>{{#USE_FILTER}}</a>{{/USE_FILTER}}
														<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P2')?>
														{{SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}
														<br>
														<a href="javascript:void(0)" class="basket-items-list-item-double-anchor"
															data-entity="basket-item-merge-sku-link">
															<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P3')?>
															{{TOTAL_SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}?
														</a>
													</div>
												</div>
											{{/HAS_SIMILAR_ITEMS}}
											<?
											break;
										case 'columns':
											?>
											{{#COLUMN_LIST}}
												{{#IS_IMAGE}}
													<div class="basket-item-property-custom basket-item-property-custom-photo
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value">
															{{#VALUE}}
																<span>
																	<img class="basket-item-custom-block-photo-item"
																		src="{{{IMAGE_SRC}}}" data-image-index="{{INDEX}}"
																		data-column-property-code="{{CODE}}">
																</span>
															{{/VALUE}}
														</div>
													</div>
												{{/IS_IMAGE}}

												{{#IS_TEXT}}
													<div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value"
															data-column-property-code="{{CODE}}"
															data-entity="basket-item-property-column-value">
															{{VALUE}}
														</div>
													</div>
												{{/IS_TEXT}}

												{{#IS_HTML}}
													<div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value"
															data-column-property-code="{{CODE}}"
															data-entity="basket-item-property-column-value">
															{{{VALUE}}}
														</div>
													</div>
												{{/IS_HTML}}

												{{#IS_LINK}}
													<div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value"
															data-column-property-code="{{CODE}}"
															data-entity="basket-item-property-column-value">
															{{#VALUE}}
															{{{LINK}}}{{^IS_LAST}}<br>{{/IS_LAST}}
															{{/VALUE}}
														</div>
													</div>
												{{/IS_LINK}}
											{{/COLUMN_LIST}}
											<?
											break;
									}
								}
							}
							?>
						</div>
					</div>
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
				</div>
			</td>
			<?
			if ($useMontageSumColumn)
			{
				?>
				<td class="basket-items-list-item-price basket-items-list-item-price-montage">
					<div class="basket-item-block-price">
						<div class="basket-item-price-current2">
                            <span class="basket-item-price-current-subtext"><b>Монтаж</b> предварительный расчёт стоимости — </span>
							<span class="basket-item-price-current-text" id="basket-item-sum-montage-price-{{ID}}" data-section-id="{{EXT_SECTION_ID}}">
								{{{MONTAGE_SUM_PRICE_FORMATED}}}
							</span>
						</div>

						{{#SHOW_LOADING}}
							<div class="basket-items-list-item-overlay"></div>
						{{/SHOW_LOADING}}
					</div>
				</td>
				<?
			}
            ?>
            <?
			if ($useDesignSumColumn)
			{
				?>
				<td class="basket-items-list-item-price basket-items-list-item-price-design">
					<div class="basket-item-block-price">
						<div class="basket-item-price-current2">
                            <span class="basket-item-price-current-subtext"><b>Дизайн</b> 2D предварительный расчёт стоимости — </span>
							<span class="basket-item-price-current-text" id="basket-item-sum-design-price-{{ID}}">
								{{{DESIGN_SUM_PRICE_FORMATED}}}
							</span>
						</div>

						{{#SHOW_LOADING}}
							<div class="basket-items-list-item-overlay"></div>
						{{/SHOW_LOADING}}
					</div>
				</td>
				<?
			}
			?>
		{{/SHOW_RESTORE}}
	</tr>
</script>