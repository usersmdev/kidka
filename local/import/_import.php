<?php
use Rumaster\Utils\Helpers\ArrayHelper;
use Rumaster\Utils\Helpers\StringHelper;
use Rumaster\Utils\Import\Tools;
use Rumaster\Utils\Iterator\IterTools;
use rumaster\bitrix\db\SectionQuery;
use rumaster\bitrix\db\ElementQuery;
use Rumaster\Utils\Dumper;
use rumaster\Cache;

// $ie->set($programs)->run();

?>
<?
$oldPrices = [];
$r = \CIblockElement::GetList([], ['ACTIVE' => 'Y', 'IBLOCK_ID' => $CATALOG_IBLOCK_ID], false, false, ['ID', 'ACTIVE']);
while($row = $r->Fetch()) {
    $oldPrices[$row['ID']] = [
        'PRODUCT_ID' => $row['ID'],
        'PRODUCT_ACTIVE' => $row['ACTIVE'],
    ];
}
$r = \CPrice::GetList([], ['CATALOG_GROUP_ID' => 1]);
while($row = $r->Fetch()) {
    if (!array_key_exists($row['PRODUCT_ID'], $oldPrices)) {
        continue;
    }
    $newPriceData = [
        'ID' => $row['ID'],
        'PRICE' => $row['PRICE'],
    ];
    $oldPrices[$row['PRODUCT_ID']] = is_array($oldPrices[$row['PRODUCT_ID']])
        ? array_merge($oldPrices[$row['PRODUCT_ID']], $newPriceData)
        : $newPriceData;
}

$updatePrices = [];
foreach($programs as $program) {
    if ($program['skipImport']) {
        continue;
    }
    $ids = $articles[$program['PROPS']['CML2_ARTICLE']];
    reset($ids);

    $dbId = key($ids);
    $dbPrice = array_key_exists($dbId, $oldPrices) ? $oldPrices[$dbId] : false;

    // Если на найден код товара или цена не надо ничего загружать
    if (empty($dbId) || ($dbPrice === false)) {
        continue;
    }

    $updatePrice = [
        'ID' => $dbPrice['ID'],
        'PRODUCT_ID' => $dbId,
        'PRICE' => $program['PRICE']['PRICE'],
        'OLD_PRICE' => $dbPrice['PRICE'],
        'PRODUCT_ACTIVE' => $dbPrice['PRODUCT_ACTIVE'],
    ];
    $equalPrice = $dbPrice['PRICE'] == $program['PRICE']['PRICE'];
    
    // Если цена не изменилась ничего не надо менять
    if ($equalPrice) {
        continue;
    }
    $updatePrices[] = $updatePrice;
}

print_r($updatePrices);
foreach($updatePrices as $updatePrice) {
    \CPrice::Update($updatePrice['ID'], [
        'PRICE' => $updatePrice['PRICE'],
    ]);
}
/*?><pre><?print_r($oldPrices);?></pre><?*/
// $maxRows = 50;

// $programs = $programs
//     ->map(function($data){
//         $data = [
//             'XML_ID' => $data['id'],
//             'NAME' => $data['name'],
//             'IBLOCK_SECTION_ID.XML_ID' => $data['parent'],

//             'PROPS' => [
//                 'HOUR_FORM' => $data['hours'],
//                 'COST_COURSE_FORM' => $data['price'],

//                 'ARTICLE' => $data['article'],
//                 'TRAINING_TYPE' => $data['training_type'],
//                 'DOCUMENT' => $data['document'],
//                 'CURATOR' => $data['curator'],
//             ]
//         ];
//         return $data;
//     });

// $is = Tools::importSections([
//     'iblockId' => PROGRAM_IBLOCK_ID,
//     'generateEmptyCodeOnInsert' => true,
// ]);
// $is->set($groups)->run();


