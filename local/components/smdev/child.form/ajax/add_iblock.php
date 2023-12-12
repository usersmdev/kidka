<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); // это подключаем если код ниже будет исполняться в отдельном файле php



CModule::IncludeModule('iblock');  // это подключит нужный класс для работы с инфоблоком
$data = json_decode($_POST['data']);
$result = true;
foreach ($data as $value){
    if ($value->input->name && is_array($value->checkbox)) {
        //Запись в инфоблок
        $el = new CIBlockElement;
        $PROP = [
            'USER' => $GLOBALS['USER']->GetID(),
            'SERVICE' => $value->checkbox,
            'TEST' => 'test1'
        ];
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(), // элемент изменен текущим пользователем
            'IBLOCK_SECTION_ID' => false, // элемент лежит в корне раздела
            'IBLOCK_ID' => 84,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $value->input->name,
            'ACTIVE' => 'Y', // активен
            'PREVIEW_TEXT' => 'текст для списка элементов',
            'DETAIL_TEXT' => 'текст для детального просмотра',
            'DETAIL_PICTURE' => $_FILES['DETAIL_PICTURE'] // картинка, загружаемая из файлового поля веб-формы с именем DETAIL_PICTURE
        );
        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            $result = false;
        } else {
            $result = 'Error: ' . $el->LAST_ERROR;
        }
    }
}
echo json_encode($result);



