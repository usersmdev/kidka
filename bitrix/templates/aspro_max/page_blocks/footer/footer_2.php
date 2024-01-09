<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme;
$bPrintButton = ($arTheme['PRINT_BUTTON']['VALUE'] == 'Y' ? true : false);
?>
<div class="footer-v2">
	<div class="footer-inner light">
		<div class="footer_top">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-2 col-sm-3">
						<div class="fourth_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom2", array(
								"ROOT_MENU_TYPE" => "bottom",
								"MENU_CACHE_TYPE" => "A",
								"MENU_CACHE_TIME" => "3600000",
								"MENU_CACHE_USE_GROUPS" => "N",
								"MENU_CACHE_GET_VARS" => array(
								),
								"MAX_LEVEL" => "1",
								"CHILD_MENU_TYPE" => "",
								"USE_EXT" => "N",
								"DELAY" => "N",
								"ALLOW_MULTI_SELECT" => "Y"
								),
								false
							);?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3">
						<div class="first_bottom_menu">
							<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "bottom_company",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"COMPONENT_TEMPLATE" => "bottom",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="second_bottom_menu">
							<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "bottom_info",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"COMPONENT_TEMPLATE" => "bottom"
	),
	false
);?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3">
						<div class="third_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
								"ROOT_MENU_TYPE" => "bottom_help",
								"MENU_CACHE_TYPE" => "A",
								"MENU_CACHE_TIME" => "3600000",
								"MENU_CACHE_USE_GROUPS" => "N",
								"MENU_CACHE_GET_VARS" => array(
								),
								"MAX_LEVEL" => "1",
								"CHILD_MENU_TYPE" => "left",
								"USE_EXT" => "N",
								"DELAY" => "N",
								"ALLOW_MULTI_SELECT" => "Y"
								),
								false
							);?>
						</div>
					</div>
					<div class="col-md-3 col-sm-12 contact-block">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",

                                "PATH" => SITE_DIR . "include/footer/right_block_f2.php"
                            )
                        );
                        ?>

					</div>
				</div>
			</div>
		</div>
		<div class="footer_middle">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="social-block">
							<?$APPLICATION->IncludeComponent(
								"aspro:social.info.max",
								".default",
								array(
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "3600000",
									"CACHE_GROUPS" => "N",
									"COMPONENT_TEMPLATE" => ".default"
								),
								false
							);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_bottom">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="link_block col-md-6 col-sm-6 pull-right">
						<div class="pull-right">
							<div class="pays">
								<?$APPLICATION->IncludeFile(SITE_DIR."include/footer/copy/pay_system_icons.php", Array(), Array(
										"MODE" => "php",
										"NAME" => "onfidentiality",
										"TEMPLATE" => "include_area.php",
									)
								);?>
							</div>
						</div>
						<div class="pull-right">
							<?=CMax::ShowPrintLink();?>
						</div>
					</div>
					<div class="copy-block col-md-6 col-sm-6 pull-left">
						<div class="copy font_xs pull-left">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/footer/copy/copyright.php", Array(), Array(
									"MODE" => "php",
									"NAME" => "Copyright",
									"TEMPLATE" => "include_area.php",
								)
							);?>
						</div>
						<div id="bx-composite-banner" class="pull-left"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
