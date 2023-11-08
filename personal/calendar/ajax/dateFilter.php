<?php
require( $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );

$date = $_REQUEST["date"];

$day = explode(".", $date)[0];
$month = explode(".", $date)[1];
$year= explode(".", $date)[2];

$dateFrom = ConvertDateTime(($day-1).".".$month.".".$year, "DD.MM.YYYY")." 23:59:59";
$dateTo =  ConvertDateTime( $date, "DD.MM.YYYY")." 23:59:59";


global $arFilter;
$arFilter = ["<=DATE_ACTIVE_FROM" => $dateTo, ">=DATE_ACTIVE_FROM" => $dateFrom];
$APPLICATION->IncludeComponent("bitrix:news.list", "dm_calendar_bottom", [
    "IBLOCK_ID" => 36,
    "IBLOCK_TYPE" => "private_office",
    "FILTER_NAME" => "arFilter",
    "CHECK_DATES" => "N",
    "PROPERTY_CODE" => [0 => "EVENT_PLACE", 1 => "EVENTS_VIDEO"]
]);

