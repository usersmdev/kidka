<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
    return;

if (empty($arTemplateParameters)) {
    $arTemplateParameters = [];
}
    
$arProperty_LNSF = [];
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	// if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "F")))
	// {
		$arProperty_LNSF[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	// }
}


foreach ($arProperty_LNSF as $key => $title)
{
	$arTemplateParameters["CUSTOM_TITLE_".$key] = array(
		"PARENT" => "TITLES",
		"NAME" => $title,
		"TYPE" => "STRING",
	);
}

// $arComponentParameters['GROUPS']['SUFFIXES'] = [
// 	'NAME' => 'Тип данных',
// ];
foreach ($arProperty_LNSF as $key => $title)
{
	$arTemplateParameters["CUSTOM_SUFFIX_".$key] = array(
		"PARENT" => "TITLES",
		"NAME" => 'suffix ' . $title,
		"TYPE" => "STRING",
	);
}

// $arTemplateParameters = array(
//     "SECTIONS_VIEW_MODE" => array(
//         "PARENT" => "SECTIONS_SETTINGS",
//         "NAME" => GetMessage('CPT_BC_SECTIONS_VIEW_MODE'),
//         "TYPE" => "LIST",
//         "VALUES" => $arViewModeList,
//         "MULTIPLE" => "N",
//         "DEFAULT" => "LIST",
//         "REFRESH" => "Y"
//     ),
//     "SECTIONS_SHOW_PARENT_NAME" => array(
//         "PARENT" => "SECTIONS_SETTINGS",
//         "NAME" => GetMessage('CPT_BC_SECTIONS_SHOW_PARENT_NAME'),
//         "TYPE" => "CHECKBOX",
//         "DEFAULT" => "Y"
//     )
// );

// $arComponentParameters["PARAMETERS"]["CUSTOM_TITLE_".$key] = array(
//     "PARENT" => "TITLES",
//     "NAME" => $title,
//     "TYPE" => "STRING",
// );
?>