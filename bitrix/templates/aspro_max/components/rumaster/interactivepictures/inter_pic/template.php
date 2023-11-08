<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CUtil::InitJSCore( array('ajax' , 'popup' ));
?>
<?/*<pre><? print_r([
    // $arResult[2],
    json_decode($arResult[2]['SETTINGS'], true)['spots'][0]['tooltip_content']['squares_settings']['containers'][0]['settings']['elements'][0]['options']['imageBitrix'],
]) ?></pre>*/?>
<?if (!empty($arResult)):?>
    <?foreach($arResult as $arItem){
        $objSettings = json_decode($arItem['SETTINGS']);
        // var_dump($objSettings);
        ?>
        <div id="<?=$imageId?>" data-settings='<?=$arItem['SETTINGS']?>' class="inter-box-img"></div>
    <?}?>
    <div class="slider-inter-big">
        <?foreach($arResult as $arItem){
            $objSettings = json_decode($arItem['SETTINGS']);
            $tempId=randString(4, array('0123456789'));
            $imageId = 'image-map-pro-container_' . $tempId;
            ?>
            <div id="<?=$imageId?>" data-settings='<?=$arItem['SETTINGS']?>' class="inter-box-img"></div>
        <?}?>
    </div>
    <div class="slider-inter-tmb">
        <?foreach($arResult as $arItem){
            $objSettings = json_decode($arItem['SETTINGS']);
            ?>
            <div class="img"><img src="<?=$objSettings->image->url?>" alt="img"></div>
        <?}?>
    </div>
<?endif?>

