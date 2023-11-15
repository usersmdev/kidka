<?php
if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/include/sms.ru.php");
?>
<?php
global $USER;
function smscode($phone,$ip){
    $smsru = new SMSRU('C91C35FD-AF9B-DCDB-A625-0FC43B3AEC54'); // Ваш уникальный программный ключ, который можно получить на главной странице
    $data = new stdClass();
    $data->to = $phone;
    //$data->ip = $ip;
    $data->text = 'Ваш код: ' . $_SESSION['rand_sms'];
    $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
    if ($sms->status == "OK") { // Запрос выполнен успешно
        $message['sms'] = $sms->sms_id;
    } else {
        $message['sms_error'] = $sms->status_code;
    }
}


if (!$USER->IsAuthorized()):
    if ($_REQUEST['phone'] && empty($_REQUEST['scode'])) {
        $message = [];


        $phone = preg_replace("/[^0-9]/", '', htmlspecialchars($_REQUEST['phone']));

        $filter = Array("PERSONAL_PHONE"=>$phone);
        $dbUsers = CUser::GetList(($by = "id"), ($order = "desc"), $filter);
        while ($arUser = $dbUsers->Fetch()) {
            $user_id = $arUser['ID'];
        }
        $message['id'] = $user_id;
        if (!isset($user_id)) {
            $rand = mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
            $_SESSION['rand_sms'] = $rand;
            $_SESSION['sms_phone'] = $phone;
            $message['code'] = $_SESSION['rand_sms'];
            $ip = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
            //smscode($phone,$ip);
        }
        else{
            //Пользователь существует
            $message['error'] = 101;
        }



    }
    echo json_encode($message);

    ?>

<?php endif; ?>

