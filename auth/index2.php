<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
	LocalRedirect($backurl);

$APPLICATION->SetTitle("Авторизация");

$showFields = [
    0 => "EMAIL",
    1 => "NAME",
    2 => "LAST_NAME",
];
$requiredFields = [
    0 => "EMAIL",
];
if (!empty($_REQUEST['user-type']) && ($_REQUEST['user-type'] == 'designer')) {
    $showFields[] = "PERSONAL_PHONE";
    $requiredFields[] = "PERSONAL_PHONE";
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	".default", 
	array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => $requiredFields,
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => $showFields,
		"SUCCESS_PAGE" => "",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>