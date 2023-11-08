<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Полезные материалы");

if (!in_array(11, $GLOBALS['USER']->GetUserGroupArray())) {
    echo 'Вам нужно зарегистрироваться как партнер';
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    return;
}

?><div class="ordered-block tizers-block in-detail-news1" style="padding-bottom:35px">
<div class="content_wrapper_block front_tizers">
<div class="maxwidth-theme only-on-front">
<div class="item-views tizers left">
<div class="items tops">
<div class="row flexbox justify-center">

<div class="item-wrapper col-md-4 col-sm-4 col-xs-6 clearfix" style="padding-top:25px">
<div class="value font_xs muted777" style="padding-bottom:15px">Регулярное обновление<br> оптовых прайс-листов</div>
<a class="btn btn-default wc white" href="#"><i class="fa fa-file-excel-o"></i><span>Скачать прайс-лист</span></a>
</div>


<div class="item-wrapper col-md-4 col-sm-4 col-xs-6 clearfix" style="padding-top:25px">
<div class="value font_xs muted777" style="padding-bottom:15px">Фотографии товаров<br> в&nbsp;высоком качестве</div>
<a class="btn btn-default wc white" href="#"><i class="fa fa-file-image-o"></i><span>Скачать фотографии</span></a>
</div>


<div class="item-wrapper col-md-4 col-sm-4 col-xs-6 clearfix" style="padding-top:25px">
<div class="value font_xs muted777" style="padding-bottom:15px">Информационные материалы<br> о&nbsp;продукции</div>
<a class="btn btn-default wc white" href="#"><i class="fa fa-file-text-o"></i><span>Справочник менеджера</span></a>
</div>


</div>
</div>
</div>
</div>
</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>