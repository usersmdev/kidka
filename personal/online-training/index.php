<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Online-обучение");

if (!in_array(11, $GLOBALS['USER']->GetUserGroupArray())) {
    echo 'Вам нужно зарегистрироваться как партнер';
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    return;
}
?>

Text here....

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>