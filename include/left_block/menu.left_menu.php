<? global $arTheme; ?> <br>
    <br>
<? $bHideCatalogMenu = (isset($arParams["HIDE_CATALOG"]) && $arParams["HIDE_CATALOG"] == "Y"); ?>
<?php //if (CSite::InDir('/test-catalog')): ?>
<?//if($APPLICATION->GetCurPage() != "/test-catalog/"): ?>

    <? if (!CMax::IsMainPage()): ?>
        <? if (CMax::IsCatalogPage()): ?>
            <? if (!$bHideCatalogMenu): ?>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "left_front_catalog",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => $arTheme["MAX_DEPTH_MENU"]["VALUE"],
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600000",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "ROOT_MENU_TYPE" => "left",
                        "USE_EXT" => "Y"
                    ),
                    false,
                    array(
                        'ACTIVE_COMPONENT' => 'Y'
                    )
                ); ?>
            <? endif; ?>
        <? else: ?>
            <? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"left_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left2",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "top_content_multilevel",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "left_menu",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
); ?>
        <? endif; ?>
    <? elseif (!$bHideCatalogMenu): ?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "left_front_catalog",
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CACHE_SELECTED_ITEMS" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => $arTheme["MAX_DEPTH_MENU"]["VALUE"],
                "MENU_CACHE_GET_VARS" => "",
                "MENU_CACHE_TIME" => "3600000",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "N",
                "ROOT_MENU_TYPE" => "left",
                "USE_EXT" => "Y"
            ),
            false,
            array(
                'ACTIVE_COMPONENT' => 'Y'
            )
        ); ?>
    <? endif; ?>



