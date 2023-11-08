<?php
use Rumaster\Utils\Helpers\ArrayHelper;
use Rumaster\Utils\Helpers\StringHelper;
use Rumaster\Utils\Import\Tools;
use Rumaster\Utils\Iterator\IterTools;
use rumaster\bitrix\db\SectionQuery;
use rumaster\bitrix\db\ElementQuery;
use Rumaster\Utils\Dumper;
use rumaster\Cache;
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
$pcall = \CIblockElement::GetList([], ['IBLOCK_ID' => $CATALOG_IBLOCK_ID], true);
$pc = count($oldPrices);
$pu = 0;
$pue = 0;
foreach($programs as &$program) {
    if ($program['skipImport']) {
        continue;
    }
    $ids = $articles[$program['PROPS']['CML2_ARTICLE']];
    reset($ids);

    $dbId = key($ids);
    $dbPrice = array_key_exists($dbId, $oldPrices) ? $oldPrices[$dbId] : false;

    // Если на найден код товара или цена не надо ничего загружать
    if (empty($dbId) || ($dbPrice === false)) {
        $program['errorPriceUpdate'] = true;
        continue;
    }

    $equalPrice = $dbPrice['PRICE'] == $program['PRICE']['PRICE'];
    
    // Если цена не изменилась ничего не надо менять
    if ($equalPrice) {
        $program['skipUpdate'] = true;
        $pue++;
        continue;
    }
    $program['futureUpdate'] = true;
    $pu++;
}
unset($program);
?>
<style>
.dm_text tbody tr.warning td,
.dm_text tbody tr.warning:nth-child(even) td {
    border-color: #ffdf7e;
    background-color: #ffeeba;
}
.dm_text tbody tr.warning:nth-child(even) td {
    border-color: #ffdf7e;
}
.dm_text tbody tr.danger td,
.dm_text tbody tr.danger:nth-child(even) td {
    border-color: #ed969e;
    background-color: #f5c6cb;
}
.dm_text tbody tr.danger:nth-child(even) td {
    background-color: #f5c6cb;
}
.dm_text tbody tr.success td,
.dm_text tbody tr.success:nth-child(even) td {
    border-color: #8fd19e;
    background-color: #c3e6cb;
}
.dm_text tbody tr.success:nth-child(even) td {
    background-color: #c3e6cb;
}
.text-success {
    color: #28a745!important;
}
.text-danger {
    color: #dc3545!important;
}
.text-warning {
    color: #ffc107!important;
}
</style>
<?
// $maxRows = 50;
?>
Статистика:<br>
Всего товаров в csv: <?= $c ?><br>
Найдено соответствие в бд: <?= $ce ?><br>
Найдено соответствие по артикулу: <?= $cea ?><br>
Найдено соответствие по внешнему коду: <?= $cei ?><br>

<br>
Ошибки:<br>
Одинаковые артикулы: <?= $ea ?> из <?= $c ?><br>
Без артикула: <?= $ead ?> из <?= $c ?><br>
Не найдено соответствие в бд: <?= $c - $ce ?> из <?= $c ?><br>
Товаров в выгрузке не загрузятся: <?= $cee ?> из <?= $c ?><br>

<br>
Итого:<br>
Всего товаров на сайте — <?= $pcall ?><br>
Всего активных товаров на сайте — <?= $pc ?><br>
Успешно обновятся цены у товаров — <?= $pu ?> из <?= $pc ?><br>
Цена не изменилась у товаров — <?= $pue ?> из <?= $pc ?><br>

<br>
Информация предудыщего импорта:<br>
<?= nl2br(file_get_contents(__DIR__.'/last-import.txt')) ?>
Дата загрузки csv: <?= date('d.m.Y H:i:s', filemtime($_SERVER['DOCUMENT_ROOT'].'/upload/csv/1c-export.csv')) ?>
<br>
<a href="?download=yes" download="import_analize.xls">Скачать таблицу</a>
<?
$downloadAnalize = !empty($_REQUEST['download']) && ($_REQUEST['download'] == 'yes');
if ($downloadAnalize) {
    $APPLICATION->RestartBuffer();
}
?>
<table>
    <tr>
        <th>Код товара</th>
        <th>Название</th>
        <th>Артикул</th>
        <th>Цена</th>
        <th>Состояние</th>
        <th>Товара на сайте</th>
    </tr>
    <? foreach($programs as $program): ?>
        <?
        $existsId = $program['existsId'];
        $id = $program['id'];
        $existsIds = $program['existsIds'];
        $ids = $program['ids'];

        $rowClass = '';
        if (!$program['skipImport']) {
            $rowClass .= 'success';
        }
        else {
            $rowClass .= 'warning';
        }

        $emptyArticle = empty($program['PROPS']['CML2_ARTICLE']);
        ?>
        <tr class="<?= $rowClass ?>">
            <td title="<?= $program['XML_ID'] ?>"><?= StringHelper::truncate($program['XML_ID'], 30) ?></td>
            <td title="<?= $program['NAME'] ?>"><?= StringHelper::truncate($program['NAME'], 50) ?></td>
            <td><?= $program['PROPS']['CML2_ARTICLE'] ?></td>
            <td><?= $program['PRICE']['PRICE'] ?></td>
            <td>
                <?//= $existsId ? "db-id: {$id}" : '<span class="text-danger">не найден товар по внешнему коду</span>' ?>
                <!-- <br> -->
                <? if ($emptyArticle): ?>
                    <span class="text-danger">Без артикула</span><br>
                <? elseif ($program['dublicateArticles']): ?>
                    <span class="text-danger">Одинаковые артикулы</span><br>
                <? elseif (!$existsIds): ?>
                    <span class="text-danger">Не найден товар по артикулу</span>
                <? elseif (!empty($program['errorPriceUpdate'])): ?>
                    <span title="Цена для не будет меняться из за нективности товара или отсутствия цены на сайте">
                        Цена не будет меняться *
                    </span>
                <? elseif (!empty($program['skipUpdate'])): ?>
                    Цена не изменилась
                <? elseif (!empty($program['futureUpdate'])): ?>
                    Цена будет изменена
                <? else: ?>
                    Неопределенное состояние
                <? endif; ?>
            </td>
            <td>
                <? if ($existsIds): ?>
                    <? foreach($ids as $id=>$name): ?>
                        [<?= $id ?>] <?= $name ?> / <?= $oldPrices[$id]['PRICE'] ?><br>
                    <? endforeach; ?>
                <? endif; ?>
            </td>
        </tr>
        <?
        $i++;
        if ($maxRows && ($i>=$maxRows)) {
            break;
        }
        ?>
    <? endforeach; ?>
</table>
<?
if ($downloadAnalize) {
    CMain::EpilogActions();
}
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


