<?php

use \Bitrix\Main\Type\Collection,
	\Bitrix\Main\Loader,
	\Bitrix\Main\IO\File,
	\Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Config\Option;
    
use rumaster\bitrix\db\SectionQuery;
use rumaster\helpers\Treeable;
use Rumaster\Utils\Collections\TreeIds;
use Rumaster\Utils\Dumper;

if (!Loader::includeModule('rumaster.utils')) return;




class CatalogHelper {
    public static function fixItems(&$result, $params, $context=[])
    {
        // foreach($result['ITEMS'] as &$item) {
        //     $context['is_list'] = true;
        //     static::fixItem($item, $params, $context);
        // }
    }

    public static function fixItem(&$item, $params, $context = [])
    {
        // if (empty($context)) {
        //     if (array_key_exists('CANONICAL_PAGE_URL', $item) && !empty($item['PROPERTIES']['PRODUCT_URL']['VALUE'])) {
        //         // print_r([
        //         //     'ID' => $item['ID'],
        //         //     'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
        //         //     'PRODUCT_URL' => $item['PROPERTIES']['PRODUCT_URL']['VALUE'],
        //         // ]);
        //         $item['CANONICAL_PAGE_URL'] = str_replace(
        //             $item['DETAIL_PAGE_URL'],
        //             $item['PROPERTIES']['PRODUCT_URL']['VALUE'],
        //             $item['CANONICAL_PAGE_URL']
        //         );
        //     }
        // }
        // if ($context['viewed_products']) {
            
        // }
        // if (array_key_exists('DETAIL_PAGE_URL', $item) && !empty($item['PROPERTIES']['PRODUCT_URL']['VALUE'])) {
        //     $item['DETAIL_PAGE_URL'] = $item['PROPERTIES']['PRODUCT_URL']['VALUE'];
        // }
    }

    public static function getSectionWithSubsectionIds($sectionId)
    {
        static $tree;
        if ($tree === null) {
            $q = new SectionQuery();
            $q->from(SECTION_IBLOCK_ID)
                ->select(['ID', 'IBLOCK_SECTION_ID']);
            
            $tree = new TreeIds($q->all(), 'ID', 'IBLOCK_SECTION_ID');
        }
        $ids = $tree->getAllChilds($sectionId);
        return !empty($ids) ? $ids : $sectionId;
    }

    public static function fixCatalogFilter($filterName, $sectionId)
    {
        if (empty($GLOBALS[$filterName])) {
            $GLOBALS[$filterName] = [];
        }
        $GLOBALS[$filterName]['!PROPERTY_SECTION_ID'] = false;
        $GLOBALS[$filterName]['PROPERTY_SECTION_ID'] = static::getSectionWithSubsectionIds($sectionId);
    }

    static $_urls = [];
    public static function getProductUrl($itemId)
    {
        // if (!array_key_exists($itemId, static::$_urls)) {
        //     $r = CIBlockElement::GetList([], ['IBLOCK_ID' => CATALOG_IBLOCK_ID, 'ID' => $itemId, 'ACTIVE'=>'Y'], false, false, ['ID', 'IBLOCK_ID', 'PROPERTY_PRODUCT_URL']);
        //     $el = $r->Fetch();
        //     $url = !empty($el['PROPERTY_PRODUCT_URL_VALUE']) ? $el['PROPERTY_PRODUCT_URL_VALUE'] : '';
        //     static::$_urls[$itemId] = $url;
        // }
        // return static::$_urls[$itemId];
    }

    public static function fixBasketUrls(&$items)
    {
        // foreach ($items as &$item) {
        //     $newDetailUrl = static::getProductUrl($item['PRODUCT_ID']);
        //     $item['~DETAIL_PAGE_URL'] = $newDetailUrl;
        //     $item['DETAIL_PAGE_URL'] = htmlspecialcharsEx($newDetailUrl);
        // }
    }   

    public static function getQuantityArray($totalCount, $arItemIDs = array(), $useStoreClick="N", $bShowAjaxItems = false, $dopClass = '')
    {
        return;
        /*?><pre><? print_r([
            'totalCount' => $totalCount,
            'arItemIDs' => $arItemIDs,
            'useStoreClick' => $useStoreClick,
            'bShowAjaxItems' => $bShowAjaxItems,
            'dopClass' => $dopClass,
        ]); ?></pre><?*/
        if($productType == 2)
			return;

		static $arQuantityOptions, $arQuantityRights;
		if($arQuantityOptions === NULL){
			$arQuantityOptions = array(
				"USE_WORD_EXPRESSION" => Option::get(CMax::moduleID, "USE_WORD_EXPRESSION", "Y", SITE_ID),
				"MAX_AMOUNT" => Option::get(CMax::moduleID, "MAX_AMOUNT", "10", SITE_ID),
				"MIN_AMOUNT" => Option::get(CMax::moduleID, "MIN_AMOUNT", "2", SITE_ID),
				"EXPRESSION_FOR_MIN" => Option::get(CMax::moduleID, "EXPRESSION_FOR_MIN", GetMessage("EXPRESSION_FOR_MIN_DEFAULT"), SITE_ID),
				"EXPRESSION_FOR_MID" => Option::get(CMax::moduleID, "EXPRESSION_FOR_MID", GetMessage("EXPRESSION_FOR_MID_DEFAULT"), SITE_ID),
				"EXPRESSION_FOR_MAX" => Option::get(CMax::moduleID, "EXPRESSION_FOR_MAX", GetMessage("EXPRESSION_FOR_MAX_DEFAULT"), SITE_ID),
				"EXPRESSION_FOR_EXISTS" => Option::get(CMax::moduleID, "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID),
				"EXPRESSION_FOR_NOTEXISTS" => Option::get(CMax::moduleID, "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS_DEFAULT"), SITE_ID),
				"SHOW_QUANTITY_FOR_GROUPS" => (($tmp = Option::get(CMax::moduleID, "SHOW_QUANTITY_FOR_GROUPS", "", SITE_ID)) ? explode(",", $tmp) : array()),
				"SHOW_QUANTITY_COUNT_FOR_GROUPS" => (($tmp = Option::get(CMax::moduleID, "SHOW_QUANTITY_COUNT_FOR_GROUPS", "", SITE_ID)) ? explode(",", $tmp) : array()),
			);

			$arQuantityRights = array(
				"SHOW_QUANTITY" => false,
				"SHOW_QUANTITY_COUNT" => false,
			);

			global $USER;
			$res = CUser::GetUserGroupList(CMax::GetUserID());
			while ($arGroup = $res->Fetch()){
				if(in_array($arGroup["GROUP_ID"], $arQuantityOptions["SHOW_QUANTITY_FOR_GROUPS"])){
					$arQuantityRights["SHOW_QUANTITY"] = true;
				}
				if(in_array($arGroup["GROUP_ID"], $arQuantityOptions["SHOW_QUANTITY_COUNT_FOR_GROUPS"])){
					$arQuantityRights["SHOW_QUANTITY_COUNT"] = true;
				}
			}
        }
        /*?><pre><? print_r([
            'arQuantityOptions' => $arQuantityOptions,
            'arQuantityRights' => $arQuantityRights,
        ]); ?></pre><?*/

		$indicators = 0;
		$totalAmount = $totalText = $totalHTML = $totalHTMLs = '';

		if($arQuantityRights["SHOW_QUANTITY"]){
			if($totalCount > $arQuantityOptions["MAX_AMOUNT"]){
				$indicators = 3;
				$totalAmount = $arQuantityOptions["EXPRESSION_FOR_MAX"];
			}
			elseif($totalCount < $arQuantityOptions["MIN_AMOUNT"] && $totalCount > 0){
				$indicators = 1;
				$totalAmount = $arQuantityOptions["EXPRESSION_FOR_MIN"];
			}
			else{
				$indicators = 2;
				$totalAmount = $arQuantityOptions["EXPRESSION_FOR_MID"];
			}

			if($totalCount > 0){
				if($arQuantityRights["SHOW_QUANTITY_COUNT"]){
					$totalHTML = '<span class="first'.($indicators >= 1 ? ' r' : '').'"></span><span class="'.($indicators >= 2 ? ' r' : '').'"></span><span class="last'.($indicators >= 3 ? ' r' : '').'"></span>';
				}
				else{
					$totalHTML = '<span class="first r"></span>';
				}
			}
			else{
				$totalHTML = '<span class="null"></span>';
			}

			if($totalCount > 0)
			{
				if($useStoreClick=="Y")
					$totalText = "<span class='store_view dotted'>".$arQuantityOptions["EXPRESSION_FOR_EXISTS"].'</span>';
				else
					$totalText = $arQuantityOptions["EXPRESSION_FOR_EXISTS"];
			}
			else
			{
				if($useStoreClick=="Y")
					$totalText = "<span class='store_view dotted'>".$arQuantityOptions["EXPRESSION_FOR_NOTEXISTS"].'</span>';
				else
					$totalText = $arQuantityOptions["EXPRESSION_FOR_NOTEXISTS"];
			}

			if($arQuantityRights["SHOW_QUANTITY_COUNT"] && $totalCount > 0)
			{
				if($arQuantityOptions["USE_WORD_EXPRESSION"] == "Y")
				{
					if(strlen($totalAmount))
					{
						if($useStoreClick=="Y")
							$totalText = "<span class='store_view dotted'>".$totalAmount.'</span>';
						else
							$totalText = $totalAmount;
					}
				}
				else
				{
					if($useStoreClick=="Y")
						$totalText .= (strlen($totalText) ? ": ".$totalCount : "<span class='store_view dotted'>".$totalCount.'</span>');
					else
						$totalText .= (strlen($totalText) ? ": ".$totalCount."" : $totalCount);
				}
			}
			$totalHTMLs ='<div class="item-stock'.($bShowAjaxItems ? ' js-show-stores js-show-info-block' : '').' '.$dopClass.'" '.($arItemIDs["ID"] ? 'data-id="'.$arItemIDs["ID"].'"' : '').' '.($arItemIDs["STORE_QUANTITY"] ? "id=".$arItemIDs["STORE_QUANTITY"] : "").'>';
			$totalHTMLs .= '<span class="icon '.($totalCount > 0 ? 'stock' : ' order').'"></span><span class="value font_sxs">'.$totalText.'</span>';
			$totalHTMLs .='</div>';
		}

		$arOptions = array("OPTIONS" => $arQuantityOptions, "RIGHTS" => $arQuantityRights, "TEXT" => $totalText, "HTML" => $totalHTMLs);

		foreach(GetModuleEvents(ASPRO_MAX_MODULE_ID, 'OnAsproGetTotalQuantityBlock', true) as $arEvent) // event for manipulation store quantity block
			ExecuteModuleEventEx($arEvent, array($totalCount, &$arOptions));

		return $arOptions;
    }

    public static function OnAsproGetTotalQuantityBlock($totalCount, &$arOptions)
    {
        ob_start();
        ?>
        <div class="item-stock " data-id="bx_117848907_35044" id="bx_117848907_35044_store_quantity">
            <span class="icon stock"></span>
            333
        </div>
        <?
        $newText = ob_get_clean();
        
        // preg_match
        // $arOptions['TEXT'] = $newText.$arOptions['TEXT'].'====';
        // $arOptions['HTML'] = 
        // $newText.$arOptions['TEXT'].'====';
        // preg_match('/^(\s*<div[^>]*>)/', $arOptions['HTML'], $matches);
        // print_r([
        //     $matches,
            
        // ]);
        $dialClass = '';
        if ($totalCount > 0) {
            $dialClass = 2;
            if ($totalCount >= 401) {
                $dialClass = 9;
            }
            elseif ($totalCount >= 101) {
                $dialClass = 8;
            }
            elseif ($totalCount >= 51) {
                $dialClass = 6;
            }
            elseif ($totalCount >= 11) {
                $dialClass = 4;
            }
            $dialClass = "stock-dial_size-{$dialClass}";
        }
        $dial = '<span class="stock-dial '.$dialClass.'">'.str_repeat('<i></i>', 10).'</span>';
        $arOptions['HTML'] = preg_replace('/^(\s*<div[^>]*>)/', '$1'.$dial, $arOptions['HTML']);
    }
}