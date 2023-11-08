<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>
<div class="ajax-cont">
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"h_callback",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"VARIABLE_ALIASES" => Array(
			"RESULT_ID" => "RESULT_ID",
			"WEB_FORM_ID" => "WEB_FORM_ID"
		),
		"WEB_FORM_ID" => "6"
	)
);?>
</div>
<link href="/bitrix/templates/dm/css/forms.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/bitrix/templates/dm/components/bitrix/form.result.new/h_callback/style.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<script type="text/javascript" src="/bitrix/templates/dm/js/forms.js"></script>
<script type="text/javascript" src="/bitrix/templates/dm/components/bitrix/form.result.new/h_callback/script.js"></script>