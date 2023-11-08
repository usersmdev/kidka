<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!empty($_POST['itemId'])) {
	$_SESSION['FAVORITE_ITEMS'][intval($_POST['itemId'])] = 1;
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('success'=>false));
}