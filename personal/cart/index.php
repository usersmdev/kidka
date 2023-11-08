<?
define("NO_LEFT", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent(
   "skyweb24:buymore",
   "",
Array()
);?>
<script>
	BX.addCustomEvent('OnBasketChange', function(){ 
		BX.Sale.BasketComponent.sendRequest("refreshAjax");
	});
</script> <?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	".default", 
	array(
		"ACTION_VARIABLE" => "basketAction",
		"ADDITIONAL_PICT_PROP_10" => "-",
		"ADDITIONAL_PICT_PROP_32" => "-",
		"ADDITIONAL_PICT_PROP_4" => "-",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AUTO_CALCULATION" => "Y",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "PROPS",
			3 => "DELETE",
			4 => "DELAY",
			5 => "PRICE",
			6 => "QUANTITY",
			7 => "SUM",
			8 => "PROPERTY_CML2_ARTICLE",
		),
		"COLUMNS_LIST_EXT" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "SUM",
			4 => "PROPERTY_PRODUCER",
			5 => "PROPERTY_LENGTH",
		),
		"COLUMNS_LIST_MOBILE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "SUM",
			4 => "PROPERTY_PRODUCER",
		),
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"CORRECT_RATIO" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DEFERRED_REFRESH" => "N",
		"DISCOUNT_PERCENT_POSITION" => "top-left",
		"DISPLAY_MODE" => "compact",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"HIDE_COUPON" => "N",
		"LABEL_PROP" => array(
		),
		"OFFERS_PROPS" => array(
			0 => "SIZES_SHOES",
			1 => "SIZES_CLOTHES",
			2 => "COLOR_REF",
		),
		"PATH_TO_ORDER" => "/personal/order/make/",
		"PRICE_DISPLAY_MODE" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_BLOCKS_ORDER" => "sku,columns,props",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FILTER" => "N",
		"SHOW_RESTORE" => "Y",
		"TEMPLATE_THEME" => "red",
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "top",
		),
		"USE_DYNAMIC_SCROLL" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_GIFTS" => "N",
		"USE_PREPAYMENT" => "N",
		"USE_PRICE_ANIMATION" => "Y"
	),
	false
);?> <br>
 <br>
<h2><br>
</h2>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>