<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult['SUCCESS_STRING'] = !empty($arResult['FORM_DESCRIPTION']) ? $arResult['FORM_DESCRIPTION'] : "Ваш заказ принят. С Вами свяжется наш менеджер, ожидайте!";

$arParams['SHOW_FORM_TITLE'] = ($arParams['SHOW_FORM_TITLE'] === 'Y');
$arParams['USE_EXTENDED_ERRORS'] = ($arParams['USE_EXTENDED_ERRORS'] === 'Y');
$arResult['SUBMIT_BUTTON_TEXT'] = htmlspecialcharsbx(
    strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);

$arResult['isFormCurrent'] = ($arResult['isFormCurrent'] === 'Y');
$arResult['isFormSuccess'] = ($arResult['isFormSuccess'] === 'Y');
$arResult['isFormErrors'] = ($arResult['isFormErrors'] === 'Y');
$arResult['isFormNote'] = ($arResult['isFormNote'] === 'Y');
// $arResult['isUseCaptcha'] = ($arResult['isUseCaptcha'] === 'Y');

// $arResult['FORM_PARAMS_OR_POST'] = array(
//     'VIEW_MODE' => 'first',
// );

// foreach ($arResult['FORM_PARAMS_OR_POST'] as $key => $value) {
//     $arResult[$key] = $value;
//     if (isset($arParams[$key])) {
//         $arResult[$key] = $arParams[$key];
//     }
//     if (isset($_POST[$key])) {
//         $arResult[$key] = $_POST[$key];
//     }
// }

$arResult['CAPTCHACode_raw'] = '';
if (!empty($arParams['DEFAULT_ANSWERS']['SOURCE_LINK']) && $arResult['isUseCaptcha']) {
    $captchaPass = COption::GetOptionString("main", "captcha_password", "");
    $cpt = new CCaptcha();
    $cpt->InitCodeCrypt($arResult['CAPTCHACode'], $captchaPass);
    
    $arResult['CAPTCHACode_raw'] = $cpt->code;
}