<?php
if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$productid = $_POST['productid'];
$res = CIBlockElement::GetByID($productid);
$arElem = $res->GetNextElement();
$arProps = $arElem->GetProperties();
global $USER;
if (is_array($arProps) && sizeof($arProps)): ?>
<?

//var_dump($arItem['ID']);
//var_dump($res[$arItem['ID']][58231]); //ДЛЯ AJAX
$first_offer = $arProps;
$first_offer['SALE']['VALUE'] = 0;
$first_offer['SALELAGER']['VALUE'] = 0;
$first_offer = $arProps;

?>

    <? echo '<div class="price_ajax">';?>
        <? if ($first_offer['COMPENSATION']['VALUE']): ?>
            <?echo'<div class="goc">Гос. компенсация</div>';?>
        <? endif; ?>
        <? if ($first_offer['CERTIFICATE']['VALUE']): ?>
            <?echo'<div class="certificate">Сертификат Москвы</div>'?>
        <? endif; ?>
    <?echo '<div class="thwer"><a href="#" data-toggle="modal" data-target="#cheaper">Нашли дешевле? Снизим цену</a>
        </div>';?>
        <?
        endif;
        $arProduct = GetCatalogProduct($productid);
        $arPrice = GetCatalogProductPriceList($productid, 'SORT', 'ASC');
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
        if(!$USER->IsAuthorized()):
            $sale_lager_auth = $first_offer['SALELAGER']['VALUE'];
            $first_offer['SALELAGER']['VALUE'] = 0;
        endif;
        if ($price && $first_offer['SALE']['VALUE'] || $first_offer['SALELAGER']['VALUE']):?>
            <? $sale_s = $price - ((int)$first_offer['SALE']['VALUE'] + (int)$first_offer['SALELAGER']['VALUE']); ?>
            <div class="row-flex">
                <div>
                    <div class="sale_s"><?= number_format($sale_s, 0, '', ' ') . ' ' . $currency ?></div>
                </div>
                <div>
                    <div class="price_s"><?= $price_whith_cur ?></div>
                </div>
            </div>
            <? if ($first_offer['SALE']['VALUE'] || $first_offer['SALELAGER']['VALUE']):
                $sale_percent = round((((int)$first_offer['SALE']['VALUE'] + (int)$first_offer['SALELAGER']['VALUE']) * 100 / $price));
            endif; ?>
            <div class="row-flex">
                <div>
                    <div class="sale_p">
                        <?if ($first_offer['DAYS']['VALUE']):?>
                        <? $slsz = (int)$sale_s / (int)$first_offer['DAYS']['VALUE'];
                        echo number_format($slsz, 0, '', ' ') . ' ' . $currency . ' /день' ?></div>
                    <?endif;?>
                </div>
                <div>
                    <div class="sale_pb">Скидка - <?= $sale_percent ?>%</div>
                </div>
            </div>
        <? else: ?>
            <div class="row-flex">
                <div>
                    <div class="sale_p">
                        <?if ($first_offer['DAYS']['VALUE']):?>
                        <? $pslsz = $price / (int)$first_offer['DAYS']['VALUE'];
                        echo number_format($pslsz, 0, '', ' ') . ' ' . $currency . ' /день' ?></div>
                    <?endif;?>
                </div>
                <div>
                    <div class="price_s"><?= $price_whith_cur ?></div>
                </div>
            </div>
        <? endif;
        ?>
        <? if ($first_offer['DAYS']['VALUE']): ?>
            <div class="days"><?= $first_offer['DAYS']['VALUE']; ?> дней</div>
        <? endif; ?>
        <? if ($first_offer['SALE']['VALUE']): ?>
            <div class="sale_lager row-flex">
                <span class="text_l">Скидка от лагеря</span><span class="point_border"></span>
                <span class="price_l"> - <?= number_format($first_offer['SALE']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span>
            </div>
        <? endif; ?>
        <?  if ($first_offer['SALELAGER']['VALUE'] == 0): ?>
        <?if ($sale_lager_auth):?>
            <div class="sale_lager row-flex"><div class="sale_site_auth"><a href="/registratsiya/">Зарегистрируйся</a> и получи скидку от <?=$_SERVER['HTTP_HOST']?></div></div>
        <?php endif;?>
        <?else: ?>
        <?if ($first_offer['SALELAGER']['VALUE']):?>
            <div class="sale_site row-flex"><span
                        class="text_l">Скидка от Kidka.ru</span><span class="point_border"></span>
                <span class="price_l"><span class="sale_lag">-<?= number_format($first_offer['SALELAGER']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span></span>
            </div>
        <?php endif;?>
        <?
        endif; ?>
        <input type="hidden" id="id_prodect_price" value="<?=$productid?>">
<!--        --><?// $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
//            'filter' => array('=PRODUCT_ID' => $first_offer['ID']),
//        ));
//        while ($arStoreProduct = $rsStoreProduct->fetch()) {
//            if (IntVal($arStoreProduct["AMOUNT"]) < 10):?>
<!--                --><?// echo "<div class='amount'>Осталось мест: " . $arStoreProduct["AMOUNT"] . '</div>';
//            endif;
//        } ?>
    </div>

<?php
echo $data;
?>
