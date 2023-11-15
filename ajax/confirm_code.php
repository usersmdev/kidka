<?php

ini_set('max_execution_time', 20000);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$message = [];
$_SESSION['sms_phone2'] = '';
if ($_POST['code'] == $_SESSION['rand_sms']){
        $_SESSION['sms_phone2'] = 1;
        $message['code'] = 'ok';
}else
    {
        $message['code'] = 'Неверный код';
        $_SESSION['sms_phone'] = '';
        $_SESSION['sms_phone2'] = '';
    }
echo json_encode($message);