<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой кабинет");
?>
<?if(\Tanais\User::getInstance()->isDesigner()):?>
<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "dm_catalog_request", array(
		"WEB_FORM_ID" => 7,
		"LIST_URL" => "",
		"EDIT_URL" => ""
	));
?>


<?else:?>
	<?ShowError("Доступ запрещен! Раздел только для дизайнеров!");?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>