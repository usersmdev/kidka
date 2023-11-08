<?php
$isCliScript = false;
// ini_set('display_errors', '1');
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if (!empty($_SERVER["DOCUMENT_ROOT"])) {
    // header('Content-Type: text/html; charset=utf-8');
    // die('Ошибка. Этот файл только для запуска из под крона. ');
    // define('IS_CLI_IMPORT', true);
    // define('NEED_AUTH', 'Y');
}
else {
    // ini_set('mbstring.func_overload', '2');
    // ini_set('mbstring.internal_encoding', 'utf-8');
    $_SERVER["DOCUMENT_ROOT"] = dirname(dirname(__DIR__));
    $isCliScript = true;
}
define('SESS_SEARCHER_CHECK_ACTIVITY', true);
define("STOP_STATISTICS", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
define('NO_AGENT_CHECK', true);

if (!$isCliScript) {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Импорт");
    set_time_limit(600);
}
else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    set_time_limit(0);
}

session_write_close();

use Bitrix\Main\Loader;

Loader::includeModule('rumaster.utils');
Loader::includeModule('iblock');
Loader::includeModule('sale');
Loader::includeModule('catalog');

use Rumaster\Utils\Helpers\ArrayHelper;
use Rumaster\Utils\Helpers\StringHelper;
use Rumaster\Utils\Import\Tools;
use Rumaster\Utils\Iterator\IterTools;
use rumaster\bitrix\db\SectionQuery;
use rumaster\bitrix\db\ElementQuery;
use Rumaster\Utils\Dumper;
use rumaster\Cache;
use Rumaster\Utils\Helpers\File\WatchFilesStopChanges;
use Rumaster\Utils\Helpers\File\FileLocWithTimeout;

$skipImport = false;

$lockWatchFiles = new WatchFilesStopChanges([
    // Отслеживаемые файлы
    'files' => [ 
        $_SERVER["DOCUMENT_ROOT"].'/upload/csv/1c-export.csv',
    ],
    // 30 секунд, время после которого считается что файлы перестали менятся
    'timeout' => 30,
]);

if (!$lockWatchFiles->exists()) {
    $skipImport = true;
    echo 'Ожидается загрузка всех файлов импорта';
}
else if ($lockWatchFiles->locked()) {
    $skipImport = true;
    echo 'Ожидается прекращение изменений всех файлов импорта';
}

if (!$isCliScript) {
    include('_prepare_import.php');
    include('_analize.php');
    // include('_import.php');
}
else {
    $fileLock = new FileLocWithTimeout([
        'file' => __DIR__.'/import_lock.loc',
        'timeout' => 600, // 10 минут на импорт
    ]);
    if (!$skipImport && $fileLock->locked()) {
        $skipImport = true;
        echo 'Импорт уже запущен нужно подождать 10 минут или меньше';
    }
    
    if (!$skipImport) {
        $fileLock->lock();
    
        $content = "start: ".date('d.m.Y H:i:s')."\n";
        file_put_contents(__DIR__.'/last-import.txt', $content);
        
        // Импорт
        include('_prepare_import.php');
        include('_import.php');
        
        $content = "end: ".date('d.m.Y H:i:s')."\n";
        file_put_contents(__DIR__.'/last-import.txt', $content, FILE_APPEND);

        $fileLock->unlock();
    }
}

if (!$isCliScript) {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}
else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}
?>