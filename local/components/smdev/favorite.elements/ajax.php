<?
if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;


global $APPLICATION;
$application = Application::getInstance();
$context = $application->getContext();

/* Избранное */

global $USER;
if ($_GET['id']) {
    if (!$USER->IsAuthorized()) // Для неавторизованного
    {
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));

        if (is_array($arElements)) {
            if (!in_array($_GET['id'], $arElements)) {
                $arElements[] = $_GET['id'];
                $result = 1; // Датчик. Добавляем
            } else {
                $key = array_search($_GET['id'], $arElements); // Находим элемент, который нужно удалить из избранного
                unset($arElements[$key]);
                $result = 2; // Датчик. Удаляем
            }
        }else{
            $arElements = array();
            $arElements[] = $_GET['id'];
            $result = 1;
        }
        $cookie = new Cookie("favorites", serialize($arElements), time() + 60 * 60 * 24 * 60);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);
        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->writeHeaders();
    } else { // Для авторизованного
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arElements = array();
        $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
        if(is_array($arElements)) {
            if (!in_array($_GET['id'], $arElements)) // Если еще нету этой позиции в избранном
            {
                $arElements[] = $_GET['id'];
                $result = 1;
            } else {
                $key = array_search($_GET['id'], $arElements); // Находим элемент, который нужно удалить из избранного
                unset($arElements[$key]);
                $result = 2;
            }
        }else{

            $arElements[] = $_GET['id'];

        }
        $USER->Update($idUser, array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
    }
}
/* Избранное */
echo json_encode($result);
die();
 ?>

