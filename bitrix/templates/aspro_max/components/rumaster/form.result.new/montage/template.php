<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?php
$asset = Bitrix\Main\Page\Asset::getInstance();
\Bitrix\Main\UI\Extension::load("ui.vue");
// $asset->addJs($this->__folder.'/vue.min.js');
// $asset->addJs($this->__folder.'/vue.min.js');
$asset->addJs($this->__folder.'/app.js');
// $asset->addString('')

$formConfig = [
    'OBJECT_EXISTS_DESIGN_PROJECT' => [
        'default' => 55,
        'input-attrs' => 'v-model="OBJECT_EXISTS_DESIGN_PROJECT"',
    ],
    'OBJECT_DESIGN_PROJECT_FILE' => [
        'wrap-attrs' => 'v-show="OBJECT_EXISTS_DESIGN_PROJECT == 54"',
        // 'input-attrs' => 'v-model="OBJECT_DESIGN_PROJECT_FILE"',
        'skip' => true,
    ],
    'OBJECT_EXISTS_PHOTO' => [
        'default' => 151,
        'input-attrs' => 'v-model="OBJECT_EXISTS_PHOTO"',
    ],
    'OBJECT_PHOTO_FILE' => [
        'wrap-attrs' => 'v-show="OBJECT_EXISTS_PHOTO == 150"',
        // 'input-attrs' => 'v-model="OBJECT_PHOTO_FILE"',
        'skip' => true,
    ],
    'OBJECT_EXISTS_VIDEO' => [
        'default' => 162,
        'input-attrs' => 'v-model="OBJECT_EXISTS_VIDEO"',
    ],
    'OBJECT_VIDEO_FILE' => [
        'wrap-attrs' => 'v-show="OBJECT_EXISTS_VIDEO == 161"',
        // 'input-attrs' => 'v-model="OBJECT_VIDEO_FILE"',
        'skip' => true,
    ],
    'OBJECT_CLIENT_WILL_BE_PRESENT' => [
        'default' => 57,
        'input-attrs' => 'v-model="OBJECT_CLIENT_WILL_BE_PRESENT"',
    ],
    'OBJECT_INSTEAD_CLIENT_WILL_BE_PRESENT' => [
        'wrap-attrs' => 'v-show="OBJECT_CLIENT_WILL_BE_PRESENT == 58"',
        'input-attrs' => 'v-model="OBJECT_INSTEAD_CLIENT_WILL_BE_PRESENT"',
    ],
    'OBJECT_AREA' => [
        'default' => '50',
        'input-attrs' => 'v-model="OBJECT_AREA"',
    ],
    'OBJECT_OTHER_WORK' => [
        'default' => '155',
        'input-attrs' => 'v-model="OBJECT_OTHER_WORK"',
    ],
    'ADDRESS_ZONE' => [
        'default' => '68',
        'input-attrs' => 'v-model="ADDRESS_ZONE"',
    ],
    'ADDRESS_DISTANCE_MKAD' => [
        'wrap-attrs' => 'v-show="ADDRESS_ZONE == 72"',
        'input-attrs' => 'v-model="ADDRESS_DISTANCE_MKAD"',
    ],
    'SERVICE_INSTALLATION_WORK_AFTER_18' => [
        'default' => 76,
        'input-attrs' => 'v-model="SERVICE_INSTALLATION_WORK_AFTER_18"',
    ],
    'SERVICE_INSTALLATION_HEIGHT__OVER_3M' => [
        'default' => 78,
        'input-attrs' => 'v-model="SERVICE_INSTALLATION_HEIGHT__OVER_3M"',
    ],
    'PRODUCTS' => [
        'computed' => true,
        'wrap-attrs' => 'v-show="false"',
        'input-attrs' => 'v-model="PRODUCTS"',
    ],
    'ADDRSSS_SPECIALIST_VISIT_PRICE' => [
        'computed' => true,
        'input-attrs' => 'v-model="ADDRSSS_SPECIALIST_VISIT_PRICE"',
    ],
    'ESTIMATED_COST_MONTAGE' => [
        'computed' => true,
        'input-attrs' => 'v-model="ESTIMATED_COST_MONTAGE"',
    ],
    'ESTIMATED_COST_SERVICES' => [
        'computed' => true,
        'input-attrs' => 'v-model="ESTIMATED_COST_SERVICES"',
    ],
];
$formValues = [];
foreach($formConfig as $fieldKey => $field) {
    if (!empty($field['computed'])) continue;
    if (!empty($field['skip'])) continue;
    $formValues[$fieldKey] = !empty($field['default']) ? $field['default'] : '';
}
?>
<script>
var montageFormConfig = <?= json_encode([
    'fields' => $formValues,

    'visitPrice' => 2000,
    'visitRangePrice' => 50,

    'sectionsDefaultRatio' => 1,
    // id категорий "ПУ изделия" (категории обязательрно в кавычках)
    'sectionsPuProducts' => ['33'],
    'sectionsPuProductsRatio' => 0.7,
    // id категорий "Изделия из цветнины" и "Артпрофиль/дюропрофиль" (категории обязательрно в кавычках)
    'sectionsMontainable' => ['137'],
    'sectionsMontainableRatio' => 1,
    // id категорий ценой монтажа 0 (категории обязательрно в кавычках)
    'sectionsNoneProducts' => [],
    'sectionsNoneProductsRatio' => 0,

    'after18HourId' => 75,
    'after18HourRatio' => 0.5,

    'after3HeightId' => 77,
    'after3HeightRatio' => 0.1,
    'after3HeightMinPrice' => 1000,

    'costMinPrices' => [
        '50' => 12000, // Если площадь < 50 кв/м
        '51' => 24000, // Если площадь 50-100 кв/м
        '52' => 36000, // Если площадь > 1000 кв/м
    ],

    'basketItems' => $arParams['~BASKET'],

    'watchSelect' => [
        'ADDRESS_ZONE' => 'montage_ADDRESS_ZONE',
    ],
]) ?>;
</script>
<div id="webform<?= $arParams['WEB_FORM_ID'] ?>" class="js-webform montage-form">
	<?
	$fieldsets = [];
	$fieldsets['SURNAME'] = 'Данные заказчика';
	$fieldsets['PASSPORT_SERIES'] = 'Паспортные данные (для дальнейшего заключения договора)';
	$fieldsets['OBJECT'] = 'Информация об объекте';
	$fieldsets['ADDRESS_CITY'] = 'Адрес объекта';
	$fieldsets['PRODUCTS'] = 'Услуги';
	?>
    <? if (!$arResult['isFormCurrent'] || $arResult['isFormErrors']): ?>
        <form name="<?= $arResult["arForm"]["SID"] ?>" action="<?= POST_FORM_ACTION_URI ?>" 
                method="POST" enctype="multipart/form-data" >
            <?= bitrix_sessid_post() ?>
            <input type="hidden" name="WEB_FORM_ID" value="<?= $arParams['WEB_FORM_ID'] ?>" />
            <input type="hidden" name="web_form_submit" value="Y">
            <input type="hidden" name="ajax" value="Y">


            <? if ($arResult["isFormErrors"]): ?>
                <div class="webform-error">
                    <?= $arResult["FORM_ERRORS_TEXT"] ?>
                </div>
            <? endif; ?>

            <?
            /***********************************************************************************
                                    form questions
            ***********************************************************************************/
            ?>
            <? foreach ($arResult["QUESTIONS"] as $fieldSid => $question): ?>
                <?php
                $isRequired = $question["REQUIRED"] == "Y";
                $required = $isRequired ? 'required' : '';
                $fieldConfig = !empty($formConfig[$fieldSid]) ? $formConfig[$fieldSid] : false;
                $inputAttrs = !empty($fieldConfig['input-attrs']) ? $fieldConfig['input-attrs'] : '';
                $wrapAttrs = !empty($fieldConfig['wrap-attrs']) ? $fieldConfig['wrap-attrs'] : '';
                $readonly = !empty($fieldConfig['computed']) ? 'readonly' : '';
                ?>
				<? if (isset($fieldsets[$fieldSid])): ?>
					<h3><?= $fieldsets[$fieldSid] ?></h3>
                <? endif; ?>
                <? if ($fieldSid == 'PRODUCTS'): ?>
                    <div class="form-control form-group montage_poisk">
                        <label for="montage_search-product" class="input-label">
                            Введите артикул или название товара
                        </label>
                        
                        <input type="text"
                            title="Поиск по артикулу товара из каталога"
                            placeholder="Поиск по артикулу товара из каталога"
                            id="montage_search-product"
                            value=""
                            class="input-form-control"
                            v-model.lasy.trim="searchProduct">
                        <div>
                            <button type="button" class="montage-btn montage-btn__show" v-show="!showProducts" @click.prevent="showProducts = true">Показать товары</button>
                            <button type="button" class="montage-btn montage-btn__hide"  v-show="showProducts" @click.prevent="showProducts = false">Скрыть товары</button>
                        </div>
                        <div class="montage-products" v-show="showProducts">
                            <div v-if="!!searchProduct">
                                <table class="montage-product">
                                    <tr>
										<th style="text-align:left">Название</th>
                                        <th style="text-align:center">Артикул</th>
                                        <th style="text-align:center">Размеры</th>
                                        <th style="text-align:right">Цена</th>
                                        <th></th>
                                    </tr>
                                    <tr v-for="product in products">
                                        <td style="text-align:left">{{product.name}}</td>
                                        <td style="text-align:center">{{product.article}}</td>
                                        <td style="text-align:center">{{product.size}}</td>
                                        <td style="text-align:right">{{product.price.raw}}&nbsp;руб.</td>
                                        <td><button type="button" class="montage-btn montage-btn__select" @click.prevent="selectProduct(product)">+</button></td>
                                    </tr>
                                </table>
                            </div>
                            <div v-if="!!searchProduct && products.length == 0">
                                По вашему запросу ничего не найдено
                            </div>
                            <div v-if="!searchProduct">
                                Введите артикул или название товара для поиска
                            </div>
                            <!-- <div v-for="product in products">
                            </div> -->
                        </div>
                        <div>
                            <button type="button" class="montage-btn montage-btn__hide" v-show="showProducts" @click.prevent="showProducts = false">Скрыть товары</button>
                        </div>
                        <div class="montage-products-selected" v-show="productSelected.length">
                            <h4>Продукция на монтаж</h4>
                            <table>
                                <tr>
                                    <th style="text-align:left">Название</th>
                                    <th style="text-align:right">Цена</th>
                                    <th>Кол-во</th>
                                    <th style="text-align:right">Стоимость</th>
                                    <th style="text-align:right">Стоимость монтажа</th>
                                    <th></th>
                                </tr>
                                <tr v-for="product in productSelected">
                                    <td style="text-align:left">{{product.name}}</td>
                                    <td style="text-align:right">{{product.price.raw}}&nbsp;руб.</td>
                                    <td><input type="text" v-model="product.quantity"></td>
                                    <td style="text-align:right">{{getProductSum(product)}}&nbsp;руб.</td>
									<td style="text-align:right;font-weight:bold">{{getProductMontage(product)}}&nbsp;руб.</td>
                                    <td><button type="button" class="montage-btn montage-btn__unselect" @click.prevent="unselectProduct(product)">X</button></td>
                                </tr>
                            </table>
                        </div>
					</div>
                <? endif; ?>
                <? if ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
                    <?
                    $inputReplace = [];
                    $inputReplace['<br />'] = '';
                    ?>
                    <?= strtr($question["HTML_CODE"], $inputReplace) ?>
                <? elseif ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'radio'): ?>
                    <!-- <?= $fieldSid ?> -->
                    <div class="form-control form-group" <?= $wrapAttrs ?>>
                        <label for="montage_<?= $fieldSid ?>" class="input-label">
                            <?= $question["CAPTION"] ?>
                            <?if ($isRequired): ?>
                                *
                            <?endif;?>
                        </label>
                        <?php
                        $radioReplace = [
                            'class=""' => "
                                class=\"input-form-control\" 
                                title=\"{$question['CAPTION']}\"
                                data-id=\"{$fieldSid}\"
                                {$readonly}
                                {$inputAttrs}
                            ",
                            '<br />' => '',
                        ];
                        if (!empty($formConfig[$fieldSid]['default'])) {
                            $default = $formConfig[$fieldSid]['default'];
                            $radioReplace["value=\"{$default}\""] = "value=\"{$default}\" checked";
                        }
                        $question["HTML_CODE"] = preg_replace('#</label>\s*<label for="\d+">#', ' ', $question["HTML_CODE"]);
                        ?>
                        <?= strtr($question["HTML_CODE"], $radioReplace) ?>
                        <? if (!empty($arResult['arQuestions'][$fieldSid]['COMMENTS'])): ?>
                            <div class="input-hint"><?= $arResult['arQuestions'][$fieldSid]['COMMENTS'] ?></div>
                        <? endif; ?>
                    </div>
                <? elseif ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'file'): ?>
                    <div class="form-control form-group" <?= $wrapAttrs ?>>
                        <label class="dropzone-area <? if (count($question['STRUCTURE']) == 1):?>dropzone-area_small<? endif; ?>" for="montage_<?= $fieldSid ?>">
                            <label class="input-label">
                                <?= $question["CAPTION"] ?>
                                <?if ($isRequired): ?>
                                    <?=$arResult["REQUIRED_SIGN"];?>
                                <?endif;?>
                            </label>
                            <?php
                            $extClass = 'input-form-control_file';
                            if (count($question['STRUCTURE']) > 1) {
                                $extClass .= ' input-form-control_dropzone-file';
                            }
                            $inputReplace = [
                                'class=""' => "
                                    class=\"input-form-control {$extClass}\" 
                                    title=\"{$question['CAPTION']}\"
                                    id=\"montage_{$fieldSid}_\"
                                    data-id=\"{$fieldSid}\"
                                    {$required}
                                    {$readonly}
                                    {$inputAttrs}
                                ",
                            ];
                            if ($fieldSid == 'EMAIL') {
                                $inputReplace['type="text"'] = 'type="email"';
                            }
                            if ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'file') {
                                $inputReplace['<br />'] = '';
                            }
                            ?>
                            <? if (count($question['STRUCTURE']) > 1):?>
                                <? foreach ($question['STRUCTURE'] as $struct): ?>
                                    <input type="hidden" name="montage_<?= $fieldSid ?>_file_map[]" value="form_file_<?= $struct['ID'] ?>">
                                <? endforeach; ?>
                            <? endif; ?>
                            <? if (!empty($arResult['arQuestions'][$fieldSid]['COMMENTS'])): ?>
                                <div class="input-hint"><?= $arResult['arQuestions'][$fieldSid]['COMMENTS'] ?></div>
                            <? endif; ?>
                            <?= strtr($question["HTML_CODE"], $inputReplace) ?>
                            <? if (count($question['STRUCTURE']) > 1):?>
                                <input type="file" class="dropzone-multiple-file" multiple name="montage_<?= $fieldSid ?>[]" id="montage_<?= $fieldSid ?>" style="display:none">
                            <? endif; ?>
					    </label>
					</div>
                <? else: ?>
                    <!-- <?= $fieldSid ?> -->
					<div class="form-control form-group animated-labels" <?= $wrapAttrs ?>>
                        <label for="montage_<?= $fieldSid ?>" class="input-label">
                            <?= $question["CAPTION"] ?>
                            <? if ($fieldSid == 'ADDRESS_ZONE'): ?>
                                , согласно
                                <strong>
                                    <a data-fancybox="images" href="/upload/medialibrary/e0f/orpcxnxg%20osrvvxxqdvtjrdxz_Decomaster.jpg" target="_blank" style="color:#0074ce">схеме</a>
                                </strong>
                            <? endif; ?>
                            <?if ($isRequired): ?>
                                <?=$arResult["REQUIRED_SIGN"];?>
                            <?endif;?>
                        </label>
                        <?php
                        $extClass = 'inputtext';
                        $inputReplace = [
                            'class=""' => "
                                class=\"input-form-control {$extClass}\" 
                                title=\"{$question['CAPTION']}\"
                                id=\"montage_{$fieldSid}\"
                                data-id=\"{$fieldSid}\"
                                {$required}
                                {$readonly}
                                {$inputAttrs}
                            ",
                        ];
                        if ($fieldSid == 'EMAIL') {
                            $inputReplace['type="text"'] = 'type="email"';
                        }
                        if ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'file') {
                            $inputReplace['<br />'] = '';
                        }
                        if ($question['STRUCTURE'][0]['FIELD_TYPE'] === 'dropdown') {
                            ?><template><?
                        }
                        ?>
                        <?= strtr($question["HTML_CODE"], $inputReplace) ?>
                        <? if (!empty($arResult['arQuestions'][$fieldSid]['COMMENTS'])): ?>
                            <div class="input-hint"><?= $arResult['arQuestions'][$fieldSid]['COMMENTS'] ?></div>
                        <? endif; ?>
                        <?
                        if ($question['STRUCTURE'][0]['FIELD_TYPE'] === 'dropdown') {
                            ?></template><?
                        }
                        ?>
					</div>
                <? endif; ?>
            <? endforeach; ?>     

            <? if($arResult['isUseCaptcha']): ?>
                <div class="input-wrap input-wrap_captcha">
                    <label class="input-label">
                        <?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
                    </label>
                    <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
                </div>
                <div class="input-wrap input-wrap_captcha">
                    <label class="input-label" for="web-form-catcha">
                        <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?>
                        <?=$arResult["REQUIRED_SIGN"];?>
                    </label>
                    <input id="web-form-catcha" type="text" name="captcha_word" size="30" maxlength="50" value="<?= $arResult['CAPTCHACode_raw'] ?>" class="input-form-control" required />
                </div>
            <? endif; ?>
            <br>
            <!-- <label style="display:none"><input type="checkbox" name="agree_doc" value="Y" required> Согласен с условиями договора</label><br> -->
            <a href="?preview" @click.prevent="openPreview" class="linkdog">Договор</a><br>
<br><br>
            <input type="submit" class="btn btn-default btn-lg has-ripple" style="font-size: medium;" value="<?= $arResult['SUBMIT_BUTTON_TEXT'] ?>">
<? if (empty($arParams['DEFAULT_ANSWERS']['SOURCE_LINK'])): ?>
<br><br>
<p class="text font_xs muted777">Нажимая на кнопку «Отправить заявку», Вы даете согласие на обработку своих персональных данных и принимаете <a href="/user-agreement.php" target="_blank">Пользовательское соглашение</a>. Вся информация будет надежно хранится в нашей базе данных в шифрованном виде.</p>
<? endif; ?>
        </form>

    <? endif; ?>
    <? if ($arResult['isFormSuccess']): ?>
        <div class="webform-success">
            <?= $arResult['SUCCESS_STRING'] ?>
        </div>
    <? endif; ?>
</div>