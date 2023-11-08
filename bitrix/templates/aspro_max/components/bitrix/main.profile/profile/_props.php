<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
    <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
        <? if (($FIELD_NAME == 'UF_DIPLOMA') && \Tanais\User::getInstance()->isDesigner()): ?>
            <br><b>Вы зарегистированы как дизайнер</b>
            <?
            continue;
            ?>
        <? endif; ?>
    <div class="item">
        <? if ($FIELD_NAME == 'UF_DIPLOMA'): ?>
            <br><b>Если вы хотите стать дизайнером загрузите свой диплом.</b><br>
            <? if ($arUserField['VALUE']): ?>
                <div class="noty-new-designer" style="color:green">
                    Заявка на дизайнера принята!<br>После модерации, вам на почтовый ящик <?=$correctNewDesigner;?> поступит уведеомление.
                </div>
            <? endif; ?>
        <? endif; ?>
        <div class="bx-title"><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?></div>
        <div class="bx-input"><?$APPLICATION->IncludeComponent(
                "bitrix:system.field.edit",
                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?></div>
    </div>
    <?endforeach;?>
<?endif;?>