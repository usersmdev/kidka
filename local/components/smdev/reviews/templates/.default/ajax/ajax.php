<?php

if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


CModule::IncludeModule('iblock');

global $USER;
$result = false;
$el = new CIBlockElement;
$PROP = array();
$PROP[1220] = $_POST['first_name'];
$PROP[1221] = $_POST['email'];
$PROP[1218] = $_POST['textarea'];
$PROP[1215] = $_POST['rating'];
$PROP[1222] = 8699; // все отзывы одобрены
$PROP[1224] = $_POST['elementid'];
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(),
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID"      => 86,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_POST['first_name'],
    "ACTIVE"         => "Y",

);

if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
    $result = true;
    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_vote_count", "PROPERTY_vote_sum", "PROPERTY_rating", "PROPERTY_COUNT_REVIEWS");
    $arFilter = Array("IBLOCK_ID"=>$_POST['id'], "ID"=>$_POST['elementid']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

    while($ob = $res->GetNextElement()){
        $arProps = $ob->GetProperties();
    }
    $rating = $arProps['rating']['VALUE'];
    $voteSum = $arProps['vote_sum']['VALUE'];
    $voteCount = $arProps['vote_count']['VALUE'];
    $countReview = $arProps['COUNT_REVIEWS']['VALUE'];

    $new_voteCount = 1;
    $new_voteSum = $_POST['rating'];
    $voteSum = intval($voteSum) + $new_voteSum;
    $voteCount = $new_voteCount + intval($voteCount);
    $new_rating = 0;
    if ($voteCount) {
        $new_rating = round(($voteSum + 31.25 / 5 * 5) / ($voteCount + 10), 2);
    }
    $countReview = intval($countReview) + 1;
    CIBlockElement::SetPropertyValuesEx($_POST['elementid'], false, array('rating' => $new_rating,
        'COUNT_REVIEWS' => $countReview, 'vote_count' => $voteCount, 'vote_sum' => $voteSum));
    $result = true;
} else {
    $result = false;
}

echo json_encode($result);
