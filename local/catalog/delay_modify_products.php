<?
// /usr/bin/php -f /home/bitrix/www/import/delay_modify_products.php
// */2 * * * * php -f /home/bitrix/www/import/delay_modify_products.php
// */2 * * * * php -f /home/bitrix/ext_www/decom.volgaunion.ru/import/delay_modify_products.php
define('SESS_SEARCHER_CHECK_ACTIVITY', true);
define("STOP_STATISTICS", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
define('NO_AGENT_CHECK', true);

define('DELAY_TIME_WAIT_PRODUCT_STOP_CHANGES', 10); // 30 секунд
// define('DELAY_TIME_WAIT_PRODUCT_STOP_CHANGES', 1);
define('DELAY_TIME_WAIT_LOC_FILE', 20*60); // 20 минуты

$isCliScript = false;
if (empty($_SERVER["DOCUMENT_ROOT"])) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(dirname(__DIR__));
    $isCliScript = true;
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
$delayModifyProductsFile = __DIR__.'/delay_modify_products.txt';
$locModifyProductsFile = __DIR__.'/delay_modify_products.loc';
$dateRunModifyProductsFile = __DIR__.'/delay_modify_products_last_run.txt';
$existsDelayModifyProductsFile = file_exists($delayModifyProductsFile);
$updateTime = filemtime($delayModifyProductsFile);

$currentTime = time();

$needWaitStopChanges = ($currentTime - $updateTime) < DELAY_TIME_WAIT_PRODUCT_STOP_CHANGES;

$needWaitLocFile = false;
if (file_exists($locModifyProductsFile)) {
    $updateLocTime = filemtime($locModifyProductsFile);
    $needWaitLocFile = ($currentTime - $updateLocTime) < DELAY_TIME_WAIT_LOC_FILE;
}

rumaster\Dumper::dump([
    'update file time' => $updateTime,
    '$currentTime' => $currentTime,
    '$currentTime' => $currentTime-$updateTime,
], 10, !$isCliScript);

if ($existsDelayModifyProductsFile) {
    if ($needWaitStopChanges) {
        echo 'Ожидается остановка изменения файла с кодами';
    }
    if (!$needWaitStopChanges && $needWaitLocFile) {
        echo 'Скрипт уже выполняется';
    }
    if (!$needWaitStopChanges && !$needWaitLocFile) {
        // file_put_contents($locModifyProductsFile, $currentTime);
        echo 'выполнение';

        $content = file_get_contents($delayModifyProductsFile);
        @unlink($delayModifyProductsFile);
        $ids = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
        // $ids = array_slice($ids, 0, 35);
        // $ids = [
        //     52791,
        // ];
        // var_dump($ids);
        unset($content);

        DelayCatalogUpdateHandler::startUpdate($ids);
        @unlink($locModifyProductsFile);

        file_put_contents($dateRunModifyProductsFile, date('d.m.Y H:i:s'));
    }
}
else {
    echo 'Отсутствуют изменения';
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>