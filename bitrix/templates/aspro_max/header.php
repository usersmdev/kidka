<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?if($GET["debug"] == "y")
	error_reporting(E_ERROR | E_PARSE);
IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $arRegion, $arSite, $arTheme, $bIndexBot, $bIframeMode;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
$bIncludedModule = (\Bitrix\Main\Loader::includeModule("aspro.max"));?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?> <?=($bIncludedModule ? CMax::getCurrentHtmlClass() : '')?>>
<head>
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowMeta("viewport");?>
	<?$APPLICATION->ShowMeta("HandheldFriendly");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
	<?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
	<?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
	<?$APPLICATION->ShowHead();?>
	<?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
	<?if($bIncludedModule)
		CMax::Start(SITE_ID);?>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/head.php'));?>
	<script src="https://api-maps.yandex.ru/2.1/?apikey=6b4c2a54-1ff3-4f1f-b458-ce0b57678048&lang=ru_RU" type="text/javascript">
    </script>
   <? use Bitrix\Main\Page\Asset;
	Asset::getInstance()->addCss("/local/css/custom_styles.css");
	Asset::getInstance()->addJs("/local/js/script.js");?>
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
	<link
	  rel="stylesheet"
	  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
	/>

<meta name="yandex-verification" content="ad1f0d8e4ed3ceda" />
<meta name="yandex-verification" content="f659c7b3dffb2bf7" />
</head>
<?$bIndexBot = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false);?>
<body class="<?=($bIndexBot ? "wbot" : "");?> site_<?=SITE_ID?> <?=($bIncludedModule ? CMax::getCurrentBodyClass() : '')?>" id="main" data-site="<?=SITE_DIR?>">
 <?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'local/include/modal.php'));?>
	<?if(!$bIncludedModule):?>
		<?$APPLICATION->SetTitle(GetMessage("ERROR_INCLUDE_MODULE_ASPRO_MAX_TITLE"));?>
		<center><?$APPLICATION->IncludeFile(SITE_DIR."include/error_include_module.php");?></center></body></html><?die();?>
	<?endif;?>
	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/body_top.php'));?>
	
									

	<?$arTheme = $APPLICATION->IncludeComponent("aspro:theme.max", ".default", array("COMPONENT_TEMPLATE" => ".default"), false, array("HIDE_ICONS" => "Y"));?>
	<?include_once('defines.php');?>
	<?CMax::SetJSOptions();?>

	<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/under_wrapper1.php'));?>
	<div class="wrapper1 <?=($isIndex && $isShowIndexLeftBlock ? "with_left_block" : "");?> <?=CMax::getCurrentPageClass();?> <?$APPLICATION->AddBufferContent(array('CMax', 'getCurrentThemeClasses'))?>  ">
		<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wrapper1.php'));?>
		<?if($APPLICATION->GetCurPage() == "/registratsiya/dobavit-rebenka.php"): ?>
			<?$reg_clas = 'add_ch'?>
		<?endif?>
		<div class="wraps hover_<?=$arTheme["HOVER_TYPE_IMG"]["VALUE"];?> <?=$reg_clas?>" id="content">
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/header_include/top_wraps.php'));?>

			<?if($isIndex):?>
				<?$APPLICATION->ShowViewContent('front_top_big_banner');?>
				<div class="wrapper_inner front <?=($isShowIndexLeftBlock ? "" : "wide_page");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?elseif(!$isWidePage):?>
				<div class="wrapper_inner <?=($isHideLeftBlock ? "wide_page" : "");?> <?=$APPLICATION->ShowViewContent('wrapper_inner_class')?>">
			<?endif;?>
				<div class="container_inner clearfix <?=$APPLICATION->ShowViewContent('container_inner_class')?>">
						<? $url = $APPLICATION->GetCurPage();
						$count_page = substr_count($url, '/');?>
				<?if(CSite::InDir("/offers/") || CSite::InDir("/izbrannoe-uslugi1/")): ?>
				<?$classblock = '';?>
					<?else:?>
				<?$classblock = 'right_block';?>
				<?endif;?>

				<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
					<div class="<?=$classblock;?> <?=(defined("ERROR_404") ? "error_page" : "");?> wide_<?=CMax::ShowPageProps("HIDE_LEFT_BLOCK");?> <?=$APPLICATION->ShowViewContent('right_block_class')?>">
				<?endif;?>
					<div class="middle <?=($is404 ? 'error-page' : '');?> <?=$APPLICATION->ShowViewContent('middle_class')?>">
						<?CMax::get_banners_position('CONTENT_TOP');?>
						<?if(!$isIndex):?>
							<div class="container">
								<?//h1?>
								<?if($isHideLeftBlock && !$isWidePage):?>
										<?$maxwidth = 'maxwidth-theme'?>
									<?if($APPLICATION->GetCurPage() == "/registratsiya/dobavit-rebenka.php"): ?>
										<?$maxwidth = ''?>
									<?endif;?>
									<div class="<?=$maxwidth?>">
								<?endif;?>
						<?endif;?>
						<?CMax::checkRestartBuffer();?>