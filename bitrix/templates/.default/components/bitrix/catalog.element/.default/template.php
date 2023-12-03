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
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx', 'ui.fonts.opensans');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$haveOffers = !empty($arResult['OFFERS']);

$templateData = [
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => [
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    ],
];
if ($haveOffers) {
    $templateData['ITEM']['OFFERS_SELECTED'] = $arResult['OFFERS_SELECTED'];
    $templateData['ITEM']['JS_OFFERS'] = $arResult['JS_OFFERS'];
}
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DESCRIPTION_ID' => $mainId . '_description',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

if ($haveOffers) {
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '') {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
} else {
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);
$productType = $arResult['PRODUCT']['TYPE'];

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');

if ($arResult['MODULES']['catalog'] && $arResult['PRODUCT']['TYPE'] === ProductTable::TYPE_SERVICE) {
    $arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE_SERVICE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE');
    $arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE_SERVICE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE');
} else {
    $arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
    $arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
}

$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}
?>
    <div class="bx-catalog-element bx-<?= $arParams['TEMPLATE_THEME'] ?>" id="<?= $itemIds['ID'] ?>"
         itemscope itemtype="http://schema.org/Product">
        <div class="detail_page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9 col-sm-12 nopadding">
                        <div class="main_block">
                            <div class="top_title">
                                <div class="title">
                                    <?php
                                    if ($arParams['DISPLAY_NAME'] === 'Y') {
                                        ?>
                                        <h1 class="bx-title"><?= $name ?></h1>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?


                                global $APPLICATION;
                                if (!$USER->IsAuthorized()) {
                                    $arFavorites = unserialize($APPLICATION->get_cookie("favorites"));
                                    //print_r($arFavorites);
                                } else {
                                    $idUser = $USER->GetID();
                                    $rsUser = CUser::GetByID($idUser);
                                    $arUser = $rsUser->Fetch();
                                    $arFavorites = $arUser['UF_FAVORITES'];
                                }
                                is_countable($arFavorites);
                                foreach ($arFavorites as $k => $favoriteItem):?>
                                    <script>
                                        $(document).ready(function () {
                                            if ($('span.favor[data-item="<?=$favoriteItem?>"]')) {
                                                $('span.favor[data-item="<?=$favoriteItem?>"]').addClass('active_d');
                                            }
                                        });
                                    </script>
                                <? endforeach; ?>
                                <div class="favorite">
                                    <span class="favor" data-item="<?= $arResult['ID']; ?>">В избранное</span>
                                </div>
                            </div>
                            <div class="address">
                                <? foreach ($arResult['PROPERTY_1206'] as $address): ?>
                                    <div><?= $address; ?></div>
                                <? endforeach; ?>
                            </div>
                            <? if ($arResult['PROPERTY_1159']): ?>
                                <div class="map">
                                    <a href="javascript:void(0);" id="view_map">Показать на карте</a>
                                    <? foreach ($arResult['PROPERTY_1159'] as $mappoint): ?>
                                        <input type="hidden" class="mappoint" value="<?= $mappoint; ?>">
                                    <?endforeach; ?>
                                </div>
                            <?endif; ?>
                            <div class="vote">
                                <span class="rating" data-value="<?= round($arResult['PROPERTY_1198'], 2); ?>"
                                      style="pointer-events: none;"></span>
                                <span class="count_rating">(<?= round($arResult['PROPERTY_1198'], 2); ?>)</span>
                                <span class="count_reviews">Отзывы: (<?= round($arResult['PROPERTY_1225'], 2); ?>)</span>
                            </div>
                            <div class="advert">
                                <div class="fast_answer">
                                    <a href="#" data-toggle="modal" data-target="#fast_answer">Быстрый ответ</a>
                                </div>
                                <div class="fast_travel">
                                    Горящая путёвка
                                </div>
                                <div class="hit">
                                    Хит продаж
                                </div>
                            </div>
                            <div class="gallery">
                                <? $Image_count = count($arResult['PROPERTY_1160']);
                                $firstBlockImage = $Image_count - 13;
                                ?>
                                <? foreach ($arResult['PROPERTY_1160'] as $key => $image): ?>

                                    <? if ($key < 13): ?>
                                        <a href="<?= CFile::GetPath($image) ?>" class="gal_image cust" id="show">
                                            <img src="<?= $arResult['PICTURE'][$key]['SRC'] ?>"/>
                                            <span class="shadow_image"
                                                  style="display: none">+<?= $firstBlockImage ?></span>
                                        </a>
                                    <? elseif ($key == 13): ?>
                                        <div href="<?= CFile::GetPath($image) ?>" class="cust show_con">
                                            <img src="<?= $arResult['PICTURE'][$key]['SRC'] ?>"/>
                                            <span class="shadow_image"
                                                  style="display: none">+<?= $firstBlockImage ?></span>
                                        </div>
                                    <? else: ?>
                                        <a href="<?= CFile::GetPath($image) ?>" class="gal_image cust" id="hide">
                                            <img src="<?= $arResult['PICTURE'][$key]['SRC'] ?>"/>
                                            <span class="shadow_image"
                                                  style="display: none">+<?= $firstBlockImage ?></span>
                                        </a>
                                    <?endif; ?>
                                <?endforeach;
                                ?>
                            </div>

                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1203']): ?>
                                    <div class="property_naime">Возраст детей</div>
                                    <div class="property_value"><?= min($arResult['PROPERTY_1203']); ?>
                                        -<?= max($arResult['PROPERTY_1203']) ?> лет
                                    </div>
                                <?endif; ?>
                            </div>
                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1208']): ?>
                                    <div class="property_naime">Сезон</div>
                                    <div class="property_value">
                                        <? echo implode(', ', $arResult['PROPERTY_1208']); ?>
                                    </div>
                                <?endif; ?>
                            </div>
                            <? $res = CIBlockElement::GetByID($arResult['ID']);
                            if ($obRes = $res->GetNextElement()) {
                                $ar_res = $obRes->GetProperty("DIRECTION_SERVICE");
                            } ?>
                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1205']): ?>
                                    <div class="property_naime">Категории</div>
                                    <div class="property_value">
                                        <? foreach ($ar_res['VALUE'] as $key => $proper): ?>
                                            <a href="<?= $arResult['LIST_PAGE_URL'] . $ar_res['VALUE_XML_ID'][$key] . '/direction_service-is-' . $ar_res['VALUE_XML_ID'][$key] . '/show/' ?>"><? echo $ar_res['VALUE'][$key]; ?></a>
                                        <?endforeach; ?>
                                    </div>
                                <?endif; ?>
                            </div>
                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1211']): ?>
                                    <div class="property_naime">Трансфер</div>
                                    <div class="property_value"><?= $arResult['PROPERTY_1211'] ?></div>
                                <?endif; ?>
                            </div>
                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1208']): ?>
                                    <div class="property_naime">Инфраструктура</div>
                                    <div class="property_value"><?= $arResult['PROPERTY_1226'] ?></div>
                                <?endif; ?>
                            </div>
                            <div class="property_detail">
                                <? if ($arResult['PROPERTY_1227']): ?>
                                    <div class="property_naime">Дополнительная информация</div>
                                    <div class="property_value"><?= $arResult['PROPERTY_1227']['TEXT'] ?></div>
                                <?endif; ?>
                            </div>
                            <!-- Nav tabs -->
                            <div class="detail_tabs">
                                <ul class="nav nav-tabs">
                                    <? if ($arResult['PROPERTY_1228']): ?>
                                        <li class="active"><a href="#FIRST_TAB_NAME"
                                                              data-toggle="tab"><?= $arResult['PROPERTY_1228'] ?></a>
                                        </li>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1230']): ?>
                                        <li><a href="#SECOND_TAB"
                                               data-toggle="tab"><?= $arResult['PROPERTY_1230'] ?></a></li>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1232']): ?>
                                        <li><a href="#THIRD_TAB" data-toggle="tab"><?= $arResult['PROPERTY_1232'] ?></a>
                                        </li>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1234']): ?>
                                        <li><a href="#FOURTH_TAB"
                                               data-toggle="tab"><?= $arResult['PROPERTY_1234'] ?></a></li>
                                    <?endif; ?>
                                    <li><a href="#REVIEWS" data-toggle="tab">Отзывы</a></li>
                                    <li><a href="#BAY" data-toggle="tab">Стоимость</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <? if ($arResult['PROPERTY_1236']): ?>
                                        <div class="tab-pane active" id="FIRST_TAB_NAME">
                                            <div class="gallery">
                                                <? foreach ($arResult['PROPERTY_1236'] as $key => $image): ?>
                                                    <a href="<?= CFile::GetPath($image) ?>" class="gal_image">
                                                        <img src="<?= $arResult['PICTURE_1236'][$key]['SRC'] ?>"/>
                                                    </a>
                                                <?endforeach; ?>
                                            </div>
                                            <div class="description">
                                                <? $dwkwa_out = $arResult['PROPERTY_1229']['TEXT'];
                                                $dwkwa_out = str_replace("&lt;", "<", $dwkwa_out);
                                                $dwkwa_out = str_replace("&gt;", ">", $dwkwa_out);
                                                echo $dwkwa_out;
                                                ?>
                                            </div>
                                        </div>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1230']): ?>
                                        <div class="tab-pane" id="SECOND_TAB">
                                            <div class="gallery">
                                                <? foreach ($arResult['PROPERTY_1237'] as $key => $image): ?>
                                                    <a href="<?= CFile::GetPath($image) ?>" class="gal_image">
                                                        <img src="<?= $arResult['PICTURE_1237'][$key]['SRC'] ?>"/>
                                                    </a>
                                                <?endforeach; ?>
                                            </div>
                                            <div class="description">
                                                <? $dwkwa_out = $arResult['PROPERTY_1231']['TEXT'];
                                                $dwkwa_out = str_replace("&lt;", "<", $dwkwa_out);
                                                $dwkwa_out = str_replace("&gt;", ">", $dwkwa_out);
                                                echo $dwkwa_out;
                                                ?>
                                            </div>
                                        </div>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1232']): ?>
                                        <div class="tab-pane" id="THIRD_TAB">
                                            <div class="gallery">
                                                <? foreach ($arResult['PROPERTY_1238'] as $key => $image): ?>
                                                    <a href="<?= CFile::GetPath($image) ?>" class="gal_image">
                                                        <img src="<?= $arResult['PICTURE_1238'][$key]['SRC'] ?>"/>
                                                    </a>
                                                <?endforeach; ?>
                                            </div>
                                            <div class="description">
                                                <? $dwkwa_out = $arResult['PROPERTY_1233']['TEXT'];
                                                $dwkwa_out = str_replace("&lt;", "<", $dwkwa_out);
                                                $dwkwa_out = str_replace("&gt;", ">", $dwkwa_out);
                                                echo $dwkwa_out;
                                                ?>
                                            </div>
                                        </div>
                                    <?endif; ?>
                                    <? if ($arResult['PROPERTY_1234']): ?>
                                        <div class="tab-pane" id="FOURTH_TAB">
                                            <div class="description">
                                                <? $dwkwa_out = $arResult['PROPERTY_1235']['TEXT'];
                                                $dwkwa_out = str_replace("&lt;", "<", $dwkwa_out);
                                                $dwkwa_out = str_replace("&gt;", ">", $dwkwa_out);
                                                echo $dwkwa_out;
                                                ?>
                                            </div>
                                        </div>
                                    <?endif; ?>
                                    <div class="tab-pane" id="REVIEWS">
                                        <?
                                        $APPLICATION->IncludeComponent(
                                            "smdev:reviews",
                                            ".default",
                                            array(
                                                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                                "ELEMENT_ID" => $arResult['ID'],
                                                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                                "CACHE_TIME" => $arParams['CACHE_TIME']
                                            ),
                                            $component);
                                        ?>
                                    </div>
                                    <div class="tab-pane" id="BAY">...</div>
                                </div>
                            </div>
                            <a href="#" class="button btn">Запросить больше информации</a>
                        </div>


                        <? //var_dump($arResult); ?>
                    </div>
                    <div class="col-md-3 col-sm-12 nopadding">
                        <div class="right_block">

                            <?
                            $res = CCatalogSKU::getOffersList(
                                $productID = array($arResult['ID']),
                                $arParams['IBLOCK_ID'],
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
                            $first_offer = current($res[$arResult['ID']]);
                            //var_dump($first_offer);
                            ?>
                            <div class="" id="productitem">
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
<!--                                <div class="pack">--><?// echo sizeof($res[$arResult['ID']]) . ' смены:'; ?><!--</div>-->
                                <select name="offerselect" id="offerselect">
                                    <?
                                    foreach ($res[$arResult['ID']] as $r):
                                        ?>
                                        <option value="<?= $r['ID'] ?>"><?= $r['NAME']; ?></option>
                                    <?
                                    endforeach;

                                    ?>
                                </select>

                                <a href="" class="btn button about">Забронировать</a>

                                <?
                                endif;


                                ?>
                        </div>
                    </div>
                </div>
                <?
                //                $rsUser = CUser::GetByID(23);
                //                $arUser = $rsUser->Fetch();
                ?>
                <script>
                    // $('#fast_answer').find('input.inputtext').val(12312312);
                </script>

            </div>
        </div>
        <!--Small Card-->
        <
        <!--Top tabs-->


        <meta itemprop="name" content="<?= $name ?>"/>
        <meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>"/>
        <?php
        if ($haveOffers) {
            foreach ($arResult['JS_OFFERS'] as $offer) {
                $currentOffersList = array();

                if (!empty($offer['TREE']) && is_array($offer['TREE'])) {
                    foreach ($offer['TREE'] as $propName => $skuId) {
                        $propId = (int)mb_substr($propName, 5);

                        foreach ($skuProps as $prop) {
                            if ($prop['ID'] == $propId) {
                                foreach ($prop['VALUES'] as $propId => $propValue) {
                                    if ($propId == $skuId) {
                                        $currentOffersList[] = $propValue['NAME'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?= htmlspecialcharsbx(implode('/', $currentOffersList)) ?>"/>
				<meta itemprop="price" content="<?= $offerPrice['RATIO_PRICE'] ?>"/>
				<meta itemprop="priceCurrency" content="<?= $offerPrice['CURRENCY'] ?>"/>
				<link itemprop="availability"
                      href="http://schema.org/<?= ($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
			</span>
                <?php
            }

            unset($offerPrice, $currentOffersList);
        } else {
            ?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?= $price['RATIO_PRICE'] ?>"/>
			<meta itemprop="priceCurrency" content="<?= $price['CURRENCY'] ?>"/>
			<link itemprop="availability"
                  href="http://schema.org/<?= ($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
		</span>
            <?php
        }
        ?>
    </div>
<?php
if ($haveOffers) {
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS']) {
            if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {
                    $current = '<dt>' . $property['NAME'] . '</dt><dd>' . (
                        is_array($property['VALUE'])
                            ? implode(' / ', $property['VALUE'])
                            : $property['VALUE']
                        ) . '</dd>';
                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
                        $strMainProps .= $current;
                    }
                }

                unset($current);
            }
        }

        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {
            $strPriceRangesRatio = '(' . Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ) . ' ' . $measureName)
                ) . ')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
                if ($range['HASH'] !== 'ZERO-INF') {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
                            break;
                        }
                    }

                    if ($itemPrice) {
                        $strPriceRanges .= '<dt>' . Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
                            ) . ' ';

                        if (is_infinite($range['SORT_TO'])) {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        } else {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null,
            'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
            'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
        ),
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH'],
            'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
            'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
            'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
            'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps
    );
} else {
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {
        ?>
        <div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
            <?php
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {
                    ?>
                    <input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                           value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
                    <?php
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties) {
                ?>
                <table>
                    <?php
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {
                        ?>
                        <tr>
                            <td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
                            <td>
                                <?php
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                ) {
                                    foreach ($propInfo['VALUES'] as $valueId => $value) {
                                        ?>
                                        <label>
                                            <input type="radio"
                                                   name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                                                   value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
                                            <?= $value ?>
                                        </label>
                                        <br>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
                                        <?php
                                        foreach ($propInfo['VALUES'] as $valueId => $value) {
                                            ?>
                                            <option value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
                                                <?= $value ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
        <?php
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE']) {
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}

$jsParams["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"] =
    $arResult["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"];

?>
    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_DETAIL_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?php
unset($actualItem, $itemIds, $jsParams);
