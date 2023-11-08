<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->RestartBuffer();
header('Content-Type: application/json');
echo json_encode($templateData);