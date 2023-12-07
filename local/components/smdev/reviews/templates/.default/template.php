<?php
//$arParams - Праметры

$this->addExternalCss('/bitrix/css/main/bootstrap.css');
?>

<?global $USER; ?>
<? if ($USER->IsAuthorized()) {
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
}?>
<div class="add_reviews">
    <a href="javascript:void(0)" class="btn bb">Добавить отзыв</a>
</div>
<div class="suc"></div>
<div id="reviews_dev" style="display: none;">
    <h4>Оставьте отзыв о <span class="lager_review"></span></h4>
    <div class="answer"></div>
    <div class="error_message"></div>
    <span class="rating" id="raiting_reviews"></span>
    <div class="form-group">
        <input type="text" name="name" id="name" class="form-control"  placeholder="Ваше имя" value="<?=$USER->GetFullName()?>" <?if ($USER->GetFullName()){?>disabled<?}?>>
    </div>
    <div class="form-group">
        <input type="email" name="email" id="email" class="form-control"  placeholder="Ваш e-mail" value="<?=$USER->GetEmail()?>" <?if ($USER->GetEmail()){?>disabled<?}?>>
    </div>
    <div class="form-group">
        <textarea id="review_text" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Напишите отзыв"></textarea>
    </div>
    <input type="hidden" name="tent" id="tent" value="">
    <input type="hidden" name="id" value="<?=$arParams['IBLOCK_ID']?>">
    <input type="hidden" name="elementid" value="<?=$arParams['ELEMENT_ID']?>">
    <a href="javascript:void(0);" class="btn bb" id="reviews_to" >Отправить</a>
</div>
<?php
global $arrFilter;
$arrfilter=array();
$arrFilter["PROPERTY_ID_RESOURCE"] = $arParams['ELEMENT_ID'];
$iblock_id = \GetID\Helper\IBlock::getInfoByCodeCache('reviews');
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "reviews.list",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "Y",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "USE_FILTER" => "Y",
        "FIELD_CODE" => array("",""),
        "FILTER_NAME" => "arrFilter",

        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => $iblock_id['IBLOCK_ID'],
        "IBLOCK_TYPE" => "aspro_max_content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "10",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("EMAIL","AUTHOR","DATE","REVIEW","REITING","APPROV", "ANSWER_ADMIN","ID_RESOURCE"),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    )
);?><br>