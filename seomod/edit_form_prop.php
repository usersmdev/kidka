<?    
// ����������� �����  �������������� ��������� 
function serialize_f($IBLOCK_ID, $propertyName) {
 
	// ������� � ��������
	$arFormSettings = array(
		/*array('field',' name'), */	  
		$propertyName
    );

    // ������������
	$arFormFields = array();
    foreach ($arFormSettings as $key => $arFormFields)
    {
        $arFormItems = array();
        foreach ($arFormFields as $strFormItem) {
           $arFormItems[] = implode('--#--', $strFormItem);
		}
           $arStrFields[] = implode('--,--', $arFormItems);
    }
      $arSettings = array("tabs" => implode('--;--', $arStrFields));

    // ��������� ��������� ��� ���� ������������� ��� ������� ���������
    $rez = CUserOptions::SetOption("form", "form_element_".$IBLOCK_ID, $arSettings, $bCommon=true, $userId=false);
    if (!$rez) {
       return  $msg = "- Error<br />";
	}
}
?>