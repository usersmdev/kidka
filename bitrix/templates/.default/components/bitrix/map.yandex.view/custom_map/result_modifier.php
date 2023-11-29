<?php



$hShopz = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>82, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'PROPERTY_MAP'));
while($row = $hShopz->Fetch())
{
    $arTmp = explode(',', $row['PROPERTY_COORDINATES_VALUE']);
    $arResult['POSITION']['PLACEMARKS'][] = array(
        'LON' => $arTmp[1],
        'LAT' => $arTmp[0],
        'TEXT' => $row['NAME'],
    );
}