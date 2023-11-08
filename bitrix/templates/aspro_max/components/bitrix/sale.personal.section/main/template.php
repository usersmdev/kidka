<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

/*$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_MAIN"));
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_MAIN"), $arResult['SEF_FOLDER']);

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);*/

$availablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"icon" => '<i class="cur_orders"></i>'
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"icon" => '<i class="bill"></i>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"icon" => '<i class="personal"></i>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"icon" => '<i class="filter_orders"></i>'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"icon" => '<i class="profile"></i>'
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		"icon" => '<i class="cart"></i>'
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		"icon" => '<i class="subscribe"></i>'
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		"icon" => '<i class="contact"></i>'
	);
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages))
{
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	$userGroups = $GLOBALS['USER']->GetUserGroupArray();
	if (in_array("11", $userGroups)) {
		$APPLICATION->SetPageProperty("body_class", "page-personal page-personal_user-reseller");
	}
	elseif (in_array("12", $userGroups)) {
		$APPLICATION->SetPageProperty("body_class", "page-personal page-personal_user-designer");
	}
	else {
		$APPLICATION->SetPageProperty("body_class", "page-personal page-personal_user");
	}
	?>
	
	<?/*<div class="personal_wrapper">
		<div class="row sale-personal-section-row-flex">
			<?
			foreach ($availablePages as $blockElement)
			{
				?>
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<div class="sale-personal-section-index-block bx-theme-<?=$theme?>">
						<a class="sale-personal-section-index-block-link" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
						<span class="sale-personal-section-index-block-ico">
							<?=$blockElement['icon']?>
						</span>
							<h2 class="sale-personal-section-index-block-name">
								<?=htmlspecialcharsbx($blockElement['name'])?>
							</h2>
						</a>
					</div>
				</div>
				<?
			}
			?>
		</div>
	</div>*/?>
	<div class="personal_wrapper">
		<div class="row sale-personal-section-row-flex">
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/orders/">
						<span class="sale-personal-section-index-block-ico"><i class="cur_orders"><img src="/upload/design-new/kabinet_01.jpg" class="kabinet_img"></i></span>
					<h2 class="sale-personal-section-index-block-name">Мои заказы</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/basket/">
					<span class="sale-personal-section-index-block-ico"><i class="cart"><img src="/upload/design-new/kabinet_02.jpg" class="kabinet_img"></i></span>
					<h2 class="sale-personal-section-index-block-name">Корзина</h2></a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/discounts/">
					<span class="sale-personal-section-index-block-ico"><i class="filter_orders"><img src="/upload/design-new/kabinet_03.jpg" class="kabinet_img"></i></span>
					<h2 class="sale-personal-section-index-block-name">Скидки</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/private/">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_04.jpg" class="kabinet_img"><i class="personal"></i></span>
					<h2 class="sale-personal-section-index-block-name">Личные данные</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/profiles/">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_05.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Реквизиты для оплаты</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/subscribe/">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_06.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Уведомления</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/designer/">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_13.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Кабинет дизайнера</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/surveys/">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_07.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Опросы</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="https://portal.decomaster.su/online/msk" target="_blank">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_08.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Обращения</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/archbureau/" target="_blank">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_10.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Архбюро</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/designer/" target="_blank">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_11.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Полезные материалы</h2>
					</a>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<div class="sale-personal-section-index-block bx-theme-">
					<a class="sale-personal-section-index-block-link" href="/personal/online-training/" target="_blank">
					<span class="sale-personal-section-index-block-ico"><img src="/upload/design-new/kabinet_12.jpg" class="kabinet_img"><i class="subscribe"></i></span>
					<h2 class="sale-personal-section-index-block-name">Онлайн-обучение</h2>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?
}
?>