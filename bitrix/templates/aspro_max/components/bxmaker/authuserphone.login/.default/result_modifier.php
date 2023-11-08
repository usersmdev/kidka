<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)

$arResult["AUTH_SERVICES"] = false;
if(!$USER->IsAuthorized() && CModule::IncludeModule("socialservices"))
{
    $oAuthManager = new CSocServAuthManager();
    $arServices = $oAuthManager->GetActiveAuthServices(array(
        'BACKURL' => $arResult['~BACKURL'],
        'FOR_INTRANET' => $arResult['FOR_INTRANET'],
    ));

    if(!empty($arServices))
    {
        $arResult["AUTH_SERVICES"] = $arServices;
    }
}