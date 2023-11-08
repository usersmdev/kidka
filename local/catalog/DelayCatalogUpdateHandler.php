<?php

use rumaster\bitrix\db\SectionQuery;
use rumaster\helpers\StringHelper;
use rumaster\helpers\ArrayHelper;
use Rumaster\Utils\Dumper;

\Bitrix\Main\Loader::includeModule('rumaster.utils');

class DelayCatalogUpdateHandler {
    // const PROP_CML2_LINK_CODE = 'CML2_LINK';
    // const PROP_CML2_LINK_ID = 'CML2_LINK';
    // const PROP_CODE_AVAILABLE = 'PROP_AVAILABLE';
    // const PROP_VALUE_ID_AVAILABLE = '31907';

    // const PROP_CODE_FROM_COLOR = 'TSVET_RGB_OSNOVNOY';
    // const PROP_CODE_TO_COLOR = 'TSVET_FILTER';
    // const PROP_CODE_FROM_SIZE = 'RAZMER_ODEZHDY';
    // const PROP_CODE_TO_SIZE = 'RAZMER_FILTER';

    public static function OnAfterIBlockElementAdd($fields)
    {
        self::addDelayFromFields($fields);
    }

    public static function OnAfterIBlockElementUpdate($fields)
    {
        self::addDelayFromFields($fields);
    }

    public static function OnBeforeIBlockElementDelete($id)
    {
        // $productId = self::getOfferProductId($id);
        // self::addDelayUpdateProduct($productId);
    }

    public static function OnProductAdd($id, $fields)
    {
        // if (array_key_exists($id, self::$delayIds)) {
        //     return;
        // }
        // $elementFields = self::getOfferProduct($id);
        // if ($elementFields) {
        //     if (self::isCatalogItem($elementFields)) {
        //         self::addDelayUpdateProduct($elementFields['ID']);
        //     }
        //     if (self::isOfferItem($elementFields) && $elementFields['PROPERTY_'.self::PROP_CML2_LINK_CODE.'_VALUE']) {
        //         self::addDelayUpdateProduct($elementFields['PROPERTY_'.self::PROP_CML2_LINK_CODE.'_VALUE']);
        //     }
        // }
    }

    public static function OnProductUpdate($id, $fields)
    {
        // if (array_key_exists($id, self::$delayIds)) {
        //     return;
        // }
        // $elementFields = self::getOfferProduct($id);
        // if ($elementFields) {
        //     if (self::isCatalogItem($elementFields)) {
        //         self::addDelayUpdateProduct($elementFields['ID']);
        //     }
        //     if (self::isOfferItem($elementFields) && $elementFields['PROPERTY_'.self::PROP_CML2_LINK_CODE.'_VALUE']) {
        //         self::addDelayUpdateProduct($elementFields['PROPERTY_'.self::PROP_CML2_LINK_CODE.'_VALUE']);
        //     }
        // }
    }

    public static function isCatalogItem($fields)
    {
        return !empty($fields['IBLOCK_ID']) && ($fields['IBLOCK_ID'] == CATALOG_IBLOCK_ID);
    }

    public static function getPropValue($fields, $propId)
    {
        $values = !empty($fields['PROPERTY_VALUES'][$propId])
            ? $fields['PROPERTY_VALUES'][$propId]
            : null;
        if ($values && is_array($values)) {
            $value = reset($values);
            if (is_array($value) && array_key_exists('VALUE', $value)) {
                return $value['VALUE'];
            }
            return $value;
        }
        return null;
    }

    public static function addDelayFromFields($fields)
    {
        if (empty($fields['ID'])) {
            return;
        }
        if (self::isCatalogItem($fields)) {
            self::addDelayUpdateProduct($fields['ID']);
        }
    }

    public static function addAllDelayUpdateProduct()
    {
    
        $q = new \rumaster\bitrix\db\ElementQuery();
        $q->from(CATALOG_IBLOCK_ID)
            ->select(['ID']);
        $ids = ArrayHelper::getColumn($q->all(), 'ID');
        foreach ($ids as $id) {
            static::addDelayUpdateProduct($id);
        }
    }

    public static function log() {
         $arArgs = func_get_args();
         $sResult = '';
         foreach($arArgs as $arArg) {
           $sResult .= print_r($arArg, true)."\n";
         }
         file_put_contents(__FILE__ . '.log', $sResult, FILE_APPEND);
    }

    public static function addDelayUpdateProduct($productId)
    {
        // var_dump('addDelayUpdateProduct', $productId, self::$delayIds);
        $dir = __DIR__;
        $file = "{$dir}/delay_modify_products.txt";
        file_put_contents($file,"{$productId}\n", FILE_APPEND);
    }

    public static function _loadCatalogItems($filter, $select)
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')
            || !\Bitrix\Main\Loader::includeModule('sale')) {
            return [];
        }
        $r = \CIBlockElement::GetList([], $filter,false,false, $select);

        $result = [];
        while($row = $r->GetNextElement()) {
            $fields = $row->GetFields();
            $fields['PROPERTIES'] = $row->GetProperties();
            $result[$fields['ID']] = $fields;
        }
        return $result;
    }

    public static function strStartsWith($string, $with)
    {
        return StringHelper::startsWith($string, $with);
    }

    public static function strEndsWith($string, $with)
    {
        return StringHelper::endsWith($string, $with);
    }

    public static function strRemoveStart($string, $with)
    {
        return StringHelper::removeStart($string, $with);
    }

    public static function strRemoveEnd($string, $with)
    {
        return StringHelper::removeEnd($string, $with);
    }

    private static function prepareCatalogItems($item, $propCodes)
    {
        // Dumper::dump($item['PROPERTIES']['HIT']);
        foreach ($item['PROPERTIES'] as $key => $prop) {
            if (!in_array($key, $propCodes)) {
                continue;
            }
            $item[$key] = $prop['MULTIPLE'] == 'Y' && empty($prop['VALUE']) ? [] : $prop['VALUE'];
            $item[$key.'_XML_ID'] = $prop['VALUE_XML_ID'];
            $item[$key.'_ID'] = $prop['MULTIPLE'] == 'Y' && empty($prop['VALUE_ENUM_ID']) ? [] : $prop['VALUE_ENUM_ID'];
            // var_dump($key);
            // var_dump($prop);
        }
        unset($item['PROPERTIES']);
        // Dumper::dump($item);
        // foreach ($item as $key => $value) {
        //     if (!self::strStartsWith($key, 'PROPERTY_')) {
        //         continue;
        //     }
        //     $code = self::strRemoveStart($key, 'PROPERTY_');
        //     if (self::strEndsWith($code, '_VALUE')) {
        //         $code = StringHelper::removeEnd($code, '_VALUE');
        //         $item[$code] = $value;
        //     }
        //     if (self::strEndsWith($code, '_ENUM_ID')) {
        //         $code = StringHelper::removeEnd($code, '_ENUM_ID');
        //         $item[$code.'__ID'] = $value;
        //     }
        //     unset($item[$key]);
        // }
        return $item;
    }

    public static function loadCatalogItems($ids)
    {
        $fields = [
            'ID',
            'CODE',
            'ACTIVE' => 'Y',
            'IBLOCK_ID',
            // 'PROPERTY_SECTION_ID',
            // 'PROPERTY_SECTION_CODE',
            // 'PROPERTY_SECTION_PATH',
            // 'PROPERTY_SECTION_CODE_PATH',
            'PROPERTY_*',
        ];
        $items = self::_loadCatalogItems([
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            '=ID' => $ids,
            'ACTIVE' => 'Y',
        ], array_merge($fields, []));
// var_dump($ids);
// var_dump($items);
        foreach ($items as $k => $item) {
            $item = self::prepareCatalogItems($item, [
                'SECTION_ID',
                'SECTION_CODE',
                'SECTION_PATH',
                'SECTION_CODE_PATH',
                'PRODUCT_URL',
                'HIT',
                'NOVINKA',
                'TOP_TOVAROV',
                'RASPRODAZHA',
            ]);
            $items[$k] = $item;
        }

        return $items;
    }

    public static function getPropEnums($iblockId, $propCode)
    {
        static $enums = [];
        if (!array_key_exists($iblockId, $enums) || !array_key_exists($propCode, $enums[$iblockId])) {
            $r = CIBlockPropertyEnum::GetList(
                ["DEF" => "DESC", "SORT" => "ASC"],
                ["IBLOCK_ID" => $iblockId, "CODE" => $propCode]
            );
            $result = [];
            while($fields = $r->Fetch()) {
                $result[$fields['ID']] = [
                    'XML_ID' => $fields['XML_ID'],
                    'VALUE' => $fields['VALUE'],
                ];
            }
            $enums[$iblockId][$propCode] = $result;
        }

        return $enums[$iblockId][$propCode];
    }

    public static function haveAnyPrice($offer, $item = false) {
        if (!$offer) {
            return false;
        }
        $isItem = false;
        if (!$item && $offer) {
            $item = $offer;
            $offer = false;
            $isItem = true;
        }
        if ($isItem) {
            return !empty($item['PRICES']);
        }
        if (!$isItem) {
            return !empty($offer['PRICES']);
        }
        return false;
    }

    public static function _getMinPrice($item) {
        if ($item['SALE'] && ($item['SALE'] == 'Y')) {
            $optPrice = \CCatalogProduct::GetOptimalPrice(
                $item['ID'],
                1,
                [],
                'N',
                $item['PRICES']
            );
            return $optPrice['DISCOUNT_PRICE'];
        }

        $minPrice = reset($item['PRICES']);
        foreach ($item['PRICES'] as $price) {
            if ($minPrice['PRICE'] < $price['PRICE']) {
                $minPrice = $price;
            }
        }

        return $minPrice['PRICE'];
    }

    public static function getMinPrice($offer, $item = false) {
        if (!$offer) {
            return 0;
        }
        $isItem = false;
        if (!$item && $offer) {
            $item = $offer;
            $offer = false;
            $isItem = true;
        }
        if ($isItem && !empty($item['PRICES'])) {
            return static::_getMinPrice($item);
        }
        if (!$isItem) {
            if (!empty($offer['PRICES'])) {
                return static::_getMinPrice($offer);
            }

            if (!empty($item['PRICES'])) {
                return static::_getMinPrice($item);
            }
        }
        return 0;
    }

//    public static function setElementProp($iblockId, $elementId, $propId, $propValue)
//    {
//        static::log_array(
//            'CIBlockElement::SetPropertyValuesEx',
//            [$elementId, $iblockId, array($propId => $propValue)]
//        );
//        CIBlockElement::SetPropertyValuesEx($elementId, $iblockId, array($propId => $propValue));
//    }
    public static function getSections()
    {
        static $sections;
        if ($sections === null) {
            $q = new SectionQuery();
            $q->from(SECTION_IBLOCK_ID)
                ->select(['ID', 'NAME', 'CODE', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'SECTION_PAGE_URL']);
    
            $sections = $q->all();
        }
        return $sections;
    }

    public static function getSectionByNameAndDepth($name, $parentSectionId=null)
    {
        static $sectionNames = [];
        $sections = static::getSections();
        foreach ($sections as $section) {
            if ($section['IBLOCK_SECTION_ID'] != $parentSectionId) {
                continue;
            }
            if ($section['NAME'] == $name) {
                $sectionNames[$parentSectionId][$name] = $section;
                return $section;
            }
        }
        return false;
    }

    public static function getSectionIdPathPath($path)
    {
        static $paths = [];
        if (array_key_exists($path, $paths)) {
            return $paths[$path];
        }
        $paths = preg_split('/\s*\/\s*/', $path, -1, PREG_SPLIT_NO_EMPTY);
        $sections = [];
        $prevSection = null;
        foreach ($paths as $_path) {
            $section = static::getSectionByNameAndDepth($_path, $prevSection);
            if ($section) {
                $sections[] = $section;
                $prevSection = $section['ID'];
            }
            else {
                break;
            }
        }
        $sectionIds = ArrayHelper::getColumn($sections, 'ID');
        // return [
        //     'paths' => $paths,
        //     'sections' => $sections,
        //     'sectionIds' => $sectionIds,
        // ];
        $sectionId = !empty($sectionIds) ? end($sectionIds) : null;
        if ($sectionId) {
            $paths[$path] = $sectionId;
            return $sectionId;
        }
        return null;
    }

    public static function getSection($id)
    {
        static $codes = [];
        if (array_key_exists($id, $codes)) {
            return $codes[$id];
        }
        $sections = static::getSections();
        foreach ($sections as $section) {
            if ($section['ID'] == $id) {
                $codes[$id] = $section;
                return $section;
            }
        }
        return '';
    }

    private static $delayIds = [];
    public static function startUpdate($ids)
    {
        if (!is_array($ids)) {
            return;
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            return;
        }

        $iblocks = IblockHelper::_getIblocks();
        $iblock = $iblocks[CATALOG_IBLOCK_ID];
        foreach(array_chunk($ids, 50, true) as $_ids) {
            $items = self::loadCatalogItems($_ids);
            // foreach($items as $item) {
            //     self::$delayIds[$item['ID']] = $item['ID'];
            // }
//            \rumaster\Dumper::dump($items, 10, true);
            foreach($items as $item) {
                // $sectionPath = $item['SECTION_PATH'];
                // $sectionId = static::getSectionIdPathPath($sectionPath);
                // $section = static::getSection($sectionId);
                // $sectionCode = $section ? $section['CODE'] : '';
                // $productUrl = StringHelper::removeStart($iblock['DETAIL_PAGE_URL'], $iblock['SECTION_PAGE_URL']);
                // $productUrl = strtr($section['SECTION_PAGE_URL'].$productUrl, [
                //     '#ID#' => $item['ID'],
                //     '#CODE#' => $item['CODE'],
                //     '#ELEMENT_ID#' => $item['ID'],
                //     '#ELEMENT_CODE#' => $item['CODE'],
                // ]);

                // \rumaster\Dumper::dump([
                //     'productUrl' => $productUrl,
                //     'item' => $item,
                //     'section' => $section,
                //     'iblock' => $iblock,
                // ], 10, false);

                $modify = [];

                // if ($sectionId != $item['SECTION_ID']) {
                //     $modify['SECTION_ID'] = $sectionId;
                // }
                // if ($sectionCode != $item['SECTION_CODE']) {
                //     $modify['SECTION_CODE'] = $sectionCode;
                // }
                // if ($productUrl != $item['PRODUCT_URL']) {
                //     $modify['PRODUCT_URL'] = $productUrl;
                // }
                
                $hit = [];
                foreach (static::getPropEnums(CATALOG_IBLOCK_ID, 'HIT') as $hitId => $hitValue) {
                    if (($hitValue['XML_ID'] == 'NEW') && ($item['NOVINKA_XML_ID'] === 'true')) {
                        $hit[] = $hitId;
                    }
                    if (($hitValue['XML_ID'] == 'STOCK') && ($item['RASPRODAZHA_XML_ID'] === 'true')) {
                        $hit[] = $hitId;
                    }
                    if (($hitValue['XML_ID'] == 'HIT') && ($item['TOP_TOVAROV_XML_ID'] === 'true')) {
                        $hit[] = $hitId;
                    }
                }
                if (!empty(array_diff($hit, $item['HIT_ID'])) || !empty(array_diff($item['HIT_ID'], $hit))) {
                    $modify['HIT'] = !empty($hit) ? $hit : null;
                }
                // Dumper::dump([
                //     'item' => $item,
                //     'modify' => $modify,
                // ], 10, false);

                /*?><pre><?print_r([
                    'item' => $item,
                    'modify' => $modify,
                    'sectionId' => $sectionId,
                    'sectionCode' => $sectionCode,
                ]);?></pre><?*/
                if (!empty($modify)) {
                    \CIBlockElement::SetPropertyValuesEx($item['ID'], CATALOG_IBLOCK_ID, $modify);
                }
            }
        }
    }
}