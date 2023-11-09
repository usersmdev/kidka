<?php

namespace Sprint\Migration;


class no_active_product20231109162332 extends Version
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
        $iblockId = $helper->Iblock()->saveIblock(array (
  'IBLOCK_TYPE_ID' => 'aspro_max_catalog',
  'LID' => 
  array (
    0 => 's1',
  ),
  'CODE' => 'aspro_max_catalog',
  'API_CODE' => NULL,
  'NAME' => 'Каталог товаров',
  'ACTIVE' => 'N',
  'SORT' => '100',
  'LIST_PAGE_URL' => '#SITE_DIR#products/',
  'DETAIL_PAGE_URL' => '#SITE_DIR#products/#SECTION_CODE#/#ELEMENT_CODE#/',
  'SECTION_PAGE_URL' => '#SITE_DIR#products/#SECTION_CODE#/',
  'PICTURE' => NULL,
  'DESCRIPTION' => 'Основной каталог товаров',
  'DESCRIPTION_TYPE' => 'html',
  'RSS_TTL' => '24',
  'RSS_ACTIVE' => 'Y',
  'RSS_FILE_ACTIVE' => 'N',
  'RSS_FILE_LIMIT' => NULL,
  'RSS_FILE_DAYS' => NULL,
  'RSS_YANDEX_ACTIVE' => 'N',
  'XML_ID' => 'eb9d2f3b-e61c-4472-87d8-cc6f4d068bb6',
  'INDEX_ELEMENT' => 'Y',
  'INDEX_SECTION' => 'N',
  'WORKFLOW' => 'N',
  'BIZPROC' => 'N',
  'SECTION_CHOOSER' => 'L',
  'VERSION' => '1',
  'LAST_CONV_ELEMENT' => '0',
  'EDIT_FILE_BEFORE' => '',
  'EDIT_FILE_AFTER' => '',
  'SECTIONS_NAME' => 'Разделы',
  'SECTION_NAME' => 'Раздел',
  'ELEMENTS_NAME' => 'Товары',
  'ELEMENT_NAME' => 'Товар',
  'LIST_MODE' => 'S',
  'SOCNET_GROUP_ID' => NULL,
  'RIGHTS_MODE' => 'S',
  'SECTION_PROPERTY' => 'Y',
  'PROPERTY_INDEX' => 'I',
  'CANONICAL_PAGE_URL' => 'http://#SERVER_NAME##SITE_DIR#products/#SECTION_CODE#/#ELEMENT_CODE#/',
  'REST_ON' => 'N',
  'EXTERNAL_ID' => 'eb9d2f3b-e61c-4472-87d8-cc6f4d068bb6',
  'LANG_DIR' => '/',
  'IPROPERTY_TEMPLATES' => 
  array (
    'SECTION_PAGE_TITLE' => '{=this.Name}',
    'SECTION_META_TITLE' => '{=this.Name}',
    'ELEMENT_PAGE_TITLE' => '{=this.Name}',
    'ELEMENT_META_TITLE' => 'Купить {=this.Name} по ценам производителя в Москве',
    'ELEMENT_META_KEYWORDS' => 'Каталог компании DECOMASTER: {=this.Name} - купить по ценам производителя, с доставкой по Москве, Санкт-Петербургу и в другие регионы.',
  ),
  'ELEMENT_ADD' => 'Добавить товар',
  'ELEMENT_EDIT' => 'Изменить товар',
  'ELEMENT_DELETE' => 'Удалить товар',
  'SECTION_ADD' => 'Добавить раздел',
  'SECTION_EDIT' => 'Изменить раздел',
  'SECTION_DELETE' => 'Удалить раздел',
));

    }

    public function down()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->saveIblock(array (
            'IBLOCK_TYPE_ID' => 'aspro_max_catalog',
            'LID' =>
                array (
                    0 => 's1',
                ),
            'CODE' => 'aspro_max_catalog',
            'API_CODE' => NULL,
            'NAME' => 'Каталог товаров',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'LIST_PAGE_URL' => '#SITE_DIR#products/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#products/#SECTION_CODE#/#ELEMENT_CODE#/',
            'SECTION_PAGE_URL' => '#SITE_DIR#products/#SECTION_CODE#/',
            'PICTURE' => NULL,
            'DESCRIPTION' => 'Основной каталог товаров',
            'DESCRIPTION_TYPE' => 'html',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'Y',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => NULL,
            'RSS_FILE_DAYS' => NULL,
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => 'eb9d2f3b-e61c-4472-87d8-cc6f4d068bb6',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'N',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'VERSION' => '1',
            'LAST_CONV_ELEMENT' => '0',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Товары',
            'ELEMENT_NAME' => 'Товар',
            'LIST_MODE' => 'S',
            'SOCNET_GROUP_ID' => NULL,
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'Y',
            'PROPERTY_INDEX' => 'I',
            'CANONICAL_PAGE_URL' => 'http://#SERVER_NAME##SITE_DIR#products/#SECTION_CODE#/#ELEMENT_CODE#/',
            'REST_ON' => 'N',
            'EXTERNAL_ID' => 'eb9d2f3b-e61c-4472-87d8-cc6f4d068bb6',
            'LANG_DIR' => '/',
            'IPROPERTY_TEMPLATES' =>
                array (
                    'SECTION_PAGE_TITLE' => '{=this.Name}',
                    'SECTION_META_TITLE' => '{=this.Name}',
                    'ELEMENT_PAGE_TITLE' => '{=this.Name}',
                    'ELEMENT_META_TITLE' => 'Купить {=this.Name} по ценам производителя в Москве',
                    'ELEMENT_META_KEYWORDS' => 'Каталог компании DECOMASTER: {=this.Name} - купить по ценам производителя, с доставкой по Москве, Санкт-Петербургу и в другие регионы.',
                ),
            'ELEMENT_ADD' => 'Добавить товар',
            'ELEMENT_EDIT' => 'Изменить товар',
            'ELEMENT_DELETE' => 'Удалить товар',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ));
    }
}
