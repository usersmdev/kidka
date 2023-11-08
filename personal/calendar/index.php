<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мой кабинет");

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$sectionId = $request->get("SECTION_ID");
$currentShowCount = (int)trim($request->get("show_c"));
if(!$currentShowCount){
  $currentShowCount = 5;
}
if ($sectionId) {

    global $arCalendarEventFilter;

    $arCalendarEventFilter["SECTION_ID"] = $sectionId;

    $resEventSect = \Bitrix\Iblock\SectionTable::getList([
        "select" => ["NAME"],
        "filter" => [
            "=ID" => $sectionId
        ],
        "limit" => 1
    ]);
    $arEventSect = $resEventSect->fetch();

}
$currYear = date("Y");
$currMonth = date("m");
?>
<? if (\Tanais\User::getInstance()->isDesigner()): ?>
  <div class="book-changer" >
    <left>
      <div class="fit-content">
        <a href="http://decomaster.su/personal/calendar/#start" id="all-cat">Все категории</a>
        <a href="http://decomaster.su/personal/calendar/354/#start" id="354">Анонсы о продукции</a>
        <a href="http://decomaster.su/personal/calendar/355/#start" id="355">Мероприятия внешние</a>
        <a href="http://decomaster.su/personal/calendar/356/#start" id="356">Мероприятия внутренние</a>
        <a href="http://decomaster.su/personal/calendar/357/#start" id="357">Трендовые события</a>
        <a href="http://decomaster.su/personal/calendar/358/#start" id="358">Участие в TV</a>
      </div>
    </left>
  </div>
  <div class="calendar">
    <div class="calendar-inner">
        <? $APPLICATION->IncludeComponent(
            "tanais:news.calendar",
            "",
            [
                "IBLOCK_TYPE" => "private_office",
                "IBLOCK_ID" => 36,
                "SECTION_ID" => $sectionId,
                "CURR_YEAR" => $currYear,
                "CURR_MONTH" => $currMonth,
                "WEEK_START" => "1"
            ],
            false
        ); ?>
    </div>
  </div>
<? $curUrl = $APPLICATION->GetCurDir();?>
<div class="news-count-block">Выводить по:
  <a class="news-count <?if($currentShowCount == 5):?>active<?endif;?>" href="<?=$curUrl?>?show_c=5" data-count="5">5</a>
  <a class="news-count <?if($currentShowCount == 10):?>active<?endif;?>" href="<?=$curUrl?>?show_c=10" data-count="10">10</a>
  <a class="news-count <?if($currentShowCount == 15):?>active<?endif;?>" href="<?=$curUrl?>?show_c=15" data-count="15">15</a>
</div>
  <div class="choosedDate">
      <?
      global $arFilter;
      $date_start = "01.".$currMonth.".".$currYear; // первый день месяца
      $date_end = cal_days_in_month(CAL_GREGORIAN, $currMonth, $currYear).".".$currMonth.".".$currYear; // последний день месяца
      if($sectionId){
          $arFilter = [">=DATE_ACTIVE_FROM" => $date_start, "<=DATE_ACTIVE_FROM" => $date_end, "SECTION_ID" => $sectionId];
      }else{
          $arFilter = [">=DATE_ACTIVE_FROM" => $date_start, "<=DATE_ACTIVE_FROM" => $date_end];
      }


      $APPLICATION->IncludeComponent("bitrix:news.list", "dm_calendar_bottom", [
          "IBLOCK_ID" => 36,
          "IBLOCK_TYPE" => "private_office",
          "NEWS_COUNT" => $currentShowCount ? $currentShowCount : "5",
          "FILTER_NAME" => "arFilter",
          "CHECK_DATES" => "N",
          "PROPERTY_CODE" => [
              0 => "EVENT_PLACE",
              1 => "EVENTS_VIDEO"
          ]
      ]);
      ?>
  </div>
<? else: ?>
    <? ShowError("Доступ запрещен! Раздел только для дизайнеров!"); ?>
<? endif; ?>
<script>
  $(function(){
    sectionId = "<?=$sectionId?>";
    if(sectionId == ""){
      sectionId = "all-cat";
    }
  if(sectionId != ""){
    $("#" + sectionId).addClass("active");
    scrollToElement($(".h1"));
  }
  });
</script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>