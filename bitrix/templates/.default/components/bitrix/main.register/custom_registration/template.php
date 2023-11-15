<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
function gen_password($length = 6)
{
    $password = '';
    $arr = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );

    for ($i = 0; $i < $length; $i++) {
        $password .= $arr[random_int(0, count($arr) - 1)];
    }
    return $password;
}

$gen_password = gen_password(10);

if(!$_SESSION['sms_phone2']){
    $arResult["VALUES"]['PERSONAL_PHONE'] = '';
    $arResult["VALUES"]['PHONE_NUMBER'] = '';
}
?>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@latest/dist/css/suggestions.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@latest/dist/js/jquery.suggestions.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/Inputmask@5.0.3/dist/jquery.inputmask.min.js"></script>
<div class="bx-auth-reg">

    <? if ($USER->IsAuthorized()): ?>

        <p><? echo GetMessage("MAIN_REGISTER_AUTH") ?></p>

    <? else: ?>
    <div class="errortext"></div>
        <?
        if (!empty($arResult["ERRORS"])):
            foreach ($arResult["ERRORS"] as $key => $error)
                if (intval($key) == 0 && $key !== 0)
                    if ($key == 'LOGIN')
                        unset($arResult["ERRORS"][$key]);
                    else
                        $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
            ShowError(implode("<br />", $arResult["ERRORS"]));
     elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
            ?>
            <p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
        <? endif ?>

        <?
        if($_REQUEST["BACKURL"] <> ''):
            ?>
            <input type="hidden" name="backurl" value="<?=$_REQUEST["BACKURL"]?>" />
        <?
        endif;
        ?>

        <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data" id="reg_form">
            <?
            if ($arResult["BACKURL"] <> ''):
                ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                <? echo $arResult["BACKURL"]; ?>
            <?

            endif;
            ?>

            <script>
                <?CJSCore::Init(['masked_input']);?>
                (function ($) {
                    BX.ready(function () {
                        var result = new BX.MaskedInput({
                            mask: '+7 (999) 999-99-99', // устанавливаем маску
                            input: BX('phone'),
                            placeholder: '_' // символ замены +7 ___ ___ __ __
                        });
                    });
                })(jQuery);
            </script>

            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="preloader loaded">
                        <svg class="preloader__image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                  d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                            </path>
                        </svg>
                    </div>
                    <div class="row">
                        <? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>

                            <div class="col-md-6 col-xs-12">
                                <? if ($FIELD !== 'LOGIN' && $FIELD !== 'PASSWORD' && $FIELD !== 'CONFIRM_PASSWORD' && $FIELD !== 'PERSONAL_PHONE') { ?>
                                    <label>
                                        <?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:
                                        <? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
                                            <span>*</span>
                                        <? endif ?>
                                    </label>
                                <? } ?>
                                <? if ($FIELD == 'EMAIL') { ?>
                                    <input class="form-control" size="30" type="email" name="REGISTER[<?= $FIELD ?>]"
                                           onkeyup="document.getElementById('login-field').value = this.value"
                                           value="<?= $arResult["VALUES"][$FIELD] ?>"
                                           placeholder="<?= GetMessage("REGISTER_PLACEHOLDER_" . $FIELD) ?>"/>
                                <? } elseif ($FIELD == 'LOGIN') { // Скрываем поле LOGIN ?>
                                    <input id="login-field" size="30" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                           value="<?= $arResult["VALUES"][$FIELD] ?>"/>

                                <? } elseif ($FIELD == 'PASSWORD') { ?>
                                    <input size="30" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                           value="<?= $gen_password ?>"/>
                                <? } elseif ($FIELD == 'CONFIRM_PASSWORD') { ?>
                                    <input size="30" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                           value="<?= $gen_password ?>"/>
                                <? } elseif ($FIELD == 'PHONE_NUMBER') { ?>
                                    <div class="phone_conf">
                                        <input id="phone" class="form-control" size="30" type="text"
                                               name="REGISTER[<?= $FIELD ?>]"
                                               onkeyup="document.getElementById('personal_phone').value = this.value.replace(/[^0-9]/g,'')"
                                               value="<?= $arResult["VALUES"][$FIELD] ?>"
                                               placeholder="+7 (___) ___-__-__"

                                        />
                                        <input type="text" class="form-control clonphone" placeholder="+7 (___) ___-__-__" disabled style="display: none">
                                        <input type="hidden" value="" id="succode">
                                        <span class="success_code" style="display: none">
                                            <svg id="svg1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="30" height="30" viewBox="0 0 47 47"  >
                                                <title>animation icon -OK-</title>
                                                <circle fill="#4CAF50" cx="24" cy="24" r="21"/>
                                                <path class="path" fill= "none" stroke ="#CCFF90" stroke-width ="1.5" stroke-dasharray= "70.2" stroke-dashoffset="70.2"
                                                      d="M 34.6 14.6  L 21 28.2 L 15.4 22.6 L 12.6 25.4 L 21 33.8 L 37.4 17.4z">
                                                    <animate id="p1" attributeName="stroke-dashoffset" begin="0.2s" values="70.2;0" dur="0.5s" repeatCount="1" fill="freeze" calcMode="paced" restart="whenNotActive"/>
                                                    <animate id="f1" attributeName="fill" begin = "p1.end" values="#4CAF50; #CCFF90"  dur="0.1s" fill="freeze" restart="whenNotActive" />
                                                </path>
                                            </svg>
                                        </span>
                                        <a href="#" id="confirm_phone" style="display: none">Получить sms</a>
                                        <div class="error_mess"></div>
                                        <div class="confirmsms" style="display: none">
                                            <form method="post" action="" name="confirmcodeform" id="confirmcodeform">
                                                <lable>Введите код из смс:</lable>
                                                <input size="30" type="text" class="form-control" name="SMS_CODE" value="" autocomplete="off" />
                                                <input type="hidden" value="" id="scode">
                                                <span class="messege_code"></span>
                                                <div class="repeat_code">Вы сможете отправить код повторно через <span class="seconds"></span><a href="#" id="confirm_phone2" style="display:none">Отправить повторно</a></div>
                                            </form>
                                            <div id="bx_register_error" style="display:none"></div>
                                        </div>
                                        <div class="message_code"></div>
                                    </div>
                                <? } elseif ($FIELD == 'PERSONAL_PHONE') { ?>
                                    <input class="form-control" size="30" type="text" id="personal_phone" name="REGISTER[<?= $FIELD ?>]" style="display: none" value="<?= $arResult["VALUES"][$FIELD] ?>">
                                <? } elseif ($FIELD == 'PERSONAL_BIRTHDAY') { ?>
                                    <div class="birthday_field">
                                    <input size="30" class="form-control" type="text" name="REGISTER[<?= $FIELD ?>]"
                                           placeholder="<?= GetMessage("REGISTER_PLACEHOLDER_" . $FIELD) ?>"
                                           value="<?= $arResult["VALUES"][$FIELD] ?>" /><?
                                    if ($FIELD == "PERSONAL_BIRTHDAY")
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'SHOW_INPUT' => 'N',
                                                'FORM_NAME' => 'regform',
                                                'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                                'SHOW_TIME' => 'N'
                                            ),
                                            null,
                                            array("HIDE_ICONS" => "Y")
                                        );

                                    ?></div><? } else { ?>
                                    <input class="form-control" size="30" type="text" name="REGISTER[<?= $FIELD ?>]"
                                           value="<?= $arResult["VALUES"][$FIELD] ?>"
                                           placeholder="<?= GetMessage("REGISTER_PLACEHOLDER_" . $FIELD) ?>"/>
                                <? } ?>
                            </div>
                        <? endforeach ?>
                        <div class="clearfix"></div>
                        <input type="submit" name="register_submit_button" value="<?= GetMessage("AUTH_REGISTER") ?>"/>
                        <? // ********************* User properties ***************************************************?>
                        <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
                            <tr>
                                <td colspan="2"><?= trim($arParams["USER_PROPERTY_NAME"]) <> '' ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></td>
                            </tr>
                            <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                                <tr>
                                    <td><?= $arUserField["EDIT_FORM_LABEL"] ?>
                                        :<? if ($arUserField["MANDATORY"] == "Y"): ?><span
                                                class="starrequired">*</span><? endif; ?></td>
                                    <td>
                                        <? $APPLICATION->IncludeComponent(
                                            "bitrix:system.field.edit",
                                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                            array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y")); ?></td>
                                </tr>
                            <? endforeach; ?>
                        <? endif; ?>
                        <? // ******************** /User properties ***************************************************?>
                        <?
                        /* CAPTCHA */
                        if ($arResult["USE_CAPTCHA"] == "Y") {
                            ?>
                            <tr>
                                <td colspan="2"><b><?= GetMessage("REGISTER_CAPTCHA_TITLE") ?></b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                                         width="180" height="40" alt="CAPTCHA"/>
                                </td>
                            </tr>
                            <tr>
                                <td><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>:<span class="starrequired">*</span></td>
                                <td><input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                                </td>
                            </tr>
                            <?
                        }
                        /* !CAPTCHA */
                        ?>
                    </div>
                </div>
            </div>
        </form>

        <p>На основе вашего адреса мы будем более точно подбирать вам услуги и товары</p>

    <? endif //$arResult["SHOW_SMS_FIELD"] == true ?>


</div>
<?php
//Обработка смс подтверждения
//$rnd = rand(1000,9999);
if($_SESSION['sms_phone2']){?>
<script>

</script>
<?}else{?>
<script>
    $(document).ready(function () {
        var confphone = $('#succode').val()
        if (confphone == '200') {
            $('.success_code').show(500)
        }
    });
</script>
<?}

?>
<script>
    $(document).ready(function () {
        $('#reg_form').submit(function(e) {

            var first_name = $('input[name="REGISTER[NAME]"]').val();
            var city = $('input[name="REGISTER[PERSONAL_CITY]').val();
            var phone = $('input[name="REGISTER[PHONE_NUMBER]').val();
            var email = $('input[name="REGISTER[EMAIL]').val();
            var error = false;
            var confphone = $('#succode').val()
            $(".error").remove();

            if (first_name.length< 1) {
                $('.errortext').append('<div class="error">Поле "Имя" обязательно для заполнения</div>');
                error = true;
            }
            if (phone.length< 1) {
                $('.errortext').append('<div class="error">Поле "Телефон" обязательно для заполнения</div>');
                error = true;

            }else{
                if (confphone !== '200'){
                $('.errortext').append('<div class="error">Подтвердите номер телефона</div>');
                error = true;
            }}
            if (city.length< 1) {
                $('.errortext').append('<div class="error">Поле "Город" обязательно для заполнения</div>');
                error = true;

            }
            if (email.length< 1) {
                $('.errortext').append('<div class="error">Поле "E-mail" обязательно для заполнения</div>');
                error = true;
            } else {
                var regEx = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
                var validEmail = regEx.test(email);
                if (!validEmail) {
                    $('.errortext').append('<div class="error">Укажите корректный E-mail</div>');
                    error = true;
                }
            }
            if (error) {
                e.preventDefault();
            }
        });


        $('#confirmcodeform').on('submit', function (event) {
            event.preventDefault();
            var form_backurl = $(this).find('input[name="SMS_CODE"]').val();
            alert(form_backurl);
        });
    });

    $(document).ready(function () {
        $('.phone_conf').find('input[name="REGISTER[PHONE_NUMBER]"]').keyup(function () {
            var phone = $(this).val().replace(/[^0-9]/g,"")
            if(phone && phone.length == 11) {
                $('#confirm_phone').show(500);
            }
            else {
                $('#confirm_phone').hide(300)
            }
        });


        function time(){
            var _Seconds = 60,
                int;
            int = setInterval(function() {
                if (_Seconds > 0) {
                    _Seconds--;
                    $('.seconds').text(_Seconds);
                } else {
                    clearInterval(int);
                    $('.seconds').hide();
                    $('.repeat_code a').show(500);
                }
            }, 1000);
        }

        $('#confirm_phone').on('click', function(){
            sms()
            time();
        });
        $('#confirm_phone2').on('click', function () {
            sms()
            $('.seconds').show();
            $('.repeat_code a').hide(300);
            time();
        });

        $('#phone').keyup(function() {
           // if (this.value.match(/[^а-яА-Я\s]/g)) {this.value = this.value.replace(/[^а-яА-Я\s]/g, '')};
        });
        function sms() {
            var form_phone = $('.phone_conf').find('input[name="REGISTER[PHONE_NUMBER]"]').val();
            var scode = $('#scode').val();
            var phone = form_phone.replace(/[^0-9]/g,"");
            if(form_phone && phone.length == 11 && phone[1] == 9) {
                $('.error_mess').hide(300);

                $.ajax({
                    type: "POST",
                    url: '/ajax/register_confirm_phone.php',
                    data: {phone: form_phone, scode: scode},
                    timeout: 3000,
                    beforeSend: function() {
                        $('.preloader').addClass('loaded_hiding');
                    },
                    error: function (request, error) {
                        if (error == "timeout") {
                            alert('timeout');
                        } else {
                            alert('Error! Please try again!');
                        }
                    },
                    success: function (data) {
                        var answe = JSON.parse(data);
                        if (answe) {
                            console.log(answe)
                            $('.message_code').html(answe.code);
                            if (answe.error == 101) {
                                console.log(answe.error)
                                $('.error_mess').html("Пользователь с таким номером уже существует")
                                $('.error_mess').show(500);
                                $('.confirmsms').hide(300);
                            }else {
                                $('.confirmsms').show(500);
                                $('#confirm_phone').hide(500).remove();
                                $('#phone').hide(300)

                                //***************************
                            }
                        }
                    }
                });
            }
            else {
                $('.error_mess').show(500);
                $('.confirmsms').hide(300);
                $('.error_mess').html("Введите корректный номер телефона")
            }
            return false;
        };
        $('.confirmsms').find('input[name="SMS_CODE"]').keyup(function () {
            var code = $(this).val();
            var phone_for_clone = $('#phone').val();
            if(code && code.length == 4) {
                $.ajax({
                    type: "POST",
                    url: '/ajax/confirm_code.php',
                    data: {code: code},
                    timeout: 3000,
                    error: function (request, error) {
                        if (error == "timeout") {
                            alert('timeout');
                        } else {
                            alert('Error! Please try again!');
                        }
                    },
                    success: function (data) {
                        var answe = JSON.parse(data);
                        if (answe) {
                            if (answe.code == 'ok'){
                                $('.messege_code').hide(300)
                                $('.confirmsms').hide(300)
                                $('#confirm_phone').hide(500).remove();
                                $('.success_code').show(500)
                                $('#succode').val(200);

                                $('.clonphone').val(phone_for_clone);
                                $('.clonphone').show(500)
                            }else {
                                $('.messege_code').html(answe.code)
                            }


                        }
                    }
                });
            }
            return false;
        });
    });
</script>
<?php
$_SESSION['sms_phone2'] = '';
?>