<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$monthsName = [1 => "Январь", "Февраль", "Март", "Апрель", "Май",
    "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
$nextMonth = $arParams["CURR_MONTH"] + 1;
$nextYear = $arParams["CURR_YEAR"];
if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear = $arParams["CURR_YEAR"] + 1;
}
$prevMonth = $arParams["CURR_MONTH"] - 1;
$prevYear = $arParams["CURR_YEAR"];
if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear = $arParams["CURR_YEAR"] - 1;
}

?>

<div class="arrow-left arrow"
     onclick="changeMonth('<?= $prevMonth ?>', '<?= $prevYear ?>' , '<?= $arParams["SECTION_ID"] ?>')">
</div>
<div class="news-calendar">
    <? if ($arParams["SHOW_CURRENT_DATE"]): ?>
      <p align="right" class="NewsCalMonthNav"><b><?= $arResult["TITLE"] ?></b></p>
    <? endif ?>
  <table width='100%' border='0' cellspacing='1' cellpadding='4' class='NewsCalTable'>
    <tr class="header-line">
      <td colspan="7">
          <?= $monthsName[$arResult["currentMonth"]]; ?> <?= $arParams["CURR_YEAR"]; ?>
      </td>
    </tr>
    <tr class="day_names flex">
      <td align="center" valign="top" class="NewsCalWeekend ">
        <span class="">ПН</span>
      </td>
      <td align="center" valign="top" class="NewsCalDefault ">
        <span class="">ВТ</span>
      </td>
      <td align="center" valign="top" class="NewsCalDefault ">
        <span class="">СР</span>
      </td>
      <td align="center" valign="top" class="NewsCalDefault ">
        <span class="">ЧТ</span>
      </td>
      <td align="center" valign="top" class="NewsCalDefault ">
        <span class="">ПТ</span>
      </td>
      <td align="center" valign="top" class="NewsCalDefault " width="14%">
        <span class="" style="color: red">СБ</span>
      </td>
      <td align="center" valign="top" class="NewsCalWeekend " width="14%">
        <span class="" style="color: red">ВС</span>
      </td>
    </tr>
    <tr class="width-border-bottom">
      <td colspan="7" class="border-bottom"></td>
    </tr>
      <? $weekCounter = 0; # Счетчик недель ?>
      <? foreach ($arResult["MONTH"] as $key => $arWeek): # текущий месяц, перебор недель ?>
          <? $weekCounter++;
          $dayCounter = 0; # Счетчик дней
          ?>
        <tr>
            <? foreach ($arWeek as $arDay): # перебор дней ?>
                <?
                $actualDate = date("d.m.Y");
                $itemDate = $arDay["day"] . "." . str_pad($arResult["currentMonth"], 2, '0', STR_PAD_LEFT) . "." . $arResult["currentYear"];
                $actualEvent = strtotime($actualDate) > strtotime($itemDate) ? "irrelevant" : ""; # Проверка актульности события (пройден или будущий)
                $dayCounter++;
                $hasEvent = !empty($arDay["events"]);
                $hasSectionId = ($arParams["SECTION_ID"] != "");
                $thisDay = $arDay["day"] . "." . $arResult["currentMonth"] . "." . $arResult["currentYear"];
                ?>
                <? if ($weekCounter == 5 && $dayCounter == 7) { # Проверка количества дней, и если следующего ряда не будет, добавляем точки
                    $bullAdd = true;
                } ?>
              <td align="center" valign="top"
                  class='<?= $arDay["td_class"] ?> standart-td <? if ($hasEvent): ?> with-event <? endif; ?>'<? if ($hasEvent): ?> onclick="openDay('<?= $thisDay ?>');" <? endif; ?>
                  width="14%">
                  <? if ($arDay["td_class"] != "NewsCalOtherMonth"): ?>

                    <span class="<?= $arDay["day_class"] ?>"><?= $arDay["day"] ?></span>

                      <? foreach ($arDay["events"] as $arEvent): # перебор всех событий (пока выводм только 1 событие)?>

                          <? if (!empty($arEvent["icon"])): # выводим первое событие у которого выбран Тип ?>
                        <div class="NewsCalNews <?= $actualEvent; ?>" style="padding-top:5px;">
                          <a href="<?= $arEvent["url"] ?>" title="<?= $arEvent["preview"] ?>"
                             data-toggle="tooltip" data-placement="right"
                             onclick="detailOpenner(event, <?= $arEvent["id"] ?>)">
									<span class="icon-block">
										<img src="<?= $arEvent["icon"] ?>" alt="">
									</span>
                            <span
                                class="date-span"><?= $arDay["day"] . "." . str_pad($arResult["currentMonth"], 2, '0', STR_PAD_LEFT); ?></span>
                          </a>
                        </div>
                              <? break; ?>
                          <? endif; ?>
                      <? endforeach ?>
                  <? elseif ($weekCounter == 5 && $dayCounter <= 7): #Проверяем, если неделя 5 и в ней остались дни, то заполняем остальное точками и добавляем последний ряд точек?>
                      <?
                      echo "<span> </span>";
                      $bullAdd = true;
                      ?>
                  <? elseif ($weekCounter == 6 && $dayCounter <= 7): #Проверяем, если неделя 6 и в ней остались дни, то заполняем остальное точками и убираем последний ряд точек?>
                      <?
                      $bullAdd = false;
                      echo "<span> </span>";
                      ?>
                  <? else: ?>
                      <?= ($key ? "" : "<span> </span>") ?>
                  <? endif; ?>
              </td>
            <? endforeach ?>
        </tr>

      <? endforeach ?>
    <tr class="width-border-bottom">
      <td colspan="7" class="border-bottom"></td>
    </tr>

  </table>

</div>
<div class="arrow-right arrow"
     onclick="changeMonth('<?= $nextMonth ?>', '<?= $nextYear ?>', '<?= $arParams["SECTION_ID"] ?>')"></div>
