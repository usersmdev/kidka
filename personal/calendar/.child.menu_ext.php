<?/*
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
global $APPLICATION; 
$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
	"ID" => $_REQUEST["ID"],
		"IBLOCK_TYPE" => "private_office",
		"IBLOCK_ID" => "34",
		"SECTION_URL" => "/personal/calendar/#SECTION_ID#/",
		"DEPTH_LEVEL" => "1",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"IS_SEF" => "N",
		"SEF_BASE_URL" => "/personal/",
		"SECTION_PAGE_URL" => "#SECTION_ID#/",
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);
//unset($aMenuLinksExt[0]);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

*/?>