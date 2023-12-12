<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<div class="register_children">
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="subtitle">Шаг 2 из 2</div>
            <div class="title">Дети</div>
            <div class="desc">Укажите основные данные – это поможет нам подбирать предложения товаров и услуг персонально для вашего ребёнка.
            </div>
            <div class="bx-auth-reg">
            </div>
        </div>
    </div>
<!--<div class="addtab">Добавить +</div>-->
<div class="errortext"></div>
<div class="tab_menu">
    <ul>
        <li class="first_tab active" data-id="1011538">
            <div>Первый ребенок</div>
        </li>
        <li class="second_tab" data-id="2022389">
            <div >Второй ребенок</div>
        </li>
        <li class="third_tab" data-id="3033472">
            <div>Третий ребенок</div>
        </li>
        <li class="addtab">
            <div ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <rect width="20" height="20" rx="10" fill="#009B9A"/>
                    <path d="M4 10H10M10 10H16M10 10V4M10 10V16" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg></div>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
<form action="/" method="post" id="reg_form" name="my-form">
    <div class="content"></div>
    <div class="clearfix"></div>
    <input type="submit" value="отправить" name="submit" id="reg_form">
</form>
<div class="out">
</div>
</div>
<script>
    function loadcontent(random) {
        $.ajax({
            type: "POST",
            url: '/local/components/smdev/child.form/ajax/add_tabs.php',
            data: {phone: 'test', random: random},
            timeout: 3000,
            beforeSend: function () {
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
                $('.content').append(data);
            }
        });
    }

    function random() {
        let rand = 100000 + Math.random() * (200000 - 100000);
        let random = Math.round(rand);
        return random;
    }
    function CloneElement(){

        $(".content img.calendar-icon").clone().appendTo($(".form-group"));
    }
    CloneElement();
    function active_tab() {
        $(".register_children .tab_menu ul > li").each(function () {
            if (!$(this).hasClass("addtab")) {
                $(this).on('click', function () {
                    $(".register_children .tab_menu ul > li").removeClass('active');
                    $(this).addClass('active');
                    $('#win8_wrapper').css('display', 'block')
                    setTimeout(function () {
                        $('#win8_wrapper').css('display', 'none')
                    }, 300);

                });
            }
        });
    }
    function close_tab() {
        $('.close_tab').each(function () {
            $(this).on('click', function () {

                let id = $(this).data('id_tab');
                $('#win8_wrapper').css('display', 'block')
                setTimeout(function () {
                    $('#win8_wrapper').css('display', 'none')
                }, 300);
                $('#' + id).remove()
                $('.' + id).remove()
                $(this).remove();
                $('.tab').removeClass('active');
                $('.tab#1011538').addClass('active');
                $('.first_tab').addClass('active');
                if($(".register_children .tab_menu ul > li").length < 7){
                    $('.addtab').show();
                }
            });
        });
    }
    loadcontent(1011538);
    active_tab();
    $('.addtab').on('click', function () {
        let rand = 100000 + Math.random() * (200000 - 100000);
        let random = Math.round(rand);
        let tab_active = '';
        let children_num = '';
        $('.tab').removeClass('active');
        $(this).addClass('active');
        $('#win8_wrapper').css('display', 'block')
        setTimeout(function () {
            $('#win8_wrapper').css('display', 'none')
        }, 300);
        loadcontent(random);
        switch($(".register_children .tab_menu ul > li").length) {
            case 4:
                children_num = 'Четвертый ребенок'
                break;
            case 5:
                children_num = 'Пятый ребенок'
                break;
            case 6:
                children_num = 'Шестой ребенок'
                break;
            default:
                children_num = 'Ребенок'
        }
        $(".register_children .tab_menu ul > li").removeClass('active');
        $('.tab_menu ul li.addtab').before('<li class="'+random+' active" onclick="set_child('+random+')" data-id="'+random+'"><div >'+children_num+'</div></li><span class="close_tab" data-id_tab="'+random+'">x</span>')
        tab_active = $('.content').find('#' + random);
        close_tab()
        active_tab();
        if (tab_active) {
            tab_active.show();
        } else {
            tab_active.hide();
        }
        if($(".register_children .tab_menu ul > li").length > 6){
            $('.addtab').hide();
        }
    })

    $('.first_tab').on('click', function () {
        let tab_active = '';
        $('.tab').removeClass('active');
        if ($('.tab').find("#1011538").length == 1) {
            $('.tab#1011538').addClass('active');
        } else {
            $('.tab').removeClass('active');
            loadcontent(1011538);
        }
    });
    $('.second_tab').on('click', function () {
        $('.tab').removeClass('active');
        if ($('.tab').find("#2022389").length == 1) {
            $('.tab#2022389').addClass('active');
        } else {
            $('.tab').removeClass('active');
            loadcontent(2022389);
        }
    })
    $('.third_tab').on('click', function () {
        $('.tab').removeClass('active');
        if ($('.tab').find("#3033472").length == 1) {
            $('.tab#3033472').addClass('active');
        } else {
            $('.tab').removeClass('active');
            loadcontent(3033472);
        }
    })
    function set_child(random){
        $('.tab').removeClass('active');
        if ($('.tab').find("#"+random+"").length == 1) {
            $('.tab#'+random+'').addClass('active');
        } else {
            $('.tab').removeClass('active');
            loadcontent(random);
        }
    }

    function getValues(event) {
        event.preventDefault();
        let errMSG = "";
        let type = '';
        let value = '';
        let numbers = '';
        let data = new Object();
        let checkbox_arr = new Object();
        let arr = new Array();
        let arr_value = new Object();
        let error_checkbox = true;
        let input_elements = '';
        let name = '';
        let error = false;
            //console.log(this)
        //let elements = this.getElementsByClassName("active")[0].getElementsByTagName('input')
        let elements = document.querySelectorAll(".tab")
        //console.log(elements.getElementsByTagName('input'));
        for (var n = 0; n < elements.length; n++) {
            //console.log(elements[n].getElementsByTagName('input'));
            input_elements = elements[n].getElementsByTagName('input')
            for (let i = 0; i < input_elements.length; i++) {

                // let name_fields = input_elements[i];
                // if(name_fields.classList.contains('name_child')){
                //     if(name_fields.value.length < 1) {
                //         console.log(name_fields);
                //         $('.errortext').append('<div class="error">Поле "Имя" обязательно для заполнения</div>');
                //         name_fields.addClass('error_input');
                //         error = true;
                //     }
                // }


                name = input_elements[i].name;
                type = input_elements[i].type;
                value = input_elements[i].value;
                if (input_elements[i].name == 'number') {
                    numbers = input_elements[i].value;
                }
                //console.log(value)
                //console.log(input_elements[i].name)
                name = input_elements[i].name;
                name = name.replace('_', '');
                name = name.replace(new RegExp(numbers, "g"), '');
                //console.log(name)
                if (input_elements[i].name == name) {
                   // console.log(input_elements[i].name)

                }
                if (type == 'checkbox') {
                    if (input_elements[i].checked) {
                        arr.push(value);
                        error_checkbox = false;
                    }

                    if (error_checkbox) {
                        input_elements[i].style.color = 'red';
                       // console.log('Не заполнен отдых')

                    }
                }else {
                    //arr_value = [name, value]
                    arr_value[name] = value;
                }
                checkbox_arr = {'checkbox': arr, 'input': arr_value}

            }
            data[numbers] = checkbox_arr;
            arr = new Array();
            //delete arr_value[name];
            arr_value = new Object();


        }
        if(error_form()) {
            data = JSON.stringify(data)
            console.log(data)
            $.ajax({
                type: "POST",
                url: '/local/components/smdev/child.form/ajax/add_iblock.php',
                data: {data: data},
                timeout: 5000,
                beforeSend: function () {
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
                    if(!answe){
                        $('.tab_menu').hide(300);
                        $('#reg_form').hide(300);
                        $('.errortext').append('<br><br><div class="alert alert-success" role="alert" style="text-align: center"><h4>Регистрация прошла успешно !</h4>Вы будите перенаправлены на страницу каталога.</div>')
                        setTimeout(function () {
                            window.location.href = '/test-catalog/';
                        }, 4000);
                        $('html, body').animate({
                            scrollTop: $(".wrapp_block").offset().top // класс объекта к которому приезжаем
                        }, 1000); // Скорость прокрутки
                    }else {
                        $('.errortext').html(data)
                    }
                }
            });
            // return data;
        }
        if ("" != errMSG) {
            alert("Не заполнены обязательные поля:\n" + errMSG);
            return false;
        }
    }


    function error_form() {
       // $('.register_children #reg_form').submit(function (e) {

            let elements = document.querySelectorAll(".tab");
            let error = false;
            $(".error").remove();
            $("input").removeClass('error_input');
            $("label").removeClass('error_check');
            for (let n = 0; n < elements.length; n++) {
                let first_name = $(elements[n]).find('.name_child');
                let birthday = $(elements[n]).find('.birthday');
                let gender = $(elements[n]).find('.gender');
                let relax = $(elements[n]).find('.relax');
                let sport = $(elements[n]).find('.sport');
                let holiday = $(elements[n]).find('.holiday');
                let since = $(elements[n]).find('.since');
                let life = $(elements[n]).find('.life');


                if (first_name.val().length < 1) {
                    //$('.errortext').append('<div class="error">Поле "Имя" обязательно для заполнения</div>');
                    first_name.addClass('error_input');
                    error = true;
                }
                if (birthday.val().length < 1) {
                    birthday.addClass('error_input');
                    error = true;
                }
                if (!gender.is(':checked')) {
                    gender.parents('.form-check').find('label').addClass('error_check');
                    console.log(gender)
                    error = true;
                }
                if (!relax.is(':checked')) {
                    relax.parents('.form-check').find('label').addClass('error_check');
                    console.log(relax)
                    error = true;
                }
                if (!sport.is(':checked')) {
                    sport.parents('.form-check').find('label').addClass('error_check');
                    console.log(sport)
                    error = true;
                }
                if (!holiday.is(':checked')) {
                    holiday.parents('.form-check').find('label').addClass('error_check');
                    console.log(holiday)
                    error = true;
                }
                if (!since.is(':checked')) {
                    since.parents('.form-check').find('label').addClass('error_check');
                    console.log(since)
                    error = true;
                }
                if (!life.is(':checked')) {
                    life.parents('.form-check').find('label').addClass('error_check');
                    console.log(life)
                    error = true;
                }
                if (error) {
                    $('#win8_wrapper').css('display', 'block')
                    setTimeout(function () {
                        $('#win8_wrapper').css('display', 'none')
                    }, 300);
                    $('.tab_menu li').removeClass('active');
                    $('.tab').removeClass('active');
                    $(first_name).parents('.tab').addClass('active');
                    let id_let = $(first_name).parents('.tab').attr("id")
                    $('.tab_menu li').each(function (){
                        if(id_let == $(this).data("id")){
                            $(this).addClass('active');
                        }
                    })
                    break;
                }else {
                    $(first_name).parents('.tab').removeClass('active');
                    continue
                }
            }
            if (error) {
                $('html, body').animate({
                    scrollTop: $(".register_children .title").offset().top // класс объекта к которому приезжаем
                }, 1000); // Скорость прокрутки

                return false;
            }else {
                return true;

            }
       // });

    }
    //
    let form = document.forms["my-form"];
    form.addEventListener("submit", getValues);
</script>

