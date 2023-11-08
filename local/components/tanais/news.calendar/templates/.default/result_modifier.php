<?php
require( $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );

if($arParams["SECTION_ID"]){
    $section = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], "ID" => $arParams["SECTION_ID"]));
    while($res = $section->Fetch()){
        $sectionId = $res["ID"];
    }
    foreach ($arResult["MONTH"] as $keyWeek => $week){
            foreach($week as $keyDay =>  $day){
                if($day["events"]){
                    foreach($day["events"] as $keyEvent => $event) {
                        $element = CIBlockElement::GetByID($event["id"]);
                        while($resElement = $element->Fetch()){
                            if($resElement["IBLOCK_SECTION_ID"] == $sectionId){
                                $arResult["MONTH"][$keyWeek][$keyDay]["events"][$keyEvent] = $resElement;
                            }else{
                                unset($arResult["MONTH"][$keyWeek][$keyDay]["events"][$keyEvent]);
                            }
                        }
                    }
                }
            }
        }
}