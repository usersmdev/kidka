<?
$count=count($arResult["ITEMS"]);
$diff=5-$count;
if($count<5){
	for($i=1;$i<=$diff;$i++){
		$arResult["ITEMS"][]='';
	}
}

CatalogHelper::fixItems($arResult, $arParams, ['viewed_products' => true]);
?>