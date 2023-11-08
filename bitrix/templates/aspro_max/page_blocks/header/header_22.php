<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion, $dopClass;
$arRegions = CMaxRegionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$dopClass = 'wides_menu smalls';
?>
<div class="top-block top-block-v1 header-v22">
	<div class="maxwidth-theme wides">		
		<div class="wrapp_block">
			<div class="row">
				<div class="items-wrapper flexbox flexbox--row justify-content-between">
					<?if($arRegions):?>
						<div class="top-block-item">
							<div class="top-description no-title">
								<?\Aspro\Functions\CAsproMax::showRegionList();?>
							</div>
						</div>
					<?endif;?>
					<div class="top-block-item">
						<div class="phone-block icons">
							<?if($bPhone):?>
								<div class="inline-block">
									<?CMax::ShowHeaderPhones('');?>
								</div>
							<?endif?>
							<?if($arTheme['SHOW_CALLBACK']['VALUE'] == 'Y'):?>
								<div class="inline-block">
									<span class="callback-block animate-load font_upper_xs colored" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
								</div>
							<?endif;?>
						</div>
					</div>
					
					<div class="soc top-block-item">
						<?$APPLICATION->IncludeComponent(
							"aspro:social.info.max",
							"top",
							array(
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "3600000",
								"CACHE_GROUPS" => "N",
								"COMPONENT_TEMPLATE" => "top"
							),
							false
						);?>
					</div>
					<div class="right-icons top-block-item logo_and_menu-row to-mr showed">
						<div class="pull-right">
							<div class="wrap_icon inner-table-block1 person">
								<?=CMax::showCabinetLink(true, true, 'big');?>
							</div>
						</div>

						<div class="pull-right">
							<div class="wrap_icon top-search">
								<button class="top-btn inline-search-show">
									<?=CMax::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search.svg");?>
									<span class="title"><?=GetMessage("CT_BST_SEARCH_BUTTON")?></span>
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="header-wrapper header-v22">
	<div class="logo_and_menu-row smalls">
		<div class="logo-row paddings">
			<div class="maxwidth-theme wides">
				<div class="row pos-static">
					<div class="col-md-12 pos-static">
						<div class="logo-block pull-left floated">
							<div class="logo<?=$logoClass?>">
								<?=CMax::ShowLogo();?>
							</div>
						</div>

						<div class="float_wrapper fix-block pull-left">
							<div class="hidden-sm hidden-xs pull-left">
								<div class="top-description addr">
									<?$APPLICATION->IncludeFile(SITE_DIR."include/top_page/slogan.php", array(), array(
											"MODE" => "html",
											"NAME" => "Text in title",
											"TEMPLATE" => "include_area.php",
										)
									);?>
								</div>
							</div>
						</div>

						<div class="pull-right wb">
							<div class="right-icons">
								<div class="pull-right">
									<?=CMax::ShowBasketWithCompareLink('', 'big', '', 'wrap_icon wrap_basket baskets');?>
								</div>
							</div>
						</div>

						<div class="menu-row">
							<div class="menu-only">
								<nav class="mega-menu sliced">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/menu/menu.".($arTheme["HEADER_TYPE"]["LIST"][$arTheme["HEADER_TYPE"]["VALUE"]]["ADDITIONAL_OPTIONS"]["MENU_HEADER_TYPE"]["VALUE"] == "Y" ? "top_catalog_wide" : "top").".php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "include_area.php"
										),
										false, array("HIDE_ICONS" => "Y")
									);?>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<div class="lines-row"></div>
			</div>
		</div><?// class=logo-row?>
	</div>
</div>