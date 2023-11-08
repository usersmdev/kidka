<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Архбюро");

if (!in_array(12, $GLOBALS['USER']->GetUserGroupArray())) {
    echo 'Вам нужно зарегистрироваться как дизайнер';
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    return;
}
?><?$APPLICATION->IncludeComponent(
	"bitrix:iblock.element.add", 
	"simple", 
	array(
		"COMPONENT_TEMPLATE" => "simple",
		"IBLOCK_TYPE" => "aspro_max_catalog",
		"IBLOCK_ID" => "79",
		"NAV_ON_PAGE" => "10",
		"USE_CAPTCHA" => "N",
		"USER_MESSAGE_ADD" => "",
		"USER_MESSAGE_EDIT" => "",
		"DEFAULT_INPUT_SIZE" => "30",
		"RESIZE_IMAGES" => "N",
		"PROPERTY_CODES" => array(
			0 => "987",
			1 => "1018",
			2 => "1021",
			3 => "1022",
			4 => "1023",
			5 => "1024",
			6 => "1038",
			7 => "NAME",
			8 => "PREVIEW_PICTURE",
			9 => "DETAIL_TEXT",
		),
		"PROPERTY_CODES_REQUIRED" => array(
		),
		"GROUPS" => array(
			0 => "12",
		),
		"STATUS" => "ANY",
		"STATUS_NEW" => "NEW",
		"ALLOW_EDIT" => "Y",
		"ALLOW_DELETE" => "Y",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"MAX_USER_ENTRIES" => "100000",
		"MAX_LEVELS" => "100000",
		"LEVEL_LAST" => "Y",
		"MAX_FILE_SIZE" => "0",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CUSTOM_TITLE_NAME" => "",
		"CUSTOM_TITLE_TAGS" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>