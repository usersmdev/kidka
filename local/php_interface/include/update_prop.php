<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CModule::IncludeModule('iblock')) {
    printf("ERROR: Can't include iblock module!");
    die();
} else {

    $arDeveloper = [
        "DECOMASTER КОРЕЯ"=>"Южная Корея",
        "DECOMASTER КИТАЙ"=>"Китай",
        "DECOMASTER РОССИЯ"=>"Россия",
        "DECOMASTER БЕЛЬГИЯ"=>"Бельгия",
        "NMC"=>"Бельгия",
        "DECOSA"=>"Германия",
        "AMERICAN ACCENTS"=>"США",
        "LEPNINAPLAST"=>"Россия"
    ];

    $arRes = [];
    $res = CIBlockElement::GetList(array('ID' => 'ASC'), array('IBLOCK_ID' => '4',"!PROPERTY_PRODUCER"=>false),false,false,["ID","IBLOCK_ID","PROPERTY_PRODUCER"]);
    while($ar_res = $res->Fetch())
    {
        if(array_key_exists($ar_res["PROPERTY_PRODUCER_VALUE"],$arDeveloper)){

            CIBlockElement::SetPropertyValuesEx($ar_res["ID"], false, array("VENDOR_REGION" => $arDeveloper[$ar_res["PROPERTY_PRODUCER_VALUE"]]));

            $arRes[] = "update Elem ID=".$ar_res["ID"];

        }
    }
    echo "<pre>";
    print_r($arRes);
    echo "</pre>";

}