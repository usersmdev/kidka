<?php
use Rumaster\Utils\Helpers\ArrayHelper;
use Rumaster\Utils\Helpers\StringHelper;
use Rumaster\Utils\Import\Tools;
use Rumaster\Utils\Iterator\IterTools;
use rumaster\bitrix\db\SectionQuery;
use rumaster\bitrix\db\ElementQuery;
use Rumaster\Utils\Dumper;
use rumaster\Cache;

$CATALOG_IBLOCK_ID = 4;

$programs = IterTools::fromCsv($_SERVER["DOCUMENT_ROOT"].'/upload/csv/1c-export.csv', [
    'fields' => [
        'id', // Код товара
        'article', // Артикул
        'name', // Наименование товара
        'price', // Цена
        '_',
    ],
    'heading' => true,
]);
$programs = $programs->map(function($data){
    unset($data['_']);
    $data['price'] = trim($data['price']);
    $data['price'] = preg_replace('/[^\.\,\d]/', '', $data['price']);
    return $data;
});
$programs = $programs->filter(function($data){
    return !empty($data['id']);
});

$programs = $programs
    ->map(function($data){
        $data = [
            'XML_ID' => $data['id'],
            'NAME' => $data['name'],
            'PROPS' => [
                'CML2_ARTICLE' => $data['article'],
            ],
            'PRICE' => [
                'PRICE' => $data['price'],
            ],
        ];
        return $data;
    });

$programs = $programs->toArray();

$ie = Tools::importElements([
    'iblockId' => $CATALOG_IBLOCK_ID,
]);

$xmlIds = $ie->db->getKeys();

$articles = ArrayHelper::map(
    $ie->db->getList(['ID', 'NAME', 'PROPERTY_CML2_ARTICLE']),
    'ID',
    'NAME',
    'PROPERTY_CML2_ARTICLE_VALUE'
);

$i = 0;
$c = 0;
$ce = 0;
$cei = 0;
$cea = 0;
$ea = 0;
$ead = 0;
foreach($programs as &$program) {
    $program['existsId'] = !empty($program['XML_ID']) && !empty($xmlIds[$program['XML_ID']]);
    $program['id'] =  $program['existsId'] ? $xmlIds[$program['XML_ID']] : null;

    $program['existsIds'] = !empty($program['PROPS']['CML2_ARTICLE']) && !empty($articles[$program['PROPS']['CML2_ARTICLE']]);
    $program['ids'] =  $program['existsIds'] ? $articles[$program['PROPS']['CML2_ARTICLE']] : [];

    $program['existsAny'] = !empty($program['existsId']) || !empty($program['existsIds']);
    $program['dublicateArticles'] = count($program['ids']) > 1;

    $program['skipImport'] = !$program['existsAny'] || $program['dublicateArticles']; 

    $c++;
    $ce += $program['existsAny'];
    $cei += $program['existsId'];
    $cea += $program['existsIds'];
    
    $ea += empty($program['PROPS']['CML2_ARTICLE']);
    $ead += $program['dublicateArticles'];

    $cee += $program['skipImport'];
}
unset($program);