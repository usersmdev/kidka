<?php
if (!defined('PUBLIC_AJAX_MODE')) {
    define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$html = '<div class="tab active" id="'.$_POST['random'].'"><div class="row" id="'.$_POST['random'].'">';
$html .= '<input type="hidden" name="number" value="'.$_POST['random'].'">';
$html .= '<div class="col-md-6 col-xs-12"><div class="form-group"><label for="first_text'.$_POST['random'].'">Имя ребенка<span class="">*</span></label><input type="text" class="form-control" id="first_text'.$_POST['random'].'" name="name_'.$_POST['random'].'"></div></div>';
$html .= '<div class="col-md-6 col-xs-12"><div class="form-group"><label for="birthday'.$_POST['random'].'">Дата рождения<span class="">*</span></label><input type="text" class="form-control" id="birthday'.$_POST['random'].'"  name="birthday_'.$_POST['random'].'"></div></div>';
$html .= '<div class="col-md-6 col-xs-12"><div class="form-group"><label class="form-check-label" for="gender'.$_POST['random'].'">Пол ребенка<span class="">*</span></label><div class="form-check"><input type="radio" class="form-check-input" id="boy'.$_POST['random'].'"  name="gender_'.$_POST['random'].'" value="Мальчик" ><label class="form-check-label" for="boy'.$_POST['random'].'" >Мальчик</label></div><div class="form-check"><input type="radio" class="form-check-input" id="girl'.$_POST['random'].'"  name="gender_'.$_POST['random'].'"  value="Девочка"><label class="form-check-label" for="girl'.$_POST['random'].'">Девочка</label></div></div></div>';
$html .= '<div class="clearfix"></div>';
$html .= '<p>Текст</p>';



//Отдых
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Отдых<div class="check_subtitle">Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1953);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check">
          <input class="form-check-input" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'">
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div>';

//Спорт
$html .= '<div class="col-md-4 col-xs-12"><div class="check_title">Спорт<div class="check_subtitle">Выберите минимум 1 пункт</div></div>';
$rsParentSection = CIBlockSection::GetByID(1940);
if ($arParentSection = $rsParentSection->GetNext())
{
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('iblock_id ' => 'desc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {

        $html .= '
        <div class="form-check">
          <input class="form-check-input" name="relax_'.$_POST['random'].'[]" type="checkbox" value="'.$arSect['ID'].'" id="check_'.$_POST['random']+$arSect['ID'].'">
          <label class="form-check-label" for="check_'.$_POST['random']+$arSect['ID'].'">
            '.$arSect['NAME'].'
          </label>
        </div>
        ';


    }
}
$html .= '</div>';

$html .= '</div></div>';
echo $html;