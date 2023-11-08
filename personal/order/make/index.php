<?
if (empty($_REQUEST['OC_ORDER_ID']) && empty($_REQUEST['ORDER_ID'])) {
	define('NEED_AUTH', 'Y');
}
define("NO_LEFT", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>

<?if(isset($_GET["OC_ORDER_ID"]) && !empty($_GET["OC_ORDER_ID"])):?>
<?
	$APPLICATION->SetTitle("Заказ сформирован");
?>
<p style="font-size: 15px;"><br>
Ваш заказ №<b><?=$_GET["OC_ORDER_ID"]?></b> от <?=date("d.m.Y H:i:s")?> успешно создан.	<br>
Наши менеджеры свяжутся с Вами в ближайшее время.</p>
<?else:?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	".default", 
	array(
		"ADDITIONAL_PICT_PROP_10" => "-",
		"ADDITIONAL_PICT_PROP_4" => "-",
		"ALLOW_AUTO_REGISTER" => "Y",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "before",
		"COMPATIBLE_MODE" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DELIVERIES_PER_PAGE" => "8",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "H",
		"DELIVERY_NO_SESSION" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"DISABLE_BASKET_REDIRECT" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PAY_FROM_ACCOUNT" => "N",
		"PAY_SYSTEMS_PER_PAGE" => "8",
		"PICKUPS_PER_PAGE" => "10",
		"PRODUCT_COLUMNS" => "",
		"PRODUCT_COLUMNS_HIDDEN" => array(
			0 => "PROPS",
		),
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PROPS",
			1 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			2 => "PRICE_FORMATED",
		),
		"PROPS_FADE_LIST_1" => array(
			0 => "6",
			1 => "17",
			2 => "21",
			3 => "22",
		),
		"PROPS_FADE_LIST_2" => array(
			0 => "8",
			1 => "9",
			2 => "10",
			3 => "11",
			4 => "12",
			5 => "13",
			6 => "14",
			7 => "15",
			8 => "16",
		),
		"PROP_1" => "",
		"PROP_2" => "",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SHOW_TOTAL_ORDER_BUTTON" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"TEMPLATE_THEME" => "blue",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_PRELOAD" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "Y",
		"YM_GOALS_COUNTER" => "4369966",
		"YM_GOALS_EDIT_BASKET" => "BX-basket-edit",
		"YM_GOALS_EDIT_DELIVERY" => "BX-delivery-edit",
		"YM_GOALS_EDIT_PAY_SYSTEM" => "BX-paySystem-edit",
		"YM_GOALS_EDIT_PICKUP" => "BX-pickUp-edit",
		"YM_GOALS_EDIT_PROPERTIES" => "BX-properties-edit",
		"YM_GOALS_EDIT_REGION" => "BX-region-edit",
		"YM_GOALS_INITIALIZE" => "BX-order-init",
		"YM_GOALS_NEXT_BASKET" => "BX-basket-next",
		"YM_GOALS_NEXT_DELIVERY" => "BX-delivery-next",
		"YM_GOALS_NEXT_PAY_SYSTEM" => "BX-paySystem-next",
		"YM_GOALS_NEXT_PICKUP" => "BX-pickUp-next",
		"YM_GOALS_NEXT_PROPERTIES" => "BX-properties-next",
		"YM_GOALS_NEXT_REGION" => "BX-region-next",
		"YM_GOALS_SAVE_ORDER" => "BX-order-save",
		"COMPONENT_TEMPLATE" => ".default",
		"ALLOW_APPEND_ORDER" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"SHOW_VAT_PRICE" => "Y",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"ACTION_VARIABLE" => "action",
		"USE_PHONE_NORMALIZATION" => "Y",
		"EMPTY_BASKET_HINT_PATH" => "/"
	),
	false
);?>

<?endif;?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>