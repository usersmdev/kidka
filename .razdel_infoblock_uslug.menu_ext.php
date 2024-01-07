<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
      global $APPLICATION; 
      $aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
      "IS_SEF" => "Y", 
      "SEF_BASE_URL" => "/uslugi/",
      "SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
      "DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
      "IBLOCK_TYPE" => "aspro_max_content",
      "IBLOCK_ID" => "82", 
      "DEPTH_LEVEL" => "3", 
      "CACHE_TYPE" => "A", 
      "CACHE_TIME" => "36000000" 
      ), 
  false 
 );
$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);

?>