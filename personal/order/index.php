<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой кабинет");
use Bitrix\Main\Application;
$request = Application::getInstance()->getContext()->getRequest();
$newsCount = $request->get("show_c");
?>

<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "dm_personal_order", array(
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/personal/order/",
	"ORDERS_PER_PAGE" => $newsCount ? $newsCount : "5",
	"PATH_TO_PAYMENT" => "/personal/order/payment/",
	"PATH_TO_BASKET" => "/personal/cart/",
	"SET_TITLE" => "N",
	"SAVE_IN_SESSION" => "N",
	"NAV_TEMPLATE" => ".default",
	"SEF_URL_TEMPLATES" => array(
		"list" => "index.php",
		"detail" => "detail/#ID#/",
		"cancel" => "cancel/#ID#/",
	),
	"SHOW_ACCOUNT_NUMBER" => "Y"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>