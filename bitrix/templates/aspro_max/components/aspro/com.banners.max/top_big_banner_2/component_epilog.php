<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $bLongBanner, $bLightHeader, $bBigBannersIndexClass;
if(strpos($bBigBannersIndexClass, 'hidden') === false)
{
	$bLongBanner = true;

	if(isset($templateData["BANNER_LIGHT"]) && $templateData["BANNER_LIGHT"])
		$bLightHeader = true;
}
?>