<?
// define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("body_class", "page-online-service");
$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
$APPLICATION->SetPageProperty("WIDE_PAGE", "Y");
$APPLICATION->SetTitle("Услуги и онлайн-сервисы");
?>
<div class="middle  ">
    <div class="container FLOAT_BANNERS " data-class="float_banners_drag">
        <?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/mainpage/components/float_banners/type_2.php'));?>
    </div>
</div>
<style>
	.content_wrapper_block.float_banners2 .maxwidth-theme {padding: 0;}
	.item-views.float_banners2 {padding: 0;}
	.wraps > .wrapper_inner {padding-bottom: 0;}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>