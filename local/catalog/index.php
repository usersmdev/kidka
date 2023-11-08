<?
//  /usr/bin/php -f /var/www/sovimax/data/www/sovimax.ru/import/delay_modify_products.php
define('SESS_SEARCHER_CHECK_ACTIVITY', true);
define("STOP_STATISTICS", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
define('NO_AGENT_CHECK', true);

//define('DELAY_TIME_WAIT_PRODUCT_STOP_CHANGES', 2*60); // 2 минуты
define('DELAY_TIME_WAIT_PRODUCT_STOP_CHANGES', 1); // 2 минуты
define('DELAY_TIME_WAIT_LOC_FILE', 20*60); // 20 минуты

$isCliScript = false;
if (empty($_SERVER["DOCUMENT_ROOT"])) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(dirname(__DIR__));
    $isCliScript = true;
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<pre><?
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

// $r = \CIBlockElement::GetList([], ['IBLOCK_ID' => 4, 'ACTIVE' => 'Y'], false, [], ['ID', 'CODE', 'XML_ID', 'NAME']);
// while($row = $r->Fetch()) {
//     print_r($row);
// }
// echo '============';
// $r = \CIBlockElement::GetList([], ['IBLOCK_ID' => 45, 'ACTIVE' => 'Y'], false, false, ['ID', 'CODE', 'XML_ID', 'NAME']);
// while($row = $r->Fetch()) {
//     $code = \CUtil::translit($row['NAME'], 'ru', [
//         "max_len" => 100,
//         "change_case" => 'L',
//         "replace_space" => '-',
//         "replace_other" => '-',
//     ]);
//     $e = new CIBlockElement;
//     $e->Update($row['ID'], [
//         'CODE' => $code,
//     ]);
//     // $row['CODE'] = $code;
//     // print_r($row);
// }
DelayCatalogUpdateHandler::startUpdate([
    '10783',
]);
?></pre>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>