<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

$application = Application::getInstance();
$context = $application->getContext();
/* Вывод количества избранного */
if (!$USER->IsAuthorized()) // Для неавторизованного
{
    $arElements = unserialize($APPLICATION->get_cookie('favorites'));
    if ($arElements == '') {
        unset($arElements);
    }

    foreach ($arElements as $k => $fav) // Checking empty IDs
    {
        if ($fav == '0') {
            unset($arElements[$k]);
        }
        unset($fav);
    }
    if($arElements) {
        $wishCount = count($arElements);
    }else{$wishCount = 0;}
} else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    foreach ($arUser['UF_FAVORITES'] as $k => $fav) // Checking empty IDs
    {
        if ($fav == '0') {
            unset($arUser['UF_FAVORITES'][$k]);
            unset($fav);
        }
    }
    if($arUser['UF_FAVORITES']) {
        $wishCount = count($arUser['UF_FAVORITES']);
    }else{$wishCount = 0;}
}

/* Вывод количества избранного */
?>
<a id='want' class="block" href="/izbrannoe-uslugi/" >
    <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"><path data-name="Ellipse 270 copy 3" class="clsw-1" d="M682.741,81.962L682.75,82l-0.157.142a5.508,5.508,0,0,1-1.009.911L675,89h-2l-6.5-5.9a5.507,5.507,0,0,1-1.188-1.078l-0.057-.052,0-.013A5.484,5.484,0,1,1,674,75.35,5.485,5.485,0,1,1,682.741,81.962ZM678.5,75a3.487,3.487,0,0,0-3.446,3H675a1,1,0,0,1-2,0h-0.054a3.491,3.491,0,1,0-5.924,2.971L667,81l7,6,7-6-0.023-.028A3.5,3.5,0,0,0,678.5,75Z" transform="translate(-664 -73)"></path></svg></div>
    <span class="col"><?=$wishCount ?></span>
</a>