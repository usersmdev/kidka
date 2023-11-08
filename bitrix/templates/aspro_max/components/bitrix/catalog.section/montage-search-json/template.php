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

if (!empty($arResult['ITEMS']))
{
	$templateLibrary = array();
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList,
	);
	unset($currencyList, $templateLibrary);

	$arSkuTemplate = array();

	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$productTitle = (
			isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
			? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
			: $arItem['NAME']
		);
		
		
		$templateData['PRODUCTS'][] = [
			'id' => $arItem['ID'],
			'sectionIds' => $arItem['SECTION_IDS'],
			'sections' => $arItem['SECTIONS'],
			'name' => $productTitle,
			'url' => $arItem['DETAIL_PAGE_URL'],
			'sectionId' => $arItem['IBLOCK_SECTION_ID'],
			'price' => [
				'raw' => $arItem['MIN_PRICE']['DISCOUNT_VALUE'],
				'formated' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
				'currency' => $arItem['MIN_PRICE']['CURRENCY'],
			],
			'quantityData' => [
				'check' => $arItem['CHECK_QUANTITY'],
				'max' => $arItem['CATALOG_QUANTITY'],
				'step' => $arItem['CATALOG_MEASURE_RATIO'],
				'is_float' => is_double($arItem['CATALOG_MEASURE_RATIO']),
			],
			'article' => $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'],
			'size' => $arItem['PROPERTIES']['SIZE']['VALUE'],
		];
	}
}