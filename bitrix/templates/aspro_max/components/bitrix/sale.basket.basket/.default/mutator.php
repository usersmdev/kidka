<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\PriceMaths;

/**
 *
 * This file modifies result for every request (including AJAX).
 * Use it to edit output result for "{{ mustache }}" templates.
 *
 * @var array $result
 */

$mobileColumns = isset($this->arParams['COLUMNS_LIST_MOBILE'])
	? $this->arParams['COLUMNS_LIST_MOBILE']
	: $this->arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$extBasketIds = [];
$extIblockIds = [];
foreach ($this->basketItems as $row)
{
	$extBasketIds[$row['PRODUCT_ID']] = true;
	$$extIblockIds[$row['IBLOCK_ID']] = true;
}
$extBasketIds = array_keys($extBasketIds);
$extIblockIds = array_keys($extIblockIds);

$extBasketData = [];
if ($extBasketIds) {
	$rs = CIBlockElement::GetList(
		['sort' => 'asc'],
		['IBLOCK_ID' => $extIblockIds, 'ID' => $extBasketIds],
		false, false,
		['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'PROPERTY_SECTION_ID', 'PROPERTY_PRODUCT_URL']
	);
	while ($ar = $rs->Fetch()) {
		$extBasketData[$ar['ID']] = $ar;
	}
}

$skipBlockSections = [533, 534, 535, 536, 538, 539, 540, 541, 542, 543, 544, 545, 546, 547, 548];
$blockSections = [
	436, 437, 438, 439, 440, 441, 442, 443, 444, 445, 446, 447, 448, 449,
	450, 451, 452, 453, 454, 455, 456, 457, 458, 459, 460, 461, 462, 463,
	464, 465, 466, 467, 468, 469, 470, 471, 472, 473, 474, 475, 476, 477,
	478, 479, 480, 481, 482, 483, 484, 485, 486, 487, 434, 435, 422, 421,
	423, 430, 429,
];
	
$result['BASKET_ITEM_RENDER_DATA'] = array();

$montageSum = 0;
$designSum = 0;
$httpQueryData = [];
foreach ($this->basketItems as $row)
{
	$rowData = array(
		'ID' => $row['ID'],
		'PRODUCT_ID' => $row['PRODUCT_ID'],
		'NAME' => isset($row['~NAME']) ? $row['~NAME'] : $row['NAME'],
		'QUANTITY' => $row['QUANTITY'],
		'PROPS' => $row['PROPS'],
		'PROPS_ALL' => $row['PROPS_ALL'],
		'HASH' => $row['HASH'],
		'SORT' => $row['SORT'],
		'DETAIL_PAGE_URL' => $row['DETAIL_PAGE_URL'],
		'CURRENCY' => $row['CURRENCY'],
		'DISCOUNT_PRICE_PERCENT' => $row['DISCOUNT_PRICE_PERCENT'],
		'DISCOUNT_PRICE_PERCENT_FORMATED' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
		'SHOW_DISCOUNT_PRICE' => (float)$row['DISCOUNT_PRICE'] > 0,
		'PRICE' => $row['PRICE'],
		'PRICE_FORMATED' => $row['PRICE_FORMATED'],
		'FULL_PRICE' => $row['FULL_PRICE'],
		'FULL_PRICE_FORMATED' => $row['FULL_PRICE_FORMATED'],
		'DISCOUNT_PRICE' => $row['DISCOUNT_PRICE'],
		'DISCOUNT_PRICE_FORMATED' => $row['DISCOUNT_PRICE_FORMATED'],
		'SUM_PRICE' => $row['SUM_VALUE'],
		'SUM_PRICE_FORMATED' => $row['SUM'],
		'SUM_FULL_PRICE' => $row['SUM_FULL_PRICE'],
		'SUM_FULL_PRICE_FORMATED' => $row['SUM_FULL_PRICE_FORMATED'],
		'SUM_DISCOUNT_PRICE' => $row['SUM_DISCOUNT_PRICE'],
		'SUM_DISCOUNT_PRICE_FORMATED' => $row['SUM_DISCOUNT_PRICE_FORMATED'],
		'MEASURE_RATIO' => isset($row['MEASURE_RATIO']) ? $row['MEASURE_RATIO'] : 1,
		'MEASURE_TEXT' => $row['MEASURE_TEXT'],
		'AVAILABLE_QUANTITY' => $row['AVAILABLE_QUANTITY'],
		'CHECK_MAX_QUANTITY' => $row['CHECK_MAX_QUANTITY'],
		'MODULE' => $row['MODULE'],
		'PRODUCT_PROVIDER_CLASS' => $row['PRODUCT_PROVIDER_CLASS'],
		'NOT_AVAILABLE' => $row['NOT_AVAILABLE'] === true,
		'DELAYED' => $row['DELAY'] === 'Y',
		'SKU_BLOCK_LIST' => array(),
		'COLUMN_LIST' => array(),
		'SHOW_LABEL' => false,
		'LABEL_VALUES' => array(),
		'BRAND' => isset($row[$this->arParams['BRAND_PROPERTY'].'_VALUE'])
			? $row[$this->arParams['BRAND_PROPERTY'].'_VALUE']
			: '',
	);

	$extBasketRow =  $extBasketData[$row['PRODUCT_ID']];
	// $row['DETAIL_PAGE_URL'] = $extBasketRow && $extBasketRow['PROPERTY_PRODUCT_URL_VALUE']
	// 	? $extBasketRow['PROPERTY_PRODUCT_URL_VALUE']
	// 	: '';
	// var_dump($row['DETAIL_PAGE_URL']);
	// var_dump($row['PROPS_ALL']);
	$rowData['MONTAGE_SUM_PRICE'] = 0;
	$rowData['EXT_SECTION_ID'] = 0;
	if ($extBasketRow) {
		$rowData['EXT_SECTION_ID'] = $extBasketRow['PROPERTY_SECTION_ID_VALUE'];
		if (in_array($extBasketRow['PROPERTY_SECTION_ID_VALUE'], $skipBlockSections)) {
		}
		elseif (in_array($extBasketRow['PROPERTY_SECTION_ID_VALUE'], $blockSections)) {
			$rowData['MONTAGE_SUM_PRICE'] = $rowData['SUM_FULL_PRICE'] * 1;
		}
		else {
			$rowData['MONTAGE_SUM_PRICE'] = $rowData['SUM_FULL_PRICE'] * 0.7;
		}
	}
	$rowData['MONTAGE_SUM_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($rowData['MONTAGE_SUM_PRICE'], $rowData['CURRENCY'], true);
	$pLength = 0;
	$pLength = (int)preg_replace('/[^-.,+\d]+/', '', $row['~PROPERTY_DLINA_MM_VALUE'])*1;
	$rowData['DESIGN_SUM_PRICE'] = $pLength ? ($pLength/1000)*350 * $row['QUANTITY'] : 0;
	$rowData['DESIGN_SUM_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($rowData['DESIGN_SUM_PRICE'], $rowData['CURRENCY'], true);
	$httpQueryData[] = [
		'id' => $row['PRODUCT_ID'],
		'quantity' => $row['QUANTITY'],
	];

	$montageSum += $rowData['MONTAGE_SUM_PRICE'];
	$designSum += $rowData['DESIGN_SUM_PRICE'];

	// show price including ratio
	if ($rowData['MEASURE_RATIO'] != 1)
	{
		$price = PriceMaths::roundPrecision($rowData['PRICE'] * $rowData['MEASURE_RATIO']);
		if ($price != $rowData['PRICE'])
		{
			$rowData['PRICE'] = $price;
			$rowData['PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($price, $rowData['CURRENCY'], true);
		}

		$fullPrice = PriceMaths::roundPrecision($rowData['FULL_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($fullPrice != $rowData['FULL_PRICE'])
		{
			$rowData['FULL_PRICE'] = $fullPrice;
			$rowData['FULL_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($fullPrice, $rowData['CURRENCY'], true);
		}

		$discountPrice = PriceMaths::roundPrecision($rowData['DISCOUNT_PRICE'] * $rowData['MEASURE_RATIO']);
		if ($discountPrice != $rowData['DISCOUNT_PRICE'])
		{
			$rowData['DISCOUNT_PRICE'] = $discountPrice;
			$rowData['DISCOUNT_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($discountPrice, $rowData['CURRENCY'], true);
		}
	}

	$rowData['SHOW_PRICE_FOR'] = (float)$rowData['QUANTITY'] !== (float)$rowData['MEASURE_RATIO'];

	$hideDetailPicture = false;

	if (!empty($row['PREVIEW_PICTURE_SRC']))
	{
		$rowData['IMAGE_URL'] = $row['PREVIEW_PICTURE_SRC'];
	}
	elseif (!empty($row['DETAIL_PICTURE_SRC']))
	{
		$hideDetailPicture = true;
		$rowData['IMAGE_URL'] = $row['DETAIL_PICTURE_SRC'];
	}

	if (!empty($row['SKU_DATA']))
	{
		$propMap = array();

		foreach($row['PROPS'] as $prop)
		{
			$propMap[$prop['CODE']] = !empty($prop['~VALUE']) ? $prop['~VALUE'] : $prop['VALUE'];
		}

		$notSelectable = true;

		foreach ($row['SKU_DATA'] as $skuBlock)
		{
			$skuBlockData = array(
				'ID' => $skuBlock['ID'],
				'CODE' => $skuBlock['CODE'],
				'NAME' => $skuBlock['NAME']
			);

			$isSkuSelected = false;
			$isImageProperty = false;

			if (count($skuBlock['VALUES']) > 1)
			{
				$notSelectable = false;
			}

			foreach ($skuBlock['VALUES'] as $skuItem)
			{
				if ($skuBlock['TYPE'] === 'S' && $skuBlock['USER_TYPE'] === 'directory')
				{
					$valueId = $skuItem['XML_ID'];
				}
				elseif ($skuBlock['TYPE'] === 'E')
				{
					$valueId = $skuItem['ID'];
				}
				else
				{
					$valueId = $skuItem['NAME'];
				}

				$skuValue = array(
					'ID' => $skuItem['ID'],
					'NAME' => $skuItem['NAME'],
					'SORT' => $skuItem['SORT'],
					'PICT' => !empty($skuItem['PICT']) ? $skuItem['PICT']['SRC'] : false,
					'XML_ID' => !empty($skuItem['XML_ID']) ? $skuItem['XML_ID'] : false,
					'VALUE_ID' => $valueId,
					'PROP_ID' => $skuBlock['ID'],
					'PROP_CODE' => $skuBlock['CODE']
				);

				if (
					!empty($propMap[$skuBlockData['CODE']])
					&& ($propMap[$skuBlockData['CODE']] == $skuItem['NAME'] || $propMap[$skuBlockData['CODE']] == $skuItem['XML_ID'])
				)
				{
					$skuValue['SELECTED'] = true;
					$isSkuSelected = true;
				}

				$skuBlockData['SKU_VALUES_LIST'][] = $skuValue;
				$isImageProperty = $isImageProperty || !empty($skuItem['PICT']);
			}

			if (!$isSkuSelected && !empty($skuBlockData['SKU_VALUES_LIST'][0]))
			{
				$skuBlockData['SKU_VALUES_LIST'][0]['SELECTED'] = true;
			}

			$skuBlockData['IS_IMAGE'] = $isImageProperty;

			$rowData['SKU_BLOCK_LIST'][] = $skuBlockData;
		}
	}

	if ($row['NOT_AVAILABLE'])
	{
		foreach ($rowData['SKU_BLOCK_LIST'] as $blockKey => $skuBlock)
		{
			if (!empty($skuBlock['SKU_VALUES_LIST']))
			{
				if ($notSelectable)
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][0]['NOT_AVAILABLE_OFFER'] = true;
					}
				}
				elseif (!isset($rowData['SKU_BLOCK_LIST'][$blockKey + 1]))
				{
					foreach ($skuBlock['SKU_VALUES_LIST'] as $valueKey => $skuValue)
					{
						if ($skuValue['SELECTED'])
						{
							$rowData['SKU_BLOCK_LIST'][$blockKey]['SKU_VALUES_LIST'][$valueKey]['NOT_AVAILABLE_OFFER'] = true;
						}
					}
				}
			}
		}
	}

	if (!empty($result['GRID']['HEADERS']) && is_array($result['GRID']['HEADERS']))
	{
		$skipHeaders = [
			'NAME' => true,
			'QUANTITY' => true,
			'PRICE' => true,
			'PREVIEW_PICTURE' => true,
			'SUM' => true,
			'PROPS' => true,
			'DELETE' => true,
			'DELAY' => true,
		];

		foreach ($result['GRID']['HEADERS'] as &$value)
		{
			if (
				empty($value['id'])
				|| isset($skipHeaders[$value['id']])
				|| ($hideDetailPicture && $value['id'] === 'DETAIL_PICTURE'))
			{
				continue;
			}

			if ($value['id'] === 'DETAIL_PICTURE')
			{
				$value['name'] = Loc::getMessage('SBB_DETAIL_PICTURE_NAME');

				if (!empty($row['DETAIL_PICTURE_SRC']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => array(
							array(
								'IMAGE_SRC' => $row['DETAIL_PICTURE_SRC'],
								'IMAGE_SRC_2X' => $row['DETAIL_PICTURE_SRC_2X'],
								'IMAGE_SRC_ORIGINAL' => $row['DETAIL_PICTURE_SRC_ORIGINAL'],
								'INDEX' => 0
							)
						),
						'IS_IMAGE' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'PREVIEW_TEXT')
			{
				$value['name'] = Loc::getMessage('SBB_PREVIEW_TEXT_NAME');

				if ($row['PREVIEW_TEXT_TYPE'] === 'text' && !empty($row['PREVIEW_TEXT']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['PREVIEW_TEXT'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'TYPE')
			{
				$value['name'] = Loc::getMessage('SBB_PRICE_TYPE_NAME');

				if (!empty($row['NOTES']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => isset($row['~NOTES']) ? $row['~NOTES'] : $row['NOTES'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'DISCOUNT')
			{
				$value['name'] = Loc::getMessage('SBB_DISCOUNT_NAME');

				if ($row['DISCOUNT_PRICE_PERCENT'] > 0 && !empty($row['DISCOUNT_PRICE_PERCENT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['DISCOUNT_PRICE_PERCENT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif ($value['id'] === 'WEIGHT')
			{
				$value['name'] = Loc::getMessage('SBB_WEIGHT_NAME');

				if (!empty($row['WEIGHT_FORMATED']))
				{
					$rowData['COLUMN_LIST'][] = array(
						'CODE' => $value['id'],
						'NAME' => $value['name'],
						'VALUE' => $row['WEIGHT_FORMATED'],
						'IS_TEXT' => true,
						'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
					);
				}
			}
			elseif (!empty($row[$value['id'].'_SRC']))
			{
				$i = 0;

				foreach ($row[$value['id'].'_SRC'] as &$image)
				{
					$image['INDEX'] = $i++;
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_SRC'],
					'IS_IMAGE' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_DISPLAY']))
			{
				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $row[$value['id'].'_DISPLAY'],
					'IS_TEXT' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id'].'_LINK']))
			{
				$linkValues = array();

				foreach ($row[$value['id'].'_LINK'] as $index => $link)
				{
					$linkValues[] = array(
						'LINK' => $link,
						'IS_LAST' => !isset($row[$value['id'].'_LINK'][$index + 1])
					);
				}

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $linkValues,
					'IS_LINK' => true,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
			elseif (!empty($row[$value['id']]))
			{
				$rawValue = isset($row['~'.$value['id']]) ? $row['~'.$value['id']] : $row[$value['id']];
				$isHtml = !empty($row[$value['id'].'_HTML']);

				$rowData['COLUMN_LIST'][] = array(
					'CODE' => $value['id'],
					'NAME' => $value['name'],
					'VALUE' => $rawValue,
					'IS_TEXT' => !$isHtml,
					'IS_HTML' => $isHtml,
					'HIDE_MOBILE' => !isset($mobileColumns[$value['id']])
				);
			}
		}

		unset($value);
	}

	if (!empty($row['LABEL_ARRAY_VALUE']))
	{
		$labels = array();

		foreach ($row['LABEL_ARRAY_VALUE'] as $code => $value)
		{
			$labels[] = array(
				'NAME' => $value,
				'HIDE_MOBILE' => !isset($this->arParams['LABEL_PROP_MOBILE'][$code])
			);
		}

		$rowData['SHOW_LABEL'] = true;
		$rowData['LABEL_VALUES'] = $labels;
	}

	$result['BASKET_ITEM_RENDER_DATA'][] = $rowData;
}

$totalData = array(
	'DISABLE_CHECKOUT' => (int)$result['ORDERABLE_BASKET_ITEMS_COUNT'] === 0,
	'PRICE' => $result['allSum'],
	'PRICE_FORMATED' => $result['allSum_FORMATED'],
	'PRICE_WITHOUT_DISCOUNT_FORMATED' => $result['PRICE_WITHOUT_DISCOUNT'],
	'CURRENCY' => $result['CURRENCY']
);
$totalData['MONTAGE_DEFAULT_PRICE'] = $montageSum < 12000;
$totalData['MONTAGE_PRICE'] = $totalData['MONTAGE_DEFAULT_PRICE'] ? 12000 : $montageSum;
$totalData['MONTAGE_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($totalData['MONTAGE_PRICE'], $rowData['CURRENCY'], true);
$totalData['DESIGN_DEFAULT_PRICE'] = $designSum < 5500;
$totalData['DESIGN_PRICE'] = $totalData['DESIGN_DEFAULT_PRICE'] ? 5500 : $designSum;
$totalData['DESIGN_PRICE_FORMATED'] = CCurrencyLang::CurrencyFormat($totalData['DESIGN_PRICE'], $rowData['CURRENCY'], true);
$totalData['MONTAGE_OR_DESIGN_DEFAULT_PRICE'] = $totalData['MONTAGE_DEFAULT_PRICE'] || $totalData['DESIGN_DEFAULT_PRICE'];
$totalData['MONTAGE_OR_DESIGN_HTTP_QUERY'] = http_build_query(['basket' => $httpQueryData]);


if ($result['DISCOUNT_PRICE_ALL'] > 0)
{
	$totalData['DISCOUNT_PRICE_FORMATED'] = $result['DISCOUNT_PRICE_FORMATED'];
}

if ($result['allWeight'] > 0)
{
	$totalData['WEIGHT_FORMATED'] = $result['allWeight_FORMATED'];
}

if ($this->priceVatShowValue === 'Y')
{
	$totalData['SHOW_VAT'] = true;
	$totalData['VAT_SUM_FORMATED'] = $result['allVATSum_FORMATED'];
	$totalData['SUM_WITHOUT_VAT_FORMATED'] = $result['allSum_wVAT_FORMATED'];
}

if ($this->hideCoupon !== 'Y' && !empty($result['COUPON_LIST']))
{
	$totalData['COUPON_LIST'] = $result['COUPON_LIST'];
	
	foreach ($totalData['COUPON_LIST'] as &$coupon)
	{
		if ($coupon['JS_STATUS'] === 'ENTERED')
		{
			$coupon['CLASS'] = 'danger';
		}
		elseif ($coupon['JS_STATUS'] === 'APPLYED')
		{
			$coupon['CLASS'] = 'muted';
		}
		else
		{
			$coupon['CLASS'] = 'danger';
		}
	}
}

$result['TOTAL_RENDER_DATA'] = $totalData;

CatalogHelper::fixBasketUrls($result['BASKET_ITEM_RENDER_DATA']);