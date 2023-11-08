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
<?
DelayCatalogUpdateHandler::addAllDelayUpdateProduct();
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>