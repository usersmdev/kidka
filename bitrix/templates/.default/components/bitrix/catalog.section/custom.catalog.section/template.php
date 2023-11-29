<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |    Attention!
 * |    The following comments are for system use
 * |    and are required for the component to work correctly in ajax mode:
 * |    <!-- items-container -->
 * |    <!-- pagination-container -->
 * |    <!-- component-end -->
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

if (!empty($arResult['NAV_RESULT'])) {
    $navParams = array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
} else {
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
    $showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'USE_PAGINATION_CONTAINER' => $showTopPager || $showBottomPager,
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$arParams['~MESS_BTN_BUY'] = ($arParams['~MESS_BTN_BUY'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = ($arParams['~MESS_BTN_DETAIL'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = ($arParams['~MESS_BTN_COMPARE'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = ($arParams['~MESS_BTN_SUBSCRIBE'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = ($arParams['~MESS_BTN_ADD_TO_BASKET'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = ($arParams['~MESS_NOT_AVAILABLE'] ?? '') ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_NOT_AVAILABLE_SERVICE'] = ($arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '') ?: Loc::getMessage('CP_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE_SERVICE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = ($arParams['~MESS_SHOW_MAX_QUANTITY'] ?? '') ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = ($arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?? '') ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = ($arParams['MESS_RELATIVE_QUANTITY_MANY'] ?? '') ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = ($arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?? '') ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = ($arParams['MESS_RELATIVE_QUANTITY_FEW'] ?? '') ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum'];

if ($showTopPager) {
    ?>
    <div data-pagination-num="<?= $navParams['NavNum'] ?>">
        <!-- pagination-container -->
        <?= $arResult['NAV_STRING'] ?>
        <!-- pagination-container -->
    </div>
    <?
}
?>

<?php
if (!isset($arParams['HIDE_SECTION_DESCRIPTION']) || $arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y') {
    ?>
    <div class="bx-section-desc bx-<?= $arParams['TEMPLATE_THEME'] ?>">
        <p class="bx-section-desc-post"><?= $arResult['DESCRIPTION'] ?? '' ?></p>
    </div>
    <?
}


?>

<div class="catalog-section bx-<?= $arParams['TEMPLATE_THEME'] ?>" data-entity="<?= $containerName ?>">
    <?
    if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS'])) {
    $generalParams = [
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
        'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
        'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
        'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
        'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
        'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
        'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
        'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
        'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
        'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
        'LABEL_POSITION_CLASS' => $labelPositionClass,
        'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
        'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
        'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
        '~BASKET_URL' => $arParams['~BASKET_URL'],
        '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
        '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
        '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        '~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
        'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
        'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
        'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
        'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
    ];

    $areaIds = [];
    $itemParameters = [];

    foreach ($arResult['ITEMS'] as $item) {
        $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
        $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
        $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
        $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);

        $itemParameters[$item['ID']] = [
            'SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']],
            'MESS_NOT_AVAILABLE' => ($arResult['MODULES']['catalog'] && $item['PRODUCT']['TYPE'] === ProductTable::TYPE_SERVICE
                ? $arParams['~MESS_NOT_AVAILABLE_SERVICE']
                : $arParams['~MESS_NOT_AVAILABLE']
            ),
        ];
    }
    ?>
    <!-- items-container -->
    <div class="catalog-row">
    <?
    $Iblock = 82;
    foreach ($arResult['ITEMS'] as $arItem):


    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>

    <div class="news-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
        <?
        foreach ($arItem['PROPERTIES']['MAP']['VALUE'] as $map):?>
            <input type="hidden" class="map_point" value="<?= $map; ?>">
        <?
        endforeach; ?>
        <?
        foreach ($arItem['PROPERTIES']['ADDRESS']['VALUE'] as $map):?>
            <input type="hidden" class="address" value="<?= $map; ?>">
        <?
        endforeach; ?>
    <div class="row">
        <div class="col-md-3 col-xs-12">
            <div class="gallery">
                <a href="">
                    <img src="<? echo CFile::GetPath($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'][0]); ?>"
                         title="<?= $arItem['NAME']; ?>"
                         alt="<?= $arItem['NAME']; ?>">
                </a>
                <div class="img_items">
                    <?
                    foreach ($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $image):
                        if ($key != 0):?>

                            <a href="">
                                <img src="<? echo CFile::GetPath($image); ?>" title="<?= $arItem['NAME']; ?>"
                                     alt="<?= $arItem['NAME']; ?>">
                            </a>
                        <?
                        endif;
                        if ($key == 6):
                            break;
                        endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="title"><?= $arItem['NAME']; ?></div>
            <div class="address">
                <div><?= $arItem['PROPERTIES']['ADDRESS']['VALUE']; ?></div>
            </div>
            <div class="age">
                <? if ($arItem['PROPERTIES']['CHILD_AGE']['VALUE']):?>
                    <div><? echo min($arItem['PROPERTIES']['CHILD_AGE']['VALUE']) . ' - ' . max($arItem['PROPERTIES']['CHILD_AGE']['VALUE']) . ' лет'; ?></div>
                <?endif; ?>
            </div>
            <div class="reviews">
                <?
                $APPLICATION->IncludeComponent("bitrix:iblock.vote", "stars", array(
                        "IBLOCK_TYPE" => "",
                        "IBLOCK_ID" => $Iblock, //ID инфоболка
                        "ELEMENT_ID" => $arItem['ID'], //ID товара
                        "ELEMENT_CODE" => $arItem['CODE'], //код товара
                        "MAX_VOTE" => "5",
                        "VOTE_NAMES" => array("0", "1", "2", "3", "4"),
                        "SET_STATUS_404" => "N",
                        "MESSAGE_404" => "",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600"
                    )
                );
                ?></div>
            <div class="fast_answer"><a href="#" data-toggle="modal" data-target="#fast_answer">Быстрый ответ</a></div>
            <? if ($arItem['PROPERTIES']['SPEED_TRIP']['VALUE']): ?>
                <div class="speed_trip">Горящая путёвка</div>
            <? endif; ?>
            <div class="introtext"><p><?= $arItem['PREVIEW_TEXT'] ?></p></div>

            <? if ($arItem['PROPERTIES']['SEASON']['VALUE']): ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="prop">Сезон</div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="prop_desc"><? echo implode(', ', $arItem['PROPERTIES']['SEASON']['VALUE']) ?></div>
                    </div>
                </div>
            <? endif; ?>
            <? if ($arItem['PROPERTIES']['CATEGORIES']['VALUE']): ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="prop">Категории</div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="prop_desc"><? echo implode(', ', $arItem['PROPERTIES']['CATEGORIES']['VALUE']); ?></div>
                    </div>
                </div>
            <? endif; ?>
            <? if ($arItem['PROPERTIES']['ADVANTAGES']['VALUE']): ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="prop">Преимущества</div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="prop_desc"><? echo implode(', ', $arItem['PROPERTIES']['ADVANTAGES']['VALUE']); ?></div>
                    </div>
                </div>
            <? endif; ?>
            <? if ($arItem['PROPERTIES']['TRANSFER']['VALUE']): ?>
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="prop">Трансфер</div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="prop_desc"><?= $arItem['PROPERTIES']['TRANSFER']['VALUE'] ?></div>
                </div>
            </div>
        </div>

        <?endif;
        ?>


        <?
        $res = CCatalogSKU::getOffersList(
            $productID = array($arItem['ID']),
            $Iblock,
            $skuFilter = array('ACTIVE' => 'Y'),
            $fields = array('ID', 'NAME', 'CODE'),
            $propertyFilter = array("CODE" => ["DAYS", "SALE", "SALELAGER", "COMPENSATION", "CERTIFICATE"])
        );
        if (is_array($res) && sizeof($res)): ?>
            <?

            //var_dump($arItem['ID']);
            //var_dump($res[$arItem['ID']][58231]); //ДЛЯ AJAX

            $first_offer['PROPERTIES']['SALE']['VALUE'] = 0;
            $first_offer['PROPERTIES']['SALELAGER']['VALUE'] = 0;
            $first_offer = current($res[$arItem['ID']]);
            //var_dump($first_offer);
            ?>
            <div class="col-md-3 col-xs-12" id="productitem">
                <div class="blockoffer">

                    <div class="price_ajax">
                        <? if ($first_offer['PROPERTIES']['COMPENSATION']['VALUE']): ?>
                            <div class="goc">Гос. компенсация</div>
                        <?endif; ?>
                        <? if ($first_offer['PROPERTIES']['CERTIFICATE']['VALUE']): ?>
                            <div class="certificate">Сертификат Москвы</div>
                        <?endif; ?>
                        <div class="thwer"><a href="#" data-toggle="modal" data-target="#cheaper">Нашли дешевле? Снизим
                                цену</a></div>
                        <?
                        //var_dump($arResult['ITEMS'][0]['NAME']);


                        $arProduct = GetCatalogProduct($first_offer['ID']);
                        $arPrice = GetCatalogProductPriceList($first_offer['ID'], 'SORT', 'ASC');

                        for ($i = 0; $i < count($arPrice); $i++) {
                            if ($arPrice[$i]["CAN_ACCESS"] == "Y") {
                                if ($arPrice[$i]["CAN_BUY"] == "Y" && (IntVal($arProduct["QUANTITY"]) > 0 || $arProduct["QUANTITY_TRACE"] != "Y"))
                                    $bCanBuy = True;
                                $currency = $arPrice[$i]["CURRENCY"];
                                if ($currency == 'RUB'):
                                    $currency = '&#8381';
                                endif;
                                $price = $arPrice[$i]["PRICE"];
                                $price_view = intval($price);
                                $price_view = number_format($price_view, 0, '', ' ');
                                //$price_whith_cur = FormatCurrency($arPrice[$i]["PRICE"], $currency) . "<br>";
                                $price_whith_cur = $price_view . ' ' . $currency;
                            }
                        }

                        if ($price && $first_offer['PROPERTIES']['SALE']['VALUE'] || $first_offer['PROPERTIES']['SALELAGER']['VALUE']):?>
                            <? $sale_s = $price - ((int)$first_offer['PROPERTIES']['SALE']['VALUE'] + (int)$first_offer['PROPERTIES']['SALELAGER']['VALUE']); ?>
                            <div class="row-flex">
                                <div>
                                    <div class="sale_s"><?= number_format($sale_s, 0, '', ' ') . ' ' . $currency ?></div>
                                </div>
                                <div>
                                    <div class="price_s"><strike><?= $price_whith_cur ?></strike></div>
                                </div>
                            </div>
                            <? if ($first_offer['PROPERTIES']['SALE']['VALUE'] || $first_offer['PROPERTIES']['SALELAGER']['VALUE']):
                                $sale_percent = round((((int)$first_offer['PROPERTIES']['SALE']['VALUE'] + (int)$first_offer['PROPERTIES']['SALELAGER']['VALUE']) * 100 / $price));
                            endif; ?>
                            <div class="row-flex">
                                <div>
                                    <div class="sale_p"><? if ($first_offer['PROPERTIES']['DAYS']['VALUE']):?><? $slsz = (int)$sale_s / (int)$first_offer['PROPERTIES']['DAYS']['VALUE'];
                                            echo number_format($slsz, 0, '', ' ') . ' ' . $currency . ' /день' ?><?endif; ?></div>
                                </div>
                                <div>
                                    <div class="sale_p">Скидка - <?= $sale_percent ?>%</div>
                                </div>
                            </div>
                        <? else:?>
                            <div class="row-flex">
                                <div>
                                    <div class="sale_p">
                                        <? if ($first_offer['PROPERTIES']['DAYS']['VALUE']):?>
                                            <? $pslsz = $price / (int)$first_offer['PROPERTIES']['DAYS']['VALUE'];
                                            echo number_format($pslsz, 0, '', ' ') . ' ' . $currency . ' /день' ?>
                                        <? endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="price_s"><?= $price_whith_cur ?></div>
                                </div>
                            </div>

                        <? endif;
                        ?>
                        <? if ($first_offer['PROPERTIES']['DAYS']['VALUE']): ?>
                            <div class="days"><?= $first_offer['PROPERTIES']['DAYS']['VALUE']; ?> дней</div>
                        <?endif; ?>
                        <? if ($first_offer['PROPERTIES']['SALE']['VALUE']): ?>
                            <div class="sale_lager row-flex">
                                <span class="text_l">Скидка от лагеря</span>
                                <span class="price_l">...........<?= number_format($first_offer['PROPERTIES']['SALE']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span>
                            </div>
                        <?endif; ?>
                        <? if ($first_offer['PROPERTIES']['SALELAGER']['VALUE']): ?>
                            <div class="sale_site row-flex"><span class="text_l">Скидка от Kidka.ru</span><span
                                        class="price_l">..........<?= number_format($first_offer['PROPERTIES']['SALELAGER']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span>
                            </div>
                        <?endif; ?>
                    </div>
                </div>
                <? $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
                    'filter' => array('=PRODUCT_ID' => $first_offer['ID']),
                ));
                while ($arStoreProduct = $rsStoreProduct->fetch()) {
                    if (IntVal($arStoreProduct["AMOUNT"]) < 10):?>
                        <? echo "<div class='amount'>Осталось мест: " . $arStoreProduct["AMOUNT"] . '</div>';
                    endif;
                } ?>
                <div class="pack"><? echo sizeof($res[$arItem['ID']]) . ' смены:'; ?></div>
                <select name="offerselect" id="offerselect">
                    <?
                    foreach ($res[$arItem['ID']] as $r):
                        ?>
                        <option value="<?= $r['ID'] ?>"><?= $r['NAME']; ?></option>
                    <?
                    endforeach;

                    ?>
                </select>
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="btn button about">Подробнее</a>

        <?
        endif;


        ?>

    </div>
    </div>
</div>


<?
endforeach;
?>
</div>
    <button id="view_map">Показать на карте</button>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Название модали</h4>
                </div>
                <div class="modal-body">
                    <div id="map" style="width: 600px; height: 400px"></div>
                </div>

            </div>
        </div>
    </div>

<?
//		foreach ($arResult['ITEM_ROWS'] as $rowData)
//		{
//			$rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);
//
?>
    <!--			<div class="row --><?php //=$rowData['CLASS']
    ?><!--" data-entity="items-row">-->
<!--				--><? //
//				switch ($rowData['VARIANT'])
//				{
//					case 2:
//
?>
<!--						<div class="col-xs-12 product-item-small-card">-->
<!--							<div class="row">-->
<!--								--><? //
//								foreach ($rowItems as $item)
//								{
//
?>
<!--									<div class="col-sm-4 product-item-big-card">-->
<!--										<div class="row">-->
<!--											<div class="col-md-12">-->
<!--												--><? //
//												$APPLICATION->IncludeComponent(
//													'bitrix:catalog.item',
//													'custom.catalog.item',
//													array(
//														'RESULT' => array(
//															'ITEM' => $item,
//															'AREA_ID' => $areaIds[$item['ID']],
//															'TYPE' => $rowData['TYPE'],
//															'BIG_LABEL' => 'N',
//															'BIG_DISCOUNT_PERCENT' => 'N',
//															'BIG_BUTTONS' => 'Y',
//															'SCALABLE' => 'N'
//														),
//														'PARAMS' => $generalParams + $itemParameters[$item['ID']],
//													),
//													$component,
//													array('HIDE_ICONS' => 'Y')
//												);
//
?>
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--									--><? //
//								}
//
?>
<!--							</div>-->
<!--						</div>-->
<!--						--><? //
//						break;
//
//				}
//
?>
<!--			</div>-->
<!--			--><? //
//		}
unset($rowItems);

unset($itemParameters);
unset($areaIds);

unset($generalParams);
?>
<!-- items-container -->
<?
} else {
    // load css for bigData/deferred load
    $APPLICATION->IncludeComponent(
        'bitrix:catalog.item',
        '',
        array(),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
}
?>
</button>
<?
if ($showLazyLoad) {
    ?>
    <div class="row bx-<?= $arParams['TEMPLATE_THEME'] ?>">
        <div class="btn btn-default btn-lg center-block" style="margin: 15px;"
             data-use="show-more-<?= $navParams['NavNum'] ?>">
            <?= $arParams['MESS_BTN_LAZY_LOAD'] ?>
        </div>
    </div>
    <?
}

if ($showBottomPager) {
    ?>
    <div data-pagination-num="<?= $navParams['NavNum'] ?>">
        <!-- pagination-container -->
        <?= $arResult['NAV_STRING'] ?>
        <!-- pagination-container -->
    </div>
    <?
}

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
<script>
    BX.message({
        BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
        BASKET_URL: '<?=$arParams['BASKET_URL']?>',
        ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
        TITLE_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR')?>',
        TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS')?>',
        TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
        BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR')?>',
        BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
        BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE')?>',
        BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
        COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK')?>',
        COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
        COMPARE_TITLE: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE')?>',
        PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX')?>',
        RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
        RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
        BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
        BTN_MESSAGE_LAZY_LOAD: '<?=CUtil::JSEscape($arParams['MESS_BTN_LAZY_LOAD'])?>',
        BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
    });
    var <?=$obName?> = new JCCatalogSectionComponent({
        siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
        componentPath: '<?=CUtil::JSEscape($componentPath)?>',
        navParams: <?=CUtil::PhpToJSObject($navParams)?>,
        deferredLoad: false,
        initiallyShowHeader: '<?=!empty($arResult['ITEM_ROWS'])?>',
        bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
        lazyLoad: !!'<?=$showLazyLoad?>',
        loadOnScroll: !!'<?=($arParams['LOAD_ON_SCROLL'] === 'Y')?>',
        template: '<?=CUtil::JSEscape($signedTemplate)?>',
        ajaxId: '<?=CUtil::JSEscape($arParams['AJAX_ID'] ?? '')?>',
        parameters: '<?=CUtil::JSEscape($signedParams)?>',
        container: '<?=$containerName?>'
    });
</script>
<!-- component-end -->
<!--<style>-->
<!--    .left_block{display: none;}-->
<!--</style>-->
