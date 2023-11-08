<?

function CleanUpUpload() {

	global $DB;

	define("NO_KEEP_STATISTIC", true);
	define("NOT_CHECK_PERMISSIONS", true);
	$deleteFiles = 'yes'; //Удалять ли найденые файлы yes/no
	$saveBackup = 'yes'; //Создаст бэкап файла yes/no
	//Папка для бэкапа
	$patchBackup = $_SERVER['DOCUMENT_ROOT'] . "/upload/iblock_Backup/";
	//Целевая папка для поиска файлов
	$rootDirPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/iblock";

	$time_start = microtime(true);

	//Создание папки для бэкапа
	if (!file_exists($patchBackup)) {
	    CheckDirPath($patchBackup);
	}
	// Получаем записи из таблицы b_file
	$arFilesCache = array();
	$result = $DB->Query('SELECT FILE_NAME, SUBDIR FROM b_file WHERE MODULE_ID = "iblock"');
	while ($row = $result->Fetch()) {
	    $arFilesCache[$row['FILE_NAME']] = $row['SUBDIR'];
	}
	$hRootDir = opendir($rootDirPath);
	$count = 0;
	$contDir = 0;
	$countFile = 0;
	$i = 1;
	$removeFile=0;
	while (false !== ($subDirName = readdir($hRootDir))) {
	    if ($subDirName == '.' || $subDirName == '..') {
	        continue;
	    }
	    //Счётчик пройденых файлов
	    $filesCount = 0;
	    $subDirPath = "$rootDirPath/$subDirName"; //Путь до подкатегорий с файлами
	    $hSubDir = opendir($subDirPath);
	    while (false !== ($fileName = readdir($hSubDir))) {
	        if ($fileName == '.' || $fileName == '..') {
	            continue;
	        }
	        $countFile++;
	        if (array_key_exists($fileName, $arFilesCache)) { //Файл с диска есть в списке файлов базы - пропуск
	            $filesCount++;
	            continue;
	        }
	        $fullPath = "$subDirPath/$fileName"; // полный путь до файла
	        $backTrue = false; //для создание бэкапа
	        if ($deleteFiles === 'yes') {
	            if (!file_exists($patchBackup . $subDirName)) {
	                if (CheckDirPath($patchBackup . $subDirName . '/')) { //создал поддиректорию
	                    $backTrue = true;
	                }
	            } else {
	                $backTrue = true;
	            }
	            if ($backTrue) {
	                if ($saveBackup === 'yes') {
	                    CopyDirFiles($fullPath, $patchBackup . $subDirName . '/' . $fileName); //копия в бэкап
	                }
	            }
	            //Удаление файла
	            if (unlink($fullPath)) {
	                $removeFile++;
	            }
	        } else {
	            $filesCount++;
	        }
	        $i++;
	        $count++;
	        unset($fileName, $backTrue);
	    }
	    closedir($hSubDir);
	    //Удалить поддиректорию, если удаление активно и счётчик файлов пустой - т.е каталог пуст
	    if ($deleteFiles && !$filesCount) {
	        rmdir($subDirPath);
	    }
	    $contDir++;
	}
	closedir($hRootDir);
	return "CleanUpUpload();";
}

?>