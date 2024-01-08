<?php

namespace Sprint\Migration;


class getInformation20240108141630 extends Version
{
    protected $description = "";

    protected $moduleVersion = "4.6.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $formHelper = $helper->Form();
        $formId = $formHelper->saveForm(array (
  'NAME' => 'Запросить больше информации',
  'SID' => 'GetInformation',
  'BUTTON' => 'Отправить',
  'C_SORT' => '1100',
  'FIRST_SITE_ID' => NULL,
  'IMAGE_ID' => NULL,
  'USE_CAPTCHA' => 'N',
  'DESCRIPTION' => '',
  'DESCRIPTION_TYPE' => 'text',
  'FORM_TEMPLATE' => '',
  'USE_DEFAULT_TEMPLATE' => 'Y',
  'SHOW_TEMPLATE' => NULL,
  'MAIL_EVENT_TYPE' => 'FORM_FILLING_GetInformation',
  'SHOW_RESULT_TEMPLATE' => NULL,
  'PRINT_RESULT_TEMPLATE' => NULL,
  'EDIT_RESULT_TEMPLATE' => NULL,
  'FILTER_RESULT_TEMPLATE' => '',
  'TABLE_RESULT_TEMPLATE' => '',
  'USE_RESTRICTIONS' => 'N',
  'RESTRICT_USER' => '0',
  'RESTRICT_TIME' => '0',
  'RESTRICT_STATUS' => '',
  'STAT_EVENT1' => 'form',
  'STAT_EVENT2' => 'getinformation',
  'STAT_EVENT3' => '',
  'LID' => NULL,
  'C_FIELDS' => '0',
  'QUESTIONS' => '2',
  'STATUSES' => '1',
  'arSITE' => 
  array (
    0 => 's1',
  ),
  'arMENU' => 
  array (
    'ru' => 'Запросить больше информации',
    'en' => '',
  ),
  'arGROUP' => 
  array (
    'everyone' => '10',
  ),
  'arMAIL_TEMPLATE' => 
  array (
    0 => 
    array (
      'EVENT_NAME' => 'FORM_FILLING_GetInformation',
      'SUBJECT' => '#SERVER_NAME#: заполнена web-форма [#RS_FORM_ID#] #RS_FORM_NAME#',
    ),
  ),
));
        $formHelper->saveStatuses($formId, array (
  0 => 
  array (
    'CSS' => 'statusgreen',
    'C_SORT' => '100',
    'ACTIVE' => 'Y',
    'TITLE' => 'DEFAULT',
    'DESCRIPTION' => 'DEFAULT',
    'DEFAULT_VALUE' => 'Y',
    'HANDLER_OUT' => '',
    'HANDLER_IN' => '',
  ),
));
        $formHelper->saveFields($formId, array (
  0 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Ваше имя',
    'TITLE_TYPE' => 'text',
    'SID' => 'CLIENT_NAME',
    'C_SORT' => '100',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'N',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => '',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => '',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
  1 => 
  array (
    'ACTIVE' => 'Y',
    'TITLE' => 'Телефон',
    'TITLE_TYPE' => 'text',
    'SID' => 'PHONE',
    'C_SORT' => '200',
    'ADDITIONAL' => 'N',
    'REQUIRED' => 'Y',
    'IN_FILTER' => 'N',
    'IN_RESULTS_TABLE' => 'N',
    'IN_EXCEL_TABLE' => 'Y',
    'FIELD_TYPE' => '',
    'IMAGE_ID' => NULL,
    'COMMENTS' => '',
    'FILTER_TITLE' => '',
    'RESULTS_TABLE_TITLE' => '',
    'ANSWERS' => 
    array (
      0 => 
      array (
        'MESSAGE' => ' ',
        'VALUE' => '',
        'FIELD_TYPE' => 'text',
        'FIELD_WIDTH' => '0',
        'FIELD_HEIGHT' => '0',
        'FIELD_PARAM' => 'class="phone"',
        'C_SORT' => '100',
        'ACTIVE' => 'Y',
      ),
    ),
    'VALIDATORS' => 
    array (
    ),
  ),
));
    }

    public function down()
    {
        //your code ...
    }
}

