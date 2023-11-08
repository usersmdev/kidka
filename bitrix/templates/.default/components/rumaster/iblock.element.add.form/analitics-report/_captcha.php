<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
    <tr>
        <td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
        <td>
            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
        </td>
    </tr>
    <tr>
        <td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:</td>
        <td><input type="text" name="captcha_word" maxlength="50" value=""></td>
    </tr>
<?endif?>