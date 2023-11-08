<?php

\Bitrix\Main\Loader::includeModule('rumaster.utils');

use Rumaster\Utils\Helpers\StringHelper;

class IblockHelper {
    public static function inited()
    {
        static $inited;
        if ($inited === null) {
            $inited = \Bitrix\Main\Loader::includeModule('rumaster.utils') &&
                \Bitrix\Main\Loader::includeModule('iblock');
        }
        return $inited;
    }

    public static function _fetchRows($query, $fields=[], $index=null) {
        $result = [];
        while($rawRow = $query->Fetch()) {
            $row = [];
            if (empty($fields)) {
                $row = $rawRow;
            }
            else {
                foreach ($fields as $field) {
                    $row[$field] = $rawRow[$field];
                }
            }
            if ($index === null) {
                $result[] = $row;
            }
            else {
                $key = $rawRow[$index];
                $result[$key] = $row;
            }
        }
        return $result;
    }

    public static function _getIblocks() {
        static $iblocks;
        if ($iblocks === null) {
            $cacheId = [
                'IblockHelper::_getIblocks',
            ];
            $iblocks = \rumaster\Cache::getOrSet($cacheId, function(){
                $r = \CIblock::GetList();
                return static::_fetchRows(
                    $r,
                    [
                        'ID', 'NAME', 'IBLOCK_TYPE_ID', 'CODE', 'LID', 'ACTIVE', 'XML_ID',
                        'LIST_PAGE_URL', 'DETAIL_PAGE_URL', 'SECTION_PAGE_URL',
                    ],
                    'ID'
                );
            });
        }
        return $iblocks;
    }

    public static function _getProps($iblockId) {
        static $props = [];
        if (!array_key_exists($iblockId, $props)) {
            $cacheId = [
                'IblockHelper::_getProps',
                'IBLOCK' => $iblockId,
            ];
            $props[$iblockId] = \rumaster\Cache::getOrSet($cacheId, function($params){
                $r = \CIBlockProperty::GetList(
                    [],
                    ['IBLOCK_ID' => $params['IBLOCK']]
                );
                return static::_fetchRows(
                    $r,
                    ['ID', 'NAME', 'CODE', 'XML_ID'],
                    'ID'
                );
            });
        }
        return $props[$iblockId];
    }

    public static function _getPropValues($iblockId, $propId) {
        static $propValues = [];
        if (!array_key_exists($iblockId, $propValues) 
            || !array_key_exists($propId, $propValues[$iblockId])) {
            $cacheId = [
                'IblockHelper::_getProps',
                'IBLOCK' => $iblockId,
                'PROP' => $propId,
            ];
            $propValues[$iblockId][$propId] = \rumaster\Cache::getOrSet($cacheId, function($params){
                $r = \CIBlockPropertyEnum::GetList([], [
                    "IBLOCK_ID" => $params['IBLOCK'],
                    "PROPERTY_ID" => $params['PROP'],
                ]);
                return static::_fetchRows($r, [], 'ID');
            });
        }
        
        return $propValues[$iblockId][$propId];
    }

    public static function _getIblockId($iblockFilter)
    {
        if (!$iblockFilter) {
            return null;
        }
        if (!static::inited()) {
            return null;
        }

        static $iblockCache = [];

        if (array_key_exists($iblockFilter, $iblockCache)) {
            return $iblockCache[$iblockFilter];
        }

        $iblocks = static::_getIblocks();
        foreach ($iblocks as $iblock) {
            foreach (['ID', 'XML_ID', 'CODE'] as $field) {
                if ($iblock[$field] == $iblockFilter) {
                    $iblockCache[$iblockFilter] = $iblock['ID'];
                    return $iblock['ID'];
                }
            }
        }
        return null;
    }

    public static function _getPropId($iblockId, $propFilter)
    {
        if (!$propFilter) {
            return null;
        }
        if (!static::inited()) {
            return null;
        }
        static $propCache = [];

        if (array_key_exists($iblockId, $propCache) 
            && array_key_exists($propFilter, $propCache[$iblockId])) {
            return $propCache[$iblockId][$propFilter];
        }

        $props = static::_getProps($iblockId);
        foreach ($props as $prop) {
            foreach (['ID', 'XML_ID', 'CODE'] as $field) {
                if ($prop[$field] == $propFilter) {
                    $propCache[$iblockId][$propFilter] = $prop['ID'];
                    return $prop['ID'];
                }
            }
        }
        return null;
    }

    public static function _getPropValueId($iblockId, $propId, $propValueFilter)
    {
        if (!static::inited()) {
            return null;
        }

        static $propValueCache = [];

        if (array_key_exists($iblockId, $propValueCache)
            && array_key_exists($propId, $propValueCache[$iblockId])
            && array_key_exists($propValueFilter, $propValueCache[$iblockId][$propId])) {
            return $propValueCache[$propValueFilter];
        }

        $values = static::_getPropValues($iblockId, $propId);
        foreach ($values as $value) {
            foreach (['ID', 'XML_ID', 'VALUE'] as $field) {
                if ($value[$field] == $propValueFilter) {
                    $propValueCache[$iblockId][$propId][$propValueFilter] = $value['ID'];
                    return $value['ID'];
                }
            }
        }
        return null;
    }

    public static function getPropValue($iblockFilter, $propFilter, $propValueFilter)
    {
        $iblockId = static::_getIblockId($iblockFilter);
        if (!$iblockId) {
            return null;
        }

        $propId = static::_getPropId($iblockId, $propFilter);
        if (!$propId) {
            return null;
        }

        $valueId = static::_getPropValueId($iblockId, $propId, $propValueFilter);
        return $valueId;
    }

    public static function getSectionsUrls()
    {
        static $urls;
        if ($urls === null) {
            $cacheId = [
                'IblockHelper::getSectionsUrls',
                'IBLOCK_ID' => SECTION_IBLOCK_ID,
            ];
            $urls = \rumaster\Cache::getOrSet($cacheId, function($params){
                $r = \CIBlockSection::GetList([], ['IBLOCK_ID' => $params['IBLOCK_ID']], false, ['ID', 'SECTION_PAGE_URL', 'CODE']);
                $urls = [];
                while($section = $r->GetNext()) {
                    $urls[$section['SECTION_PAGE_URL']] = [
                        'ID' => $section['ID'],
                        'CODE' => $section['CODE'],
                    ];
                }
                return $urls;
            });
        }
        return $urls;
    }

    public static function modifyComponentSefVariables(&$componentPage, &$variables, $params)
    {
        if (empty($variables)) {
            return;
        }
        if (!empty($variables['SECTION_CODE_PATH']) && (
            !empty($variables['SECTION_ID'])
            || !empty($variables['SECTION_CODE'])
        )) {
            return;
        }

        $urls = static::getSectionsUrls();
        $parts = preg_split('/\//', $variables['SECTION_CODE_PATH']);
        $elementCode = array_pop($parts);
        $sectionUrlPath = implode('/', $parts);
        $sectionUrl = $params['SEF_FOLDER'].$sectionUrlPath.'/';

        if (array_key_exists($sectionUrl, $urls)) {
            $section = $urls[$sectionUrl];
            $variables['SECTION_ID'] = $section['ID'];
            $variables['SECTION_CODE'] = $section['CODE'];
            $variables['SECTION_CODE_PATH'] = $sectionUrlPath;
            $variables['ELEMENT_CODE'] = $elementCode;
            $componentPage = 'element';
        }
    }

    public static function _getSectionCodePath()
    {
        static $codePaths;
        if ($codePaths === null) {
            $cacheId = [
                'IblockHelper::_getSectionCodePath',
                'IBLOCK_ID' => SECTION_IBLOCK_ID,
            ];
            $codePaths = \rumaster\Cache::getOrSet($cacheId, function($params){
                $r = \CIBlockSection::GetList([], ['IBLOCK_ID' => $params['IBLOCK_ID']], false, ['ID', 'CODE', 'SECTION_PAGE_URL', 'LIST_PAGE_URL']);
                $urls = [];
                while($section = $r->GetNext()) {
                    $codePath = $section['SECTION_PAGE_URL'];
                    $codePath = StringHelper::removeStart($codePath, $section['LIST_PAGE_URL']);
                    $codePath = StringHelper::removeEnd($codePath, '/');
                    $urls[$section['ID']] = [
                        'ID' => $section['ID'],
                        'CODE' => $section['CODE'],
                        'URL' => $section['SECTION_PAGE_URL'],
                        'CODE_PATH' => $codePath,
                    ];
                }
                return $urls;
            });
        }
        return $codePaths;
    }

    public static function getSectionCodePath($id)
    {
        $codePaths = static::_getSectionCodePath();
        return [
            $id,
            $codePaths[$id],
        ];
    }

    public static function findValuePath($arResult, $value)
    {
        $keys = [];
        foreach ($arResult as $key => $_value) {
            if ($value === $_value) {
                $keys[$key] = $_value;
            }
            elseif (is_array($_value)) {
                $find = static::findValuePath($_value, $value);
                if (!empty($find)) {
                    $keys[$key] = $find;
                }
            }
        }
        return $keys;
    }

    public static function findValues($arResult, $values)
    {
        foreach ($values as $value) {
            $keys = static::findValuePath($arResult, $value);
            \rumaster\Dumper::dump([
                $value,
                $keys,
            ], 10, true);
        }
    }

    public static function getElementUrl($id) 
    {
        $e_data = '';
        $rs = CIBlockElement::GetList(
            [],
            ['ID' => $id],
            false, false,
            ['ID', 'PROPERTY_PRODUCT_URL']
        );
        if ($ar = $rs->Fetch()) {
            $e_data =  $ar;
            return $e_data['PROPERTY_PRODUCT_URL_VALUE']
                ? $e_data['PROPERTY_PRODUCT_URL_VALUE']
                : '';
        }
        return '';
    }

    public static function OnSaleComponentOrderResultPrepared($order, &$arUserResult, $request, &$arParams, &$arResult)   
    {
        // static::findValues($arResult, ['/products/molding-s-risunkom-decomaster-dt-9080-35-10-2400mm/']);
        foreach ($arResult['JS_DATA']['GRID']['ROWS'] as &$item) {
            $item['data']['DETAIL_PAGE_URL'] = static::getElementUrl($item['data']['PRODUCT_ID']);
        }
        unset($item);

        foreach ($arResult['GRID']['ROWS'] as &$item) {
            $item['data']['DETAIL_PAGE_URL'] = static::getElementUrl($item['data']['PRODUCT_ID']);
        }
        unset($item);

        foreach ($arResult['BASKET_ITEMS'] as &$item) {
            $item['DETAIL_PAGE_URL'] = static::getElementUrl($item['PRODUCT_ID']);
        }
        unset($item);
    }

    public static function replaceCatalogSeo(&$arResult, $arParams) {
        $arSelect = [];
        $arFilter = array(
            "IBLOCK_ID"=>$arParams["SECTION_IBLOCK_ID"],
            "IBLOCK_ACTIVE"=>"Y",
            "ACTIVE"=>"Y",
            "GLOBAL_ACTIVE"=>"Y",
        );
        if($arParams["EXT_SECTION_ID"] > 0)
        {
            $arFilter["ID"] = $arParams["EXT_SECTION_ID"];
            $rsSection = CIBlockSection::GetList([], $arFilter, false, $arSelect);
            $rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
            $extSection = $rsSection->GetNext();
        }
        elseif(strlen($arParams["EXT_SECTION_CODE"]) > 0)
        {
            $arFilter["=CODE"] = $arParams["EXT_SECTION_CODE"];
            $rsSection = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
            $rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
            $extSection = $rsSection->GetNext();
        }

        // print_r($arParams);
        // var_dump($arResult['PATH']);

        if ($extSection && ($extSection["ID"] > 0))
        {
            $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["SECTION_IBLOCK_ID"], $extSection["ID"]);
            $extSection["IPROPERTY_VALUES"] = $ipropValues->getValues();
        }

        if($extSection && ($extSection["ID"] > 0) && $arParams["ADD_SECTIONS_CHAIN"])
        {
            $extSection["PATH"] = [];
            $rsPath = CIBlockSection::GetNavChain($arParams["SECTION_IBLOCK_ID"], $extSection["ID"]);
            $rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
            while($arPath = $rsPath->GetNext())
            {
                $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["SECTION_IBLOCK_ID"], $arPath["ID"]);
                $arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
                $extSection["PATH"][] = $arPath;
            }
        }

//         if (!empty($arParams['EXT_IBLOCK_ID']) && !empty($arParams['EXT_SECTION_ID'])) {
// 	$arSections = [];
// 	$rsPath = CIBlockSection::GetNavChain($arParams["EXT_IBLOCK_ID"], $arParams["EXT_SECTION_ID"]);
// 	$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
// 	while ($arPath = $rsPath->GetNext())
// 	{
// 		$arSections[$arParams["EXT_SECTION_ID"]][] = $arPath;
// 	}
// 	$arResult['SECTION']['PATH'] = $arSections[$arParams["EXT_SECTION_ID"]];
// }
        // print_r($arResult['SECTION']);

        foreach (['ID', 'NAME', 'IPROPERTY_VALUES', 'PATH'] as $field) {
            if (array_key_exists('DETAIL_TEXT', $arResult)) {
                if (array_key_exists($field, $extSection)) {
                    $arResult['SECTION'][$field] = $extSection[$field];
                }
                if (array_key_exists('~'.$field, $extSection)) {
                    $arResult['SECTION']['~'.$field] = $extSection['~'.$field];
                }
            }
            else {
                if (array_key_exists($field, $extSection)) {
                    $arResult[$field] = $extSection[$field];
                }
                if (array_key_exists('~'.$field, $extSection)) {
                    $arResult['~'.$field] = $extSection['~'.$field];
                }
            }
        }

        // print_r($arParams["EXT_SECTION_ID"]);
        // print_r($extSection['PATH']);
        // print_r(array_key_exists('ITEMS', $arResult) ? 'Y' : 'N');
        // print_r($arResult["SECTION"]);
        // print_r($extSection);
    }
}