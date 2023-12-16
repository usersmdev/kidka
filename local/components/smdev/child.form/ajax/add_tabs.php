<?php
if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$html = '<div class="tab active" id="'.$_POST['random'].'">

<div id="'.$_POST['random'].'">
<div class="first_block">
<div class="container_reg">
<div class="container_form">
<div class="row">
';
$html .= '';
$html .= '<input type="hidden" name="number" value="'.$_POST['random'].'">';
$html .= '<div class="col-form"><div class="col-md-6 col-xs-12"><div class="form-group"><label for="first_text'.$_POST['random'].'">Имя ребенка<span class="">*</span></label><input type="text" class="form-control name_child" id="first_text'.$_POST['random'].'" name="name_'.$_POST['random'].'" placeholder="Введите имя"></div></div>';
$html .= '<div class="col-md-6 col-xs-12"><div class="form-group" style="position: relative"><label for="birthday'.$_POST['random'].'">Дата рождения<span class="">*</span></label><input type="text" class="form-control birthday" id="birthday'.$_POST['random'].'"  name="birthday_'.$_POST['random'].'" placeholder="ДД.ММ.ГГ"><img src="/bitrix/js/main/core/images/calendar-icon.gif" alt="Выбрать дату в календаре" class="calendar-icon" onclick="BX.calendar({node:this, field:birthday_'.$_POST['random'].', form: \'my-form\', bTime: false, currentTime: \'1702388875\', bHideTime: true});" onmouseover="BX.addClass(this, \'calendar-icon-hover\');" onmouseout="BX.removeClass(this, \'calendar-icon-hover\');" border="0"></div></div></div><div class="clearfix"></div>';
$html .= '';

$html .= '<div class="col-md-6 col-xs-12 block_radio"><div class="form-group"><label class="form-check-label" for="gender'.$_POST['random'].'">Пол ребенка<span class="">*</span></label><div class="radio-flex"><div class="form-check radio">
<input type="radio" class="form-check-input gender custom-radio" id="boy'.$_POST['random'].'"  name="gender_'.$_POST['random'].'" value="Мальчик" >
<label class="form-check-label" for="boy'.$_POST['random'].'" >Мальчик</label></div><div class="form-check radio">
<input type="radio" class="form-check-input gender custom-radio" id="girl'.$_POST['random'].'"  name="gender_'.$_POST['random'].'"  value="Девочка">
<label class="form-check-label" for="girl'.$_POST['random'].'">Девочка</label></div></div></div></div>';
$html .= '<div class="clearfix"></div>';
$html .= '<div class="col-md-12"><div class="form_title">Какие услуги наиболее интересны и важны для ребёнка и вас?</div><div class="form_subtitle">Выберите чем увлекается ваш ребёнок – это поможет нам подбирать предложения товаров и услуг, формируя подборку исходя из персональных предпочтений.</div></div>';



//Отдых
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Отдых<div class="check_subtitle">*Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1953);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check checkbox">
          <input class="form-check-input relax custom-checkbox" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'" >
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div>';

//Праздники
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Праздники<div class="check_subtitle">*Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(2091);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check checkbox">
          <input class="form-check-input holiday custom-checkbox" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'" >
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div>';


//Учеба
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Учеба<div class="check_subtitle">*Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1952);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check" checkbox>
          <input class="form-check-input since custom-checkbox" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'" >
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div></div></div>';
$html .= '</div></div>
<div class="second_block">
<div class="container_reg">
<div class="container_form">
<div class="row">
';
//Спорт
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Спорт<div class="check_subtitle">*Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1940);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check checkbox">
          <input class="form-check-input sport custom-checkbox" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'" >
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div>';


//Здоровье
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Здоровье<div class="check_subtitle">*Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1951);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check checkbox">
          <input class="form-check-input life custom-checkbox" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'" >
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        
        ';


    }
}



$html .= '</div></div></div></div></div>
<div class="thirdd_block">
<div class="container_reg">
<div class="container_form">
<div class="row">';

$html .= '<div class="clearfix"></div>';
$html .= '<div class="col-md-12"><div class="form_title" style="margin-top: 44px">Индивидуальные параметры ребёнка</div><div class="form_subtitle" style="margin-bottom: 40px">Это поможет нам сделать подборку лучших товаров, которые точно подойдут именно для вашего ребёнка.</div></div>';
$html .= '
<div class="input_flex">
<div class="form-group"><label for="height'.$_POST['random'].'">Рост ребёнка</label><input type="text" class="form-control" id="height'.$_POST['random'].'" name="height_'.$_POST['random'].'" placeholder="Введите значение"></div>
<div class="form-group"><label for="weight'.$_POST['random'].'">Вес ребёнка</label><input type="text" class="form-control" id="weight'.$_POST['random'].'" name="weight_'.$_POST['random'].'" placeholder="Введите значение"></div>
<div class="form-group"><label for="shoulder'.$_POST['random'].'">Обхват в плечах</label><input type="text" class="form-control" id="shoulder'.$_POST['random'].'" name="shoulder_'.$_POST['random'].'" placeholder="Введите значение"></div>
</div>
<div class="input_flex">
<div class="form-group"><label for="waist'.$_POST['random'].'">Обхват в талиии</label><input type="text" class="form-control" id="waist'.$_POST['random'].'" name="waist_'.$_POST['random'].'" placeholder="Введите значение"></div>
<div class="form-group"><label for="chest'.$_POST['random'].'">Обхват груди</label><input type="text" class="form-control" id="chest'.$_POST['random'].'" name="chest_'.$_POST['random'].'" placeholder="Введите значение"></div>
<div class="form-group"><label for="size'.$_POST['random'].'">Размер обуви (RU)</label><input type="text" class="form-control" id="size'.$_POST['random'].'" name="size_'.$_POST['random'].'" placeholder="Введите значение"></div>
</div>
';


$html .= '</div></div></div></div></div>';
echo $html;