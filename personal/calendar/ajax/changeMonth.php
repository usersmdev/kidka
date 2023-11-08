<?
require( $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );
$currMonth = $_REQUEST["month"];
$currYear = $_REQUEST["year"];
$sectionId = $_REQUEST["sectionId"];
ob_start();
$APPLICATION->IncludeComponent(
            "tanais:news.calendar",
            "",
            [
                "IBLOCK_TYPE" => "private_office",
                "IBLOCK_ID" => 36,
                "CURR_YEAR" => $currYear,
                "CURR_MONTH" => $currMonth,
                "SECTION_ID" => $sectionId
            ],
            false
        );
$calendar = ob_get_contents();
ob_clean();
global $arFilter;
$date_start = "01.".$currMonth.".".$currYear; // первый день месяца
$date_end = cal_days_in_month(CAL_GREGORIAN, $currMonth, $currYear).".".$currMonth.".".$currYear; // последний день месяца
if($sectionId){
    $arFilter = [">=DATE_ACTIVE_FROM" => $date_start, "<=DATE_ACTIVE_FROM" => $date_end, "SECTION_ID" => $sectionId];
}else{
    $arFilter = [">=DATE_ACTIVE_FROM" => $date_start, "<=DATE_ACTIVE_FROM" => $date_end];
}

ob_start();
$APPLICATION->IncludeComponent("bitrix:news.list", "dm_calendar_bottom", [
    "IBLOCK_ID" => 36,
    "IBLOCK_TYPE" => "private_office",
    "NEWS_COUNT" => "5",
    "FILTER_NAME" => "arFilter",
    "CHECK_DATES" => "N",
    "PROPERTY_CODE" => [
        0 => "EVENT_PLACE",
        1 => "EVENTS_VIDEO"
    ]
]);
$bottom = ob_get_contents();
ob_clean();
$content["calendar"] = $calendar;
$content["bottom"] = $bottom;
echo json_encode($content);