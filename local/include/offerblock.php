<div class="blockoffer">
    <div class="price_ajax">
        <? if ($first_offer['PROPERTIES']['COMPENSATION']['VALUE']): ?>
            <div class="goc">Гос. компенсация</div>
        <? endif; ?>
        <? if ($first_offer['PROPERTIES']['CERTIFICATE']['VALUE']): ?>
            <div class="certificate">Сертификат Москвы</div>
        <? endif; ?>
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
                    <div class="sale_p"><? if ($first_offer['PROPERTIES']['DAYS']['VALUE']): ?><? $slsz = (int)$sale_s / (int)$first_offer['PROPERTIES']['DAYS']['VALUE'];
                            echo number_format($slsz, 0, '', ' ') . ' ' . $currency . ' /день' ?><? endif; ?></div>
                </div>
                <div>
                    <div class="sale_p">Скидка - <?= $sale_percent ?>%</div>
                </div>
            </div>
        <? else: ?>
            <div class="row-flex">
                <div>
                    <div class="sale_p">
                        <? if ($first_offer['PROPERTIES']['DAYS']['VALUE']): ?>
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
        <? endif; ?>
        <? if ($first_offer['PROPERTIES']['SALE']['VALUE']): ?>
            <div class="sale_lager row-flex">
                <span class="text_l">Скидка от лагеря</span>
                <span class="price_l">...........<?= number_format($first_offer['PROPERTIES']['SALE']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span>
            </div>
        <? endif; ?>
        <? if ($first_offer['PROPERTIES']['SALELAGER']['VALUE']): ?>
            <div class="sale_site row-flex"><span class="text_l">Скидка от Kidka.ru</span><span
                        class="price_l">..........<?= number_format($first_offer['PROPERTIES']['SALELAGER']['VALUE'], 0, '', ' ') . ' ' . $currency ?></span>
            </div>
        <? endif; ?>
    </div>
</div>