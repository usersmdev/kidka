<?php

AddEventHandler('form', 'onAfterResultAdd', ['WebFormEventHandler', 'onAfterResultAdd']);

class WebFormEventHandler {
    public static function getResultFields($resultId)
    {
        $arAnswer = CFormResult::GetDataByID(
            $resultId,
            array(),
            $arResult,
            $arAnswer2
        );
        $fields = [];
        foreach ($arAnswer as $_field) {
            $field = reset($_field);
            $fieldData = [
                'FIELD_ID' => $field['FIELD_ID'],
                'FIELD_TYPE' => $field['FIELD_TYPE'],
                'CODE' => $field['SID'],
                'NAME' => $field['TITLE'],
                'VALUE' => !empty($field['ANSWER_TEXT']) ? $field['ANSWER_TEXT'] : $field['USER_TEXT'],
            ];
            if (!empty($field['USER_FILE_ID'])) {
                if (count($_field) > 1) {
                    foreach ($_field as $__field) {
                        $fieldData['FILE_MULTY'][] = [
                            'USER_FILE_ID' => $__field['USER_FILE_ID'],
                            'USER_FILE_NAME' => $__field['USER_FILE_NAME'],
                            'USER_FILE_IS_IMAGE' => $__field['USER_FILE_IS_IMAGE'],
                            'USER_FILE_HASH' => $__field['USER_FILE_HASH'],
                            'USER_FILE_SUFFIX' => $__field['USER_FILE_SUFFIX'],
                            'USER_FILE_SIZE' => $__field['USER_FILE_SIZE'],
                        ];
                    }
                } else {
                    $fieldData['FILE'] = [
                        'USER_FILE_ID' => $field['USER_FILE_ID'],
                        'USER_FILE_NAME' => $field['USER_FILE_NAME'],
                        'USER_FILE_IS_IMAGE' => $field['USER_FILE_IS_IMAGE'],
                        'USER_FILE_HASH' => $field['USER_FILE_HASH'],
                        'USER_FILE_SUFFIX' => $field['USER_FILE_SUFFIX'],
                        'USER_FILE_SIZE' => $field['USER_FILE_SIZE'],
                    ];
                }
            }
            if (count($_field) > 1) {
                foreach ($_field as $__field) {
                    $fieldData['ALL_ANSWER_IDS'][] = $__field['ANSWER_ID'];
                }
            }
            // $fieldData['RAW'] = $_field;
            $fields[] = $fieldData;
        }
        $result = [
            'RS_FORM_ID' => $arResult['FORM_ID'],
            'RS_FORM_NAME' => $arResult['NAME'],
            'RS_FORM_SID' => $arResult['SID'],
            'RS_RESULT_ID' => $arResult['ID'],
            'RS_DATE_CREATE' => $arResult['DATE_CREATE'],
            'RS_USER_ID' => $arResult['USER_ID'],
            'RS_USER_AUTH' => $arResult['USER_AUTH'],
            'RS_STAT_GUEST_ID' => $arResult['STAT_GUEST_ID'],
            'RS_STAT_SESSION_ID' => $arResult['STAT_SESSION_ID'],
            'RS_USER_EMAIL' => null,
            'RS_USER_NAME' => null,
            'ROISTAT' => null,
        ];
        foreach ($fields as $field) {
            $result[$field['CODE']] = $field;//['VALUE'];
        }
        $result['RS_FIELDS'] = $fields;
        return $result;
    }

    public static function log($data)
    {
        $content = print_r($data, true);
        file_put_contents(__DIR__ . '/WebFormEventHandler.log', $content . "\n", FILE_APPEND);
    }

    public static function onAfterResultAdd($webFormId, $resultId)
    {
        if (!in_array($webFormId, [8,9])) {
            return;
        }
        if (!CModule::IncludeModule('form') || !CModule::IncludeModule('rumaster.utils')) {
            return;
        }

        $result = static::getResultFields($resultId);
        // static::log([
        //    'onAfterResultAdd',
        //    'result' => $result,
        // ]);

        foreach($result as $fieldCode => $field) {
            if (!\rumaster\helpers\StringHelper::endsWith($fieldCode, '_FILE')) {
                continue;
            }
            if (empty($result[$fieldCode]['FILE']['USER_FILE_ID']) && empty($result[$fieldCode]['FILE_MULTY'][0]['USER_FILE_ID'])) {
                continue;
            }
            if (empty($result[$fieldCode.'_LINK']['FIELD_ID'])) {
                continue;
            }
            if (!empty($result[$fieldCode . '_LINK']['ALL_ANSWER_IDS'])) {
                $files = !empty($result[$fieldCode]['FILE_MULTY'])
                    ? $result[$fieldCode]['FILE_MULTY']
                    : [$result[$fieldCode]['FILE']];

                $updateFieldId = $result[$fieldCode . '_LINK']['FIELD_ID'];
                $links = [];
                foreach ($files as $file) {
                    $link = $file
                        ? "https://decomaster.su/bitrix/tools/form_show_file.php?rid={$resultId}&hash={$file['USER_FILE_HASH']}&lang=ru"
                        : '';
                    if (!empty($file['USER_FILE_ID'])) {
                        $arFile = \CFile::GetFileArray($file['USER_FILE_ID']);
                        $link = "https://decomaster.su".$arFile['SRC'];
                    }
                    $links[] = $link;
                }
                // static::log([
                //     'onAfterResultAdd',
                //     'files' => $files,
                //     'links' => $links,
                // ]);
                foreach ($result[$fieldCode . '_LINK']['ALL_ANSWER_IDS'] as $k=>$updateAnswerId) {
                    $link = !empty($links[$k]) ? $links[$k] : '';
                    static::updateFormResultFieldAnser([
                        'USER_TEXT' => $link,
                        'USER_TEXT_SEARCH' => $link,
                    ], $resultId, $updateFieldId, $updateAnswerId);
                }
            }
            else {
                $file = $result[$fieldCode]['FILE'];
                $link = $file
                    ? "https://decomaster.su/bitrix/tools/form_show_file.php?rid={$resultId}&hash={$file['USER_FILE_HASH']}&lang=ru"
                    : '';
                $updateFieldId = $result[$fieldCode.'_LINK']['FIELD_ID'];
                CFormResult::UpdateField([
                    'USER_TEXT' => $link,
                    'USER_TEXT_SEARCH' => $link
                ], $resultId, $updateFieldId);
            }
        }

        if (!empty($result['CONTRACT_LINK']['FIELD_ID']))
        {
            $link = '';
            if ($webFormId == 8) {
                $link = 'https://decomaster.su/montageform/?result_id=' . $resultId;
            }
            if ($webFormId == 9) {
                $link = 'https://decomaster.su/designform/?result_id=' . $resultId;
            }

            $updateFieldId = $result['CONTRACT_LINK']['FIELD_ID'];
            CFormResult::UpdateField([
                'USER_TEXT' => $link,
                'USER_TEXT_SEARCH' => $link
            ], $resultId, $updateFieldId);
        }
        

        // if (!empty($result['OBJECT_DESIGN_PROJECT_FILE']['FILE']['USER_FILE_ID'])
        //     && !empty($result['OBJECT_DESIGN_PROJECT_FILE_LINK']['FIELD_ID']))
        // {
        //     $file = $result['OBJECT_DESIGN_PROJECT_FILE']['FILE'];
        //     $link = "https://decomaster.su/bitrix/tools/form_show_file.php?rid={$resultId}&hash={$file['USER_FILE_HASH']}&lang=ru";
        //     $updateFieldId = $result['OBJECT_DESIGN_PROJECT_FILE_LINK']['FIELD_ID'];
        //     CFormResult::UpdateField([
        //         'USER_TEXT' => $link,
        //         'USER_TEXT_SEARCH' => $link
        //     ], $resultId, $updateFieldId);
        // }
    }

    public static function updateFormResultFieldAnser($arFields, $RESULT_ID, $FIELD_ID, $ANSWER_ID)
    {
        $err_mess = (CFormResult::err_mess()) . "<br>Function: UpdateField<br>Line: ";
        global $DB, $strError;
        $RESULT_ID = intval($RESULT_ID);
        $FIELD_ID = intval($FIELD_ID);
        $strUpdate = $DB->PrepareUpdate("b_form_result_answer", $arFields, "form");
        $strSql = "UPDATE b_form_result_answer SET " . $strUpdate . " WHERE RESULT_ID=" . $RESULT_ID . " and FIELD_ID=" . $FIELD_ID . " AND ANSWER_ID=" . $ANSWER_ID;
        $DB->Query($strSql, false, $err_mess . __LINE__);
    }
}