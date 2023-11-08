<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div id="webform<?= $arParams['WEB_FORM_ID'] ?>" class="js-webform">
	<?
	$fieldsets = [];
	$fieldsets['NAME'] = 'Данные заказчика';
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
				<? if (isset($fieldsets[$fieldSid])): ?>
					<h3><?= $fieldsets[$fieldSid] ?></h3>
                <? endif; ?>
                <? if ($question['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
                    <?= $question["HTML_CODE"] ?>
                <? else: ?>
					<div class="input-wrap">
                    <?= $question["CAPTION"] ?>
                    <?if ($question["REQUIRED"] == "Y"): ?>
                        <?= $question["REQUIRED_SIGN"] ?>
                    <?endif;?>
                    
                    <?= strtr($question["HTML_CODE"], array(
                        'class=""' => "
                            class=\"input-form-control\" 
                            placeholder=\"{$question['CAPTION']}\"
                            title=\"{$question['CAPTION']}\"
                        "
                    )) ?>
                    <? if (!empty($arResult['arQuestions'][$fieldSid]['COMMENTS'])): ?>
                        <div class="input-hint"><?= $arResult['arQuestions'][$fieldSid]['COMMENTS'] ?></div>
                    <? endif; ?>
					</div>
                <? endif; ?>
            <? endforeach; ?>     

            <? if($arResult["isUseCaptcha"] == "Y"): ?>
                <?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
                 <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
            <? endif; ?>

            <input type="submit" class="" value="<?= $arResult['SUBMIT_BUTTON_TEXT'] ?>">
        </form>

    <? endif; ?>
    <? if ($arResult['isFormSuccess']): ?>
        <div class="webform-success">
            <?= $arResult['SUCCESS_STRING'] ?>
        </div>
    <? endif; ?>
</div>