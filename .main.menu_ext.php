<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"dm:menu.sections", 
	"", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DEPTH_LEVEL" => "2",
		"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"IBLOCK_ID" => SECTION_IBLOCK_ID,
		"IBLOCK_TYPE" => SECTION_IBLOCK_TYPE,
		"ID" => $_REQUEST["ID"],
		"IS_SEF" => "Y",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		"SECTION_URL" => "",
		"SEF_BASE_URL" => "/products/"
	),
	false
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>