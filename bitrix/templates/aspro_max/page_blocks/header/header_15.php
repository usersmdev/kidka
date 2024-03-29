<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion, $bLongHeader;
$arRegions = CMaxRegionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$bLongHeader = true;
?>
<div class="top-block top-block-v1 header-v15">
	<div class="maxwidth-theme">
		<div class="wrapp_block">
			<div class="row">
				<div class="col-md-12">


					<div class="pull-left menus">
						<div class="menus-inner">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/menu/menu.topest2.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false
							);?>
						</div>
					</div>

					<div class="newtop"> <!-- black -->
					<div class="right-icons pull-right wb top-block-item logo_and_menu-row">


							<?//=CMax::ShowBasketWithCompareLink('', 'big', '', 'wrap_icon wrap_basket baskets');?>


						<div class="pull-right">
							<div class="wrap_icon inner-table-block1 person">
								<?=CMax::showCabinetLink(true, true, 'big');?>
							</div>
						</div>
                        <div class="pull-right">
                            <div class="favorit_top top_menu">
                                <? $APPLICATION->IncludeComponent(
                                    "smdev:favorite.elements",
                                    "",
                                    false
                                );?>
                            </div>
                        </div>
					</div>

					<div class="top-block-item pull-right">
						<div class="phone-block">
							<?if($bPhone):?>
								<div class="inline-block">
									<?CMax::ShowHeaderPhones('no-icons');?>
								</div>
							<?endif?>
							<?if($arTheme['SHOW_CALLBACK']['VALUE'] == 'Y'):?>
								<div class="inline-block">
									<span class="callback-block font_upper_xs colored" style="cursor: pointer" data-toggle="modal" data-target="#callback_m"><?=GetMessage("CALLBACK")?></span>
								</div>
							<?endif;?>
						</div>
					</div>

					<?if($arRegions):?>
						<div class="top-block-item pull-right">
							<div class="top-description no-title">
								<?\Aspro\Functions\CAsproMax::showRegionList();?>
							</div>
						</div>
					<?endif;?>

				</div> <!-- black -->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="header-wrapper header-v15">
	<div class="logo_and_menu-row longs">
		<div class="logo-row paddings">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-12">
						<div class="logo-block pull-left floated">
							<div class="logo<?=$logoClass?>">
								<?=CMax::ShowLogo();?>
							</div>
						</div>

						<div class="pull-right">
							<div class="wrap_icon">
								<button class="top-btn inline-search-show">
									<?=CMax::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search.svg");?>
									<span class="title"><?=GetMessage("CT_BST_SEARCH_BUTTON")?></span>
								</button>
							</div>
						</div>

						<div class="menu-row">
							<div class="menu-only">
								<nav class="mega-menu sliced">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/menu/menu.top_catalog_sections.php",
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