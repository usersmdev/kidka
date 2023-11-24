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


<!--<div class="addtab">Добавить +</div>-->
<div class="errortext"></div>
<div class="tab_menu">
    <ul>
        <li>
            <div class="first_tab">Первый ребенок</div>
        </li>
        <li>
            <div class="second_tab">Второй ребенок</div>
        </li>
        <li>
            <div class="third_tab">Третий ребенок</div>
        </li>
        <li>
            <div class="addtab">Добавить +</div>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
<form action="/" method="post" id="reg_form" name="my-form">
    <div class="content"></div>
    <div class="clearfix"></div>
    <input type="submit" value="отправить" name="submit">
</form>
<div class="out">
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

    loadcontent(1011538);

    $('.addtab').on('click', function () {
        let rand = 100000 + Math.random() * (200000 - 100000);
        let random = Math.round(rand);
        let tab_active = '';
        $('.tab').removeClass('active');
        $(this).addClass('active');

        loadcontent(random);
        $('.tab_menu ul').append('<li class="active"><div class="'+random+'" onclick="set_child('+random+')">Ребенок</div></li>')
        tab_active = $('.content').find('#' + random);
        if (tab_active) {
            tab_active.show();
        } else {
            tab_active.hide();
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
            //console.log(this)
        //let elements = this.getElementsByClassName("active")[0].getElementsByTagName('input')
        let elements = document.querySelectorAll(".tab")
        //console.log(elements.getElementsByTagName('input'));
        for (var n = 0; n < elements.length; n++) {
            //console.log(elements[n].getElementsByTagName('input'));
            input_elements = elements[n].getElementsByTagName('input')
            for (let i = 0; i < input_elements.length; i++) {

                name = input_elements[i].name;
                type = input_elements[i].type;
                value = input_elements[i].value;
                if (input_elements[i].name == 'number') {
                    numbers = input_elements[i].value;
                }
                console.log(value)
                console.log(input_elements[i].name)
                name = input_elements[i].name;
                name = name.replace('_', '');
                name = name.replace(new RegExp(numbers, "g"), '');
                if (input_elements[i].name == name) {
                    //name = input_elements[i].value;
                    console.log(';;;;;;;;;;;;;;;;;;;;;;;;;;')
                }
                if (type == 'checkbox') {
                    if (input_elements[i].checked) {
                        arr.push(value);
                        error_checkbox = false;
                    }

                    if (error_checkbox) {
                        input_elements[i].style.color = 'red';
                        console.log('Не заполнен отдых')

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
        data = JSON.stringify(data)
        console.log(data)
        $.ajax({
            type: "POST",
            url: '/local/components/smdev/child.form/ajax/add_iblock.php',
            data: {data: data},
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
                $('.out').html(data);
            }
        });
       // return data;

        if ("" != errMSG) {
            alert("Не заполнены обязательные поля:\n" + errMSG);
            return false;
        }
    }

    let form = document.forms["my-form"];
    form.addEventListener("submit", getValues);

</script>

