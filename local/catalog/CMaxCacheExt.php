<?php

\Bitrix\Main\Loader::includeModule('aspro.max');

class CMaxCacheExt extends CMaxCache {
    const BASE_SECTION_ID = 1797;
    public static function getSectionsSubset($arSections, $subsetSectionId)
    {
        $startSubset = $endSubset = false;
        $arNewSections = [];
		foreach ($arSections as $key => $arSection) {
			if ($arSection['ID'] == $subsetSectionId) {
				$startSubset = $key;
				// $endSubset = $key;
			}
			elseif ($startSubset && $arSection['DEPTH_LEVEL'] > 1) {
                $arNewSections[$key] = $arSection;
				// $endSubset = $key;
			}
			elseif ($startSubset && ($arSection['DEPTH_LEVEL'] == 1)) {
				break;
			}
		}
		// $arNewSections = array_slice($arSections, $startSubset+1, $endSubset-$startSubset);
		foreach ($arNewSections as $key => $arSection) {
			$arSection['DEPTH_LEVEL'] -= 1;
            $arSection['~DEPTH_LEVEL'] -= 1;
            if ($arSection['DEPTH_LEVEL'] === 1) {
                $arSection['IBLOCK_SECTION_ID'] = null;
            }
			$arNewSections[$key] = $arSection;
        }
        return $arNewSections;
    }
    // public static function CIBlockSection_GetCount($arOrder = array("CACHE" => array("MULTI" => "Y", "GROUP" => array(), "RESULT" => array(), "TAG" => "", "PATH" => "", "TIME" => 36000000)), $arFilter = array()){
    //     list($cacheTag, $cachePath, $cacheTime) = self::_InitCacheParams("iblock", __FUNCTION__, $arOrder["CACHE"]);

    //     if (array_key_exists('ELEMENT_IBLOCK_ID', $arFilter) && array_key_exists('SECTION_ID', $arFilter)) {
    //         $arFilter['IBLOCK_ID'] = $arFilter['ELEMENT_IBLOCK_ID'];
    //         $arFilter['PROPERTY_SECTION_ID'] = $arFilter['SECTION_ID'];
    //         unset($arFilter['ELEMENT_IBLOCK_ID'], $arFilter['SECTION_ID']);
    //     }
    //     $obCache = new CPHPCache();
    //     $cacheID = __FUNCTION__."_".$cacheTag.md5(serialize(array_merge((array)$arOrder, (array)$arFilter)));
    //     if($obCache->InitCache($cacheTime, $cacheID, $cachePath)){
    //         $res = $obCache->GetVars();
    //         $arRes = $res["arRes"];
    //     }
    //     else{
    //         $arRes = array();
    //         $arRes = CIBlockSection::GetCount($arFilter);
    //         self::_SaveDataCache($obCache, $arRes, $cacheTag, $cachePath, $cacheTime, $cacheID);
    //     }
    //     return $arRes;
    // }

    public static function CIBlockElement_GetList($arOrder = array("SORT" => "ASC", "CACHE" => array("MULTI" => "Y", "CACHE_GROUP" => array(false), "GROUP" => array(), "RESULT" => array(), "TAG" => "", "PATH" => "", "TIME" => 36000000, "URL_TEMPLATE" => "")), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array()){
        if (array_key_exists('ELEMENT_IBLOCK_ID', $arFilter) && array_key_exists('SECTION_ID', $arFilter)) {
            $arFilter['IBLOCK_ID'] = $arFilter['ELEMENT_IBLOCK_ID'];
            $arFilter['PROPERTY_SECTION_ID'] = $arFilter['SECTION_ID'];
            unset($arFilter['ELEMENT_IBLOCK_ID'], $arFilter['SECTION_ID']);
        }
        return parent::CIBlockElement_GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields);
        // // check filter by IBLOCK_ID === false
        // if(array_key_exists("IBLOCK_ID", ($arFilter = (array)$arFilter)) && !$arFilter["IBLOCK_ID"]){
        //     return false;
        // }

        // list($cacheTag, $cachePath, $cacheTime) = self::_InitCacheParams("iblock", __FUNCTION__, $arOrder["CACHE"]);
        // if(is_array($arSelectFields) && $arSelectFields){
        //     $arSelectFields[] = "ID";
        // }
        // $siteID = 's1';
        // if(defined('SITE_ID'))
        //     $siteID = SITE_ID;
        // $obCache = new CPHPCache();
        // $cacheID = __FUNCTION__."_".$cacheTag.md5(serialize(array_merge((array)$arOrder, array($siteID), $arFilter, (array)$arGroupBy, (array)$arNavStartParams, (array)$arSelectFields)));
        // if($obCache->InitCache($cacheTime, $cacheID, $cachePath)){
        //     $res = $obCache->GetVars();
        //     $arRes = $res["arRes"];
        // }
        // else{
        //     $arRes = array();
        //     $arResultGroupBy = array("GROUP" => $arOrder["CACHE"]["GROUP"], "MULTI" => $arOrder["CACHE"]["MULTI"], "RESULT" => $arOrder["CACHE"]["RESULT"]);
        //     $urlTemplate = $arOrder["CACHE"]["URL_TEMPLATE"];

        //     $bCanMultiSection = !isset($arOrder["CACHE"]["CAN_MULTI_SECTION"]) || $arOrder["CACHE"]["CAN_MULTI_SECTION"] === 'Y';

        //     unset($arOrder["CACHE"]);

        //     $dbRes = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields);
        //     if($arGroupBy === array()){
        //         // only count
        //         $arRes = $dbRes;
        //     }
        //     else{
        //         if(strlen($urlTemplate)){
        //             $dbRes->SetUrlTemplates($urlTemplate, '');
        //         }

        //         $arResultIDsIndexes = array();
        //         $bGetSectionIDsArray = (in_array("IBLOCK_SECTION_ID", $arSelectFields) || !$arSelectFields);
        //         if($bGetDetailPageUrlsArray = (in_array("DETAIL_PAGE_URL", $arSelectFields) || !$arSelectFields)){
        //             if($arSelectFields){
        //                 if(!in_array("IBLOCK_ID", $arSelectFields)){
        //                     $arSelectFields[] = "IBLOCK_ID";
        //                 }
        //                 if(!in_array("IBLOCK_SECTION_ID", $arSelectFields)){
        //                     $arSelectFields[] = "IBLOCK_SECTION_ID";
        //                 }
        //                 if(!in_array("ID", $arSelectFields)){
        //                     $arSelectFields[] = "ID";
        //                 }
        //                 if(!in_array("CANONICAL_PAGE_URL", $arSelectFields)){
        //                     $arSelectFields[] = "CANONICAL_PAGE_URL";
        //                 }
        //             }
        //             $bGetSectionIDsArray = true;
        //         }
        //         // fields and properties
        //         $arRes = self::_GetFieldsAndProps($dbRes, $arSelectFields, $bGetSectionIDsArray, $bCanMultiSection);
        //         if($bGetDetailPageUrlsArray){
        //             $arBySectionID = $arNewDetailPageUrls = $arCanonicalPageUrls = $arByIBlock = array();
        //             $FilterIblockID = $arFilter["IBLOCK_ID"];
        //             $FilterSectionID = $arFilter["SECTION_ID"];
        //             foreach($arRes as $arItem){
        //                 if($IBLOCK_ID = ($arItem["IBLOCK_ID"] ? $arItem["IBLOCK_ID"] : $FilterIblockID)){
        //                     if($arSectionIDs = ($arItem["IBLOCK_SECTION_ID"] ? $arItem["IBLOCK_SECTION_ID"] : $FilterSectionID)){
        //                         if(!is_array($arSectionIDs)){
        //                             $arSectionIDs = array($arSectionIDs);
        //                         }
        //                         foreach($arSectionIDs as $SID){
        //                             $arByIBlock[$IBLOCK_ID][$SID][] = $arItem["ID"];
        //                         }
        //                     }
        //                 }
        //                 else{
        //                     $arNewDetailPageUrls[$arItem["ID"]] = array($arItem["DETAIL_PAGE_URL"]);
        //                     if(strlen($arItem["CANONICAL_PAGE_URL"])){
        //                         $arCanonicalPageUrls[$arItem["ID"]] = $arItem["CANONICAL_PAGE_URL"];
        //                     }
        //                 }
        //             }

        //             foreach($arByIBlock as $IBLOCK_ID => $arIB){
        //                 $arSectionIDs = $arSections = array();
        //                 foreach($arIB as $SECTION_ID => $arIDs){
        //                     $arSectionIDs[] = $SECTION_ID;
        //                 }
        //                 if($arSectionIDs){
        //                     $arSections = CMaxCache::CIBlockSection_GetList(array("CACHE" => array("TAG" => CMaxCache::GetIBlockCacheTag($IBLOCK_ID), "MULTI" => "N", "GROUP" => array("ID"))), array("ID" => $arSectionIDs), false, array("ID", "CODE", "EXTERNAL_ID", "IBLOCK_ID"));
        //                 }
        //                 foreach($arIB as $SECTION_ID => $arIDs){
        //                     if($arIDs){
        //                         $rsElements = CIBlockElement::GetList(array(), array("ID" => $arIDs), false, false, array("ID", "DETAIL_PAGE_URL", "CANONICAL_PAGE_URL"));
        //                         $rsElements->SetUrlTemplates(CMaxCache::$arIBlocksInfo[$IBLOCK_ID]["DETAIL_PAGE_URL"]);
        //                         $rsElements->SetSectionContext($arSections[$SECTION_ID]);
        //                         while($arElement = $rsElements->GetNext()){
        //                             $arNewDetailPageUrls[$arElement["ID"]][$SECTION_ID] = $arElement["DETAIL_PAGE_URL"];
        //                             if(strlen($arElement["CANONICAL_PAGE_URL"])){
        //                                 $arCanonicalPageUrls[$arElement["ID"]] = $arElement["CANONICAL_PAGE_URL"];
        //                             }
        //                         }
        //                     }
        //                 }
        //             }

        //             foreach($arRes as $i => $arItem){
        //                 if(array_key_exists($arItem["ID"], $arNewDetailPageUrls) && count($arNewDetailPageUrls[$arItem["ID"]]) > 1){
        //                     if(isset($arCanonicalPageUrls[$arItem["ID"]]) && strlen($arCanonicalPageUrls[$arItem["ID"]])){
        //                         $arRes[$i]["DETAIL_PAGE_URL"] = $arCanonicalPageUrls[$arItem["ID"]];
        //                     }
        //                     else{
        //                         $arRes[$i]["DETAIL_PAGE_URL"] = $arNewDetailPageUrls[$arItem["ID"]];
        //                     }
        //                 }
        //                 unset($arRes[$i]["~DETAIL_PAGE_URL"]);
        //             }

        //         }

        //         if($arResultGroupBy["MULTI"] || $arResultGroupBy["GROUP"] || $arResultGroupBy["RESULT"]){
        //             $arRes = self::GroupArrayBy($arRes, $arResultGroupBy);
        //         }
        //     }

        //     self::_SaveDataCache($obCache, $arRes, $cacheTag, $cachePath, $cacheTime, $cacheID);
        // }
        // return $arRes;
    }

    private static function _InitCacheParams($moduleName, $functionName, $arCache){
        CModule::IncludeModule($moduleName);
        $cacheTag = $arCache["TAG"];
        $cachePath = $arCache["PATH"];
        $cacheTime = ($arCache["TIME"] > 0 ? $arCache["TIME"] : 36000000);
        if(!strlen($cacheTag)){
            $cacheTag = "_notag";
        }
        if(!strlen($cachePath)){
            $cachePath = "/CMaxCache/".$moduleName."/".$functionName."/".$cacheTag."/";
        }
        return array($cacheTag, $cachePath, $cacheTime);
    }

    private static function _SaveDataCache($obCache, $arRes, $cacheTag, $cachePath, $cacheTime, $cacheID){
        if($cacheTime > 0 && \Bitrix\Main\Config\Option::get("main", "component_cache_on", "Y") != "N"){
            $obCache->StartDataCache($cacheTime, $cacheID, $cachePath);

            if(strlen($cacheTag)){
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache($cachePath);
                $CACHE_MANAGER->RegisterTag($cacheTag);
                $CACHE_MANAGER->EndTagCache();
            }

            $obCache->EndDataCache(array("arRes" => $arRes));
        }
    }
}