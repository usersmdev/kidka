<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой кабинет");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"custom_profile", 
	array(
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => "custom_profile",
		"USER_PROPERTY" => array(
			0 => "UF_BXMAKER_AUPHONE",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"USER_PROPERTY_NAME" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>