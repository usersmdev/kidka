<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	if (strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 && is_numeric($_POST['element']) && is_numeric($_POST['iblock'])) {
		if (CModule::IncludeModule("iblock"))
		{
			$element = $_POST['element'];
			$name = urldecode($_POST['name']);
			$description = urldecode($_POST['description']);
			$iblock = $_POST['iblock'];
			$rank = $_POST['rank'];
			
			if ($_POST['charset'] == 'windows-1251')
			{
				$element = iconv('UTF-8', 'windows-1251', $element);
				$name = iconv('UTF-8', 'windows-1251', $name);
				$description = iconv('UTF-8', 'windows-1251', $description);
				$iblock = iconv('UTF-8', 'windows-1251', $iblock);
			}
			
			$arFields = array(
				'NAME' => $name,
				'ACTIVE' => "N",
				'PREVIEW_TEXT' => $description,
				'IBLOCK_SECTION_ID' => false,
				'IBLOCK_ID' => $iblock,
				'CODE' => Cutil::translit($name, "ru"),
				'PROPERTY_VALUES' => array(
					"REVIEW" => $element,
					"RANK" => $rank,
				)
			);
			$el = new CIBlockElement;
			$otzid = $el->Add($arFields);
			
			$arFields["RANK"] = $rank;
			$arFields["DETAIL_URL"] = 'http://'.$_SERVER['HTTP_HOST'].'/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='.$iblock.'&type=content&ID='.$otzid;
			
			CEvent::SendImmediate("REVIEW_SEND", SITE_ID, $arFields);
		}
	}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>