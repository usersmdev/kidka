<?
/*
поключаем в /bitrix/php_interface/init.php
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php")) @require($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php");
*/

//Вводим ID созданных инфоблоков
define("META_TAGS", 31);
define("REDIR", 28);
define("CATALOG_TEXT", 35);

//Раскоменчиваем необходимые строки ниже

/*-----------------------------Мета теги--------------------------------*/
AddEventHandler("main", "OnEpilog", Array("seoMod", "MetaTags"));

/*-------------h1 (Если не работает через функцию MetaTags())-----------*/
AddEventHandler("main", "OnEndBufferContent", Array("seoMod", "h1_replace"));

/*----------------Абсолютные ссылки и Внешние ссылки--------------------*/
AddEventHandler("main", "OnEndBufferContent", Array("seoMod", "AbsoluteAndExternal"));


/*---------------------------Редиректы----------------------------------*/
AddEventHandler("main", "OnEpilog", Array("seoMod", "PermanentRedirects"));

/*------------------------------Текст-----------------------------------*/
/*			вставляем в /bitrix/header.php <!--TOP_TEXT--> 				*/
/*			вставляем в /bitrix/footer.php <!--BOTTOM_TEXT-->  			*/
/*----------------------------------------------------------------------*/
AddEventHandler("main", "OnEndBufferContent", Array("seoMod", "CatalogText"));

class seoMod
{
	//Мета теги
    static public function MetaTags()
	{
		if (!CModule::IncludeModule('iblock')) return;
		global $APPLICATION;


		$metadata = [];
		$elements_all = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>META_TAGS, 'ACTIVE'=>'Y', 'NAME'=>$_SERVER['REQUEST_URI']), false, array('nTopCount'=>1), array('NAME', 'PROPERTY_TITLE', 'PROPERTY_KEYWORDS', 'PROPERTY_DESCRIPTION', 'PROPERTY_H1'));
		if ($ar_meta = $elements_all->Fetch())
		{
			$metadata = $ar_meta;
			if ($ar_meta['PROPERTY_TITLE_VALUE']) $APPLICATION->SetPageProperty('title', $ar_meta['PROPERTY_TITLE_VALUE']);
			if ($ar_meta['PROPERTY_KEYWORDS_VALUE']) $APPLICATION->SetPageProperty('keywords', $ar_meta['PROPERTY_KEYWORDS_VALUE']);
			if ($ar_meta['PROPERTY_DESCRIPTION_VALUE']) $APPLICATION->SetPageProperty('description', $ar_meta['PROPERTY_DESCRIPTION_VALUE'] );
			//if ($ar_meta['PROPERTY_H1_VALUE']) $APPLICATION->SetTitle($ar_meta['PROPERTY_H1_VALUE']);
		}
		if ($APPLICATION->GetPageProperty('detail-tpl') == 'Y') {	// Шаблон для детальных, если мета не указаны в автоматизации
			$name = ($metadata['PROPERTY_H1_VALUE']?:$APPLICATION->GetTitle());
			$region = ($_SESSION['REASPEKT_GEOBASE']['CITY']?' в регионе '.$_SESSION['REASPEKT_GEOBASE']['CITY']:' в Москве');
			// $region = ' в Москве';
			//if (!$metadata['PROPERTY_TITLE_VALUE']) $APPLICATION->SetPageProperty('title', $name.' - купить'.$region.' – размеры, характеристики в каталоге интернет-магазина Decomaster™');
			//if (!$metadata['PROPERTY_DESCRIPTION_VALUE']) $APPLICATION->SetPageProperty('description', 'Интернет-магазин Decomaster™ предлагает купить '.$name.'. Постоянно обновляемый ассортимент товара, система скидок, собственное производство. Розница: +7 (495) 961-35-63 | Опт: +7 (495) 640-05-94');
			//if (!$metadata['PROPERTY_KEYWORDS_VALUE']) $APPLICATION->SetPageProperty('keywords', $name.', заказать, купить, интернет-магазин, лепнина, Decomaster™');
		}

	}

	//h1
    static public function h1_replace(&$content)
	{
		if (!CModule::IncludeModule('iblock')) return;
		global $APPLICATION;

		$elements_all = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>META_TAGS, 'ACTIVE'=>'Y', 'NAME'=>$_SERVER['REQUEST_URI']), false, array('nTopCount'=>1), array('PROPERTY_H1'));
		if ($ar_meta = $elements_all->Fetch())
		{
			if ($ar_meta['PROPERTY_H1_VALUE']) $content = preg_replace('/<h1([^>]*)>(.*?)<\/h1>/', '<h1 $1>'.$ar_meta['PROPERTY_H1_VALUE'].'</h1>', $content);
		}
	}

	//абсолютные ссылки и внешние ссылки
    static public function AbsoluteAndExternal(&$content)
	{
		//$content = str_replace('href="/', 'href="http://'.$_SERVER['HTTP_HOST'].'/', $content);
		//$content = str_replace("href='/", "href='http://".$_SERVER['HTTP_HOST']."/", $content);

		$url = $_SERVER['HTTP_HOST'];
		preg_match_all('~<a [^<>]*href="([^"]+)"[^<>]*>~', $content, $out_url);
		foreach ($out_url[0] as $val=>$zzz) {
			if (preg_match('~https://~', $zzz) && !preg_match('~https://(www.)?'.$url.'~i', $zzz) && !preg_match('~rel="nofollow"~i', $zzz)) {
				$content = str_replace($zzz,str_replace('href="','rel="nofollow" href="',$zzz),$content);
			}
			if (preg_match('~http://~', $zzz) && !preg_match('~http://(www.)?'.$url.'~i', $zzz) && !preg_match('~rel="nofollow"~i', $zzz)) {
				$content = str_replace($zzz,str_replace('href="','rel="nofollow" href="',$zzz),$content);
			}
		}
	}

	//Редиректы
    static public function PermanentRedirects()
	{

		if (!CModule::IncludeModule('iblock')) return;
		global $APPLICATION;
		$elements_redir = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>REDIR, 'ACTIVE'=>'Y', 'NAME'=>$_SERVER['REQUEST_URI']), false, array('nTopCount'=>1), array('NAME', 'PROPERTY_NEWURL'));
		if ($ar_redir = $elements_redir->Fetch())
		{
			LocalRedirect($ar_redir['PROPERTY_NEWURL_VALUE'], true, "301 Moved permanently");
		}
	}



	//текст
    static public function CatalogText(&$content)
	{
		if (!CModule::IncludeModule('iblock')) return;
		global $APPLICATION;

		$elements_text = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>CATALOG_TEXT, 'ACTIVE'=>'Y', 'NAME'=>$_SERVER['REQUEST_URI']), false, array('nTopCount'=>1), array('NAME', 'PROPERTY_TOP_TEXT', 'PROPERTY_BOTTOM_TEXT'));
		if ($ar_text = $elements_text->Fetch())
		{
			if($ar_text['PROPERTY_TOP_TEXT_VALUE']["TEXT"]) {
				$content = str_replace('<!--TOP_TEXT-->', $ar_text['PROPERTY_TOP_TEXT_VALUE']["TEXT"], $content);
			}
			if($ar_text['PROPERTY_BOTTOM_TEXT_VALUE']["TEXT"]) {
				$content = str_replace('<!--BOTTOM_TEXT-->', $ar_text['PROPERTY_BOTTOM_TEXT_VALUE']["TEXT"], $content);
			}
		}
	}

}

?>