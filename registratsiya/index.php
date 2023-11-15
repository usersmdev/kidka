<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	"custom_registration", 
	array(
		"AUTH" => "Y",
		"COMPONENT_TEMPLATE" => "custom_registration",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"REQUIRED_FIELDS" => array(
			0 => "EMAIL",
			1 => "PHONE_NUMBER",
			2 => "NAME",
			3 => "PERSONAL_CITY",
		),
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => array(
			0 => "EMAIL",
			1 => "PHONE_NUMBER",
			2 => "NAME",
			3 => "LAST_NAME",
			4 => "PERSONAL_BIRTHDAY",
			5 => "PERSONAL_PHONE",
			6 => "PERSONAL_STREET",
			7 => "PERSONAL_CITY",
			8 => "PERSONAL_STATE",
		),
		"SUCCESS_PAGE" => "",
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"USER_PROPERTY" => array(
		)
	),
	false
);?>
<?$APPLICATION->IncludeComponent("cr:custom.reg", ".default", array(
	
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>