<?php
use	Bitrix\Main\Localization\Loc;

class InteractivecomponentExt extends Skyweb24\Interactivepictures\Interactivepictures {
    private function getNewDescription($idEl, $typeSettings){
		$arSelect = Array("ID", "PREVIEW_TEXT", "DETAIL_TEXT", "IBLOCK_ID");
		$arFilter = Array("ID"=>$idEl);
		$res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($iElem = $res->GetNextElement()){
			if(LANG_CHARSET == "windows-1251"){
				$json_obj = \Bitrix\Main\Web\Json::decode(iconv("windows-1251", "UTF-8", $typeSettings));
			}else{
				$json_obj = \Bitrix\Main\Web\Json::decode($typeSettings);
			}

			$types = &$json_obj['types'];
			foreach ($types as $key => &$value) {
					if($value['type'] == 'preview_text'){
						$value['text'] = $iElem->fields['PREVIEW_TEXT'];
					}
					else if($value['type'] == 'detail_text'){
						$value['text'] = $iElem->fields['DETAIL_TEXT'];
					}
			}

			return \Bitrix\Main\Web\Json::encode($json_obj);
		}
		return false;
    }
    
    private function getNewNameElement($idEl){
		$arSelect = Array("ID", "NAME", "IBLOCK_ID");
		$arFilter = Array("ID"=>$idEl);
		$res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($iElem = $res->GetNextElement()){
			return $iElem->fields["NAME"];
		}
		return false;

    }

    private function getNewImage($idEl, $typeSettings){
        $arSelect = Array("ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "IBLOCK_ID");
        $arFilter = Array("ID"=>$idEl);
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

        if($iElem = $res->GetNextElement()){

            try{
                $json_obj = \Bitrix\Main\Web\Json::decode($typeSettings);
            }
            catch (Exception $e){
                $json_obj = \Bitrix\Main\Web\Json::decode(iconv("windows-1251", "UTF-8", $jsonStr));
            }




            $types = &$json_obj['types'];
            foreach ($types as $key => &$value) {
                    if($value['type'] == 'preview_image'){
                        $value['text'] = \CFile::GetPath($iElem->fields['PREVIEW_PICTURE']);
                    }
                    else if($value['type'] == 'detail_image'){
                        $value['text'] == \CFile::GetPath($iElem->fields['DETAIL_PICTURE']);
                    }
            }
            return \Bitrix\Main\Web\Json::encode($json_obj);
        }
		return false;
    }
    
    private function getNewProps($idEl, $typeProps){
		$res = \CIBlockElement::GetList([], ['ID'=>$idEl], false, false, ['ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_*']);
		if($iElem = $res->GetNextElement()){
            
            //temp solution
            if(!$typeProps){
                $typeProps = '{"currentType":"","types":[]}';
            }

			if(LANG_CHARSET == "windows-1251"){
				$json_obj = \Bitrix\Main\Web\Json::decode(iconv("windows-1251", "UTF-8", $typeProps));
			}else{
				$json_obj = \Bitrix\Main\Web\Json::decode($typeProps);
			}
			$arProps = $iElem->GetProperties();
			foreach($arProps as $keyProp=>$nextProp){
				if(($nextProp['PROPERTY_TYPE']=='S' || $nextProp['PROPERTY_TYPE']=='N') && $nextProp['MULTIPLE']=='N'){
					if(!empty($nextProp['VALUE']) && empty($props['currentType'])){
						//$props['currentType']=$nextProp['NAME'];
					}
					$props[]=['type'=>$nextProp['NAME'], 'text'=>$nextProp['VALUE']];
				}
			}
			if(count($props)>0){
				$json_obj['types']=$props;
				$typeProps=\Bitrix\Main\Web\Json::encode($json_obj);
			}
		}
		return $typeProps;
    }
    
    private function getNewUrlProduct($IBlockId){
		$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "IBLOCK_ID", "PROPERTY_PRODUCT_URL");
		$arFilter = Array("ID"=>$IBlockId);
		$res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($iElem = $res->GetNextElement()){
			return $iElem->fields["PROPERTY_PRODUCT_URL_VALUE"] ? $iElem->fields["PROPERTY_PRODUCT_URL_VALUE"] : $iElem->fields["DETAIL_PAGE_URL"];
			// return $iElem->fields["DETAIL_PAGE_URL"];
		}

		return false;
	}
    
    public function updateSettigns(){

		 global $DB;
		 $resultDB = $DB->Query("SELECT id, image_url, settings FROM ".$this->tablePictures."  WHERE id=".$this->idPicture.";");
		 $resultDB = $resultDB->Fetch();
		 //$json = iconv("windows-1251", "UTF-8", $resultDB["settings"]);
		 if(!$resultDB){
			 $error["ERROR"] = "Image not found!";
			 return \Bitrix\Main\Web\Json::encode($error);
		 }

		 if(LANG_CHARSET == "windows-1251"){
			 $settings = \Bitrix\Main\Web\Json::decode(iconv("windows-1251", "UTF-8", $resultDB["settings"]));
		 }
		 else{
			 $settings = \Bitrix\Main\Web\Json::decode($resultDB["settings"]);
		 }
		 $spots = &$settings["spots"];
		// Rumaster\Utils\Dumper::dump($spots[0]['tooltip_content']['squares_settings']['containers']);

		 foreach ($spots as $keySpot => &$valueSpot) {
				$content_type =	$valueSpot['tooltip_content']['content_type'];
                $bitrixElementId = 0;
                if($valueSpot["bitrix_element_id"]){
                    $bitrixElementId = $valueSpot["bitrix_element_id"];
                }
				//if($content_type == 'content-builder'){
					if(!$valueSpot['tooltip_content']['squares_settings']['containers'] && $bitrixElementId === 0){
						continue;
					}
					$containers = &$valueSpot['tooltip_content']['squares_settings']['containers'];
					foreach ($containers as $keyContainer => &$valueContainer) {
                        $elements = &$valueContainer['settings']['elements'];
                        if($elements){
                            foreach ($elements as $keyElement => &$valueElement) { 
                                if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_NAME")){
                                    $valueElement['options']['nameBitrix']['idBitrix'] = $bitrixElementId;
                                    $newName = $this->getNewNameElement($valueElement['options']['nameBitrix']['idBitrix']);
                                    $valueElement['options']['nameBitrix']['name'] = $newName;
                                }else if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_DESCRIPTION")){
                                    $valueElement['options']['descriptionBitrix']['idBitrix'] = $bitrixElementId;
                                    $oldDescTypes = $valueElement['options']['descriptionBitrix']['typeDescription'];
                                    $newDescTypes = $this->getNewDescription($valueElement['options']['descriptionBitrix']['idBitrix'], $oldDescTypes);
                                    
                                    $valueElement['options']['descriptionBitrix']['typeDescription'] = $newDescTypes;
                                }else if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_IMAGE")){
                                    
                                    $valueElement['options']['imageBitrix']['idBitrix'] = $bitrixElementId;
                                    $oldDescTypes = $valueElement['options']['imageBitrix']['typeImage'];
                                    // \Bitrix\Main\Diag\Debug::writeToFile($newDescTypes,"image","/bitrix/php_interface/log.txt");
                                    $newDescTypes = $this->getNewImage($valueElement['options']['imageBitrix']['idBitrix'], $oldDescTypes);                                
                                    
                                    $valueElement['options']['imageBitrix']['typeImage'] = $newDescTypes;
                                }else if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_URL")){
                                    $valueElement['options']['urlBitrix']['idBitrix'] = $bitrixElementId;
                                    $oldUrlProduct = $valueElement['options']['urlBitrix']['urlProduct'];
                                    $newUrlProduct = $this->getNewUrlProduct($valueElement['options']['urlBitrix']['idBitrix']);
                                    $valueElement['options']['urlBitrix']['urlProduct'] = $newUrlProduct;
                                }else if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_PRICE")){
                                    $valueElement['options']['priceBitrix']['idBitrix'] = $bitrixElementId;
                                    $oldPrice = $valueElement['options']['priceBitrix']['price'];
                                    $newPrice = $this->getNewPrice($valueElement['options']['priceBitrix']['idBitrix']);
                                    $valueElement['options']['priceBitrix']['price'] = $newPrice;
                                }else if($valueElement['settings']['name'] == Loc::getMessage("skyweb24.interactivepictures_JS_TOOLTIP_ELEMENT_BITRIX_PROPS")){
                                    $valueElement['options']['propsBitrix']['idBitrix'] = $bitrixElementId;
                                    $newProps = $this->getNewProps($valueElement['options']['propsBitrix']['idBitrix'], $valueElement['options']['propsBitrix']['typeProps']);
                                    $valueElement['options']['propsBitrix']['typeProps'] = $newProps;
                                }
                            }
                        }
                        else{
                            unset($containers[$keyContainer]);
                        }
				}
		// }
	 }
	 $settings['id']=$resultDB["id"];

		$json = \Bitrix\Main\Web\Json::encode($settings);
		if($resultDB["settings"]!=$json){
			 $DB->Query("UPDATE ".$this->tablePictures." SET settings = '"
			 .$DB->forSql($json)."' WHERE ID="
			 .$this->idPicture.";");
		 }

			return $json;
		}
}