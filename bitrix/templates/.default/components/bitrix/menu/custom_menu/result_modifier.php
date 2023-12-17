<?
//var_dump($arResult);
$arResult = CMax::getChilds($arResult);
$aMenuLinksExt = array();

//if($arMenuParametrs = CMax::GetDirMenuParametrs(__DIR__))
//{
//    if($arMenuParametrs['MENU_SHOW_SECTIONS'] == 'Y')
//    {
//        $catalog_id = CMaxCache::$arIBlocks[SITE_ID]['aspro_max_content']['organization'][0];
//        $arSections = CMaxCache::CIBlockSection_GetList(array('SORT' => 'ASC', 'ID' => 'ASC', 'CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($catalog_id), 'MULTI' => 'Y')), array('IBLOCK_ID' => $catalog_id, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', '<DEPTH_LEVEL' => \Bitrix\Main\Config\Option::get("aspro.max", "MAX_DEPTH_MENU", 2)+1), false, array('ID', 'ACTIVE', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', 'PICTURE', 'UF_REGION', 'UF_MENU_BANNER', 'UF_MENU_BRANDS', 'UF_CATALOG_ICON'));
//        $arSectionsByParentSectionID = CMaxCache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
//    }
//    if($arSections)
//        CMax::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);
//}
//var_dump($arSections);
//$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);



global $arTheme;

if($arResult){
	$MENU_TYPE = $arTheme['MEGA_MENU_TYPE']['VALUE'];
	$bRightSide = $arTheme['SHOW_RIGHT_SIDE']['VALUE'] == 'Y';
    $bRightBrand = $bRightSide && $arTheme['SHOW_RIGHT_SIDE']['DEPENDENT_PARAMS']['RIGHT_CONTENT']['VALUE'] == 'BRANDS';

    if($MENU_TYPE == 4) {
        $arMenuIblocks = array();
        foreach($arResult as $itemKey => $item) {
            if( isset( $item['PARAMS']['FROM_IBLOCK'] ) && $item['PARAMS']['FROM_IBLOCK'] ) {
                if( isset( $item['PARAMS']['IBLOCK_ID'] ) && $item['PARAMS']['IBLOCK_ID'] ) {
                    $arMenuIblocks[ $item['PARAMS']['IBLOCK_ID'] ] = $item['PARAMS']['IBLOCK_ID'];
                    unset($arResult[$itemKey]);
                }
            }
        }
        //var_dump($arResult);
        if($arMenuIblocks) {
            foreach($arMenuIblocks as $catalog_id) {
                var_dump($catalog_id);
                if($catalog_id){
                    if($arCatalogIblock = CMaxCache::$arIBlocksInfo[$catalog_id]){
                        if($catalogPageUrl = str_replace('#'.'SITE_DIR'.'#', SITE_DIR, $arCatalogIblock['LIST_PAGE_URL'])){
                            $menuIblockId = CMaxCache::$arIBlocks[SITE_ID]['aspro_max_catalog']['organization'][0];
                            if($menuIblockId){
                                $menuRootCatalogSectionId = CMaxCache::CIblockSection_GetList(array('SORT' => 'ASC', 'CACHE' => array('TAG' => CMaxCache::GetIBlockCacheTag($menuIblockId), 'RESULT' => array('ID'), 'MULTI' => 'N')), array('ACTIVE' => 'Y', 'IBLOCK_ID' => $menuIblockId, 'DEPTH_LEVEL' => 1, 'UF_MENU_LINK' => $catalogPageUrl), false, array('ID'), array('nTopCount' => 1));
                                if($menuRootCatalogSectionId){
                                    $arResult[ count($arResult) ] = array(
                                        'LINK' => $catalogPageUrl,
                                        'PARAMS' => array(
                                            'FROM_IBLOCK' => 1,
                                            'DEPTH_LEVEL' => 1,
                                            'MEGA_MENU_CHILDS' => 1
                                        ),
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
        
        CMax::replaceMenuChilds($arResult, $arParams);
	}
    //var_dump($arResult);
	if($bRightBrand) {
        $arBrandsID = array();
        foreach($arResult as $key=>$arItem)
        {
            if( isset($arItem['PARAMS']['BRANDS']) && $arItem['PARAMS']['BRANDS'] ) {
                foreach($arItem['PARAMS']['BRANDS'] as $brandID) {
                    $arBrandsID[$brandID] = $brandID;
                }
            }
        }
    
        if($arBrandsID) {
            $brandIblockId = CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_brands"][0];
            $arBrandFilter = array('ACTIVE' => 'Y', 'IBLOCK_ID' => $brandIblockId, 'ID' => $arBrandsID);
            $arBrandSelect = array('ID', 'PREVIEW_PICTURE', 'NAME', 'DETAIL_PAGE_URL', 'IBLOCK_ID');
            $arBrands = CMaxCache::CIblockElement_GetList(array("SORT" => "ASC", "CACHE" => array("GROUP" => 'ID', "TAG" => CMaxCache::GetIBlockCacheTag($brandIblockId))), $arBrandFilter, false, false, $arBrandSelect);

            if($arBrands) {
                foreach($arResult as $key=>$arItem)
                {
                    if( isset($arItem['PARAMS']['BRANDS']) && $arItem['PARAMS']['BRANDS'] ) {
                        foreach($arItem['PARAMS']['BRANDS'] as $brandKey => $brandID) {
                            if($arBrands[$brandID]) {
                                $arResult[$key]['PARAMS']['BRANDS'][$brandKey] = $arBrands[$brandID];
                            }
                        }
                    }
                }
            }
        }
	}

	
}
?>