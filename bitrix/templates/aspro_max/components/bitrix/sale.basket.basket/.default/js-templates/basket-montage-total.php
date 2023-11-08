<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-montage-template" type="text/html">
    <table class="basket-items-list-montage-table" id="basket-item-montage-table">
        <tr class="basket-items-list-item-container">
            <td class="basket-items-list-item-descriptions">
                Итого:
            </td>
            <td class="basket-items-list-item-price basket-items-list-item-price-montage">
                <div class="basket-item-block-price">
                    <div class="basket-item-price-current">
                        <span class="basket-item-price-current-text" data-entity="basket-total-montage-price">
                            {{{MONTAGE_PRICE_FORMATED}}}
                        </span>
                    </div>
                </div>
                <br>
                <div class="btn-wrap">
                    <a href="/montageform/?{{{MONTAGE_OR_DESIGN_HTTP_QUERY}}}" target="_blank" class="btn btn-success btn-transparent-border-color has-ripple">Заказать монтаж</a>
                </div>
            </td>
            <td class="basket-items-list-item-price basket-items-list-item-price-design">
                <div class="basket-item-block-price">
                    <div class="basket-item-price-current">
                        <span class="basket-item-price-current-text" data-entity="basket-total-design-price">
                            {{{DESIGN_PRICE_FORMATED}}}
                        </span>
                    </div>
                </div>
                <br>
                <div class="btn-wrap">
                    <a href="/designform/?{{{MONTAGE_OR_DESIGN_HTTP_QUERY}}}" target="_blank" class="btn btn-transparent-border-color has-ripple">Заказать дизайн</a>
                </div>
            </td>
        </tr>
    </table>
    {{#MONTAGE_OR_DESIGN_DEFAULT_PRICE}}
    <div class="ts-row warning">
        <div class="ts-cell">
            <div class="title">Применяется минимальная стоимость заказа</div>
        </div>
    </div>
    {{/MONTAGE_OR_DESIGN_DEFAULT_PRICE}}
</script>