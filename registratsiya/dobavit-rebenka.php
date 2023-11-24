<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Добавить ребенка");
?><?php
$APPLICATION->IncludeComponent(
	"smdev:child.form", 
	".default", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "Y",
		"ELEMENT_COUNT" => "4",
		"ELEMENT_URL" => "#SITE_DIR#/#IBLOCK_CODE#/item/id/#ELEMENT_ID#/",
		"IBLOCK_ID" => "48",
		"IBLOCK_TYPE" => "aspro_max_content",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>