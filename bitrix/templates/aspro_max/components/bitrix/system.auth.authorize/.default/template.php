<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>
<script src="<?=SITE_TEMPLATE_PATH.'/js/phonelogin.js'?>"></script>
<?if(isset($_REQUEST['backurl']) && $_REQUEST['backurl']){
	// fix ajax url
	if($_REQUEST['backurl'] != $_SERVER['REQUEST_URI']){
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_URI'] = $_REQUEST['backurl'];
		$APPLICATION->reinitPath();
	}
}?>
<div id="wrap_ajax_auth" class="form auth-page">
	<?
	$APPLICATION->IncludeComponent(
		"bitrix:system.auth.form",
		"main",
		Array(
			"REGISTER_URL" => SITE_DIR."auth/registration/?register=yes",
			"PROFILE_URL" => SITE_DIR."auth/",
			"FORGOT_PASSWORD_URL" => SITE_DIR."auth/forgot-password/?forgot-password=yes",
			"AUTH_URL" => SITE_DIR."auth/",
			"SHOW_ERRORS" => "Y",
			"AJAX_MODE" => "Y",
			"BACKURL" => ((isset($_REQUEST['backurl']) && $_REQUEST['backurl']) ? $_REQUEST['backurl'] : "")
		)
	);?>
</div>