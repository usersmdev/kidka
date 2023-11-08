<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Application; 
$APPLICATION->SetTitle("Мой кабинет");
$request = Application::getInstance()->getContext()->getRequest(); 
$category = $request->get("category");
?>
<?if(\Tanais\User::getInstance()->isDesigner()):?>
<?if($category){
	global $arFilter;
	switch ($category) {
		case 'main':
			$arFilter = array("SECTION_ID" => 359);
			break;
		case 'decor':
			$arFilter = array("SECTION_ID" => 361);
			break;
		case 'lepnina':
			$arFilter = array("SECTION_ID" => 360);
			break;
		default:
			$arFilter = array();
			break;
	}
}?>

<?$APPLICATION->IncludeComponent("bitrix:news.list", "dm_catalog_book", array(
	"IBLOCK_TYPE" => "private_office",
	"IBLOCK_ID" => 37,
	"NEWS_COUNT" => 999,
	"PROPERTY_CODE" => array("PDF_LINK", "FLIPPING_BOOK_LINK"),
	"FILTER_NAME" => "arFilter"
));?>
<?else:?>
	<?ShowError("Доступ запрещен! Раздел только для дизайнеров!");?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>