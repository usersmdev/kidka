<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой кабинет");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	".default", 
	array(
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"USER_PROPERTY" => array(
			0 => "UF_DIPLOMA",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"USER_PROPERTY_NAME" => ""
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>