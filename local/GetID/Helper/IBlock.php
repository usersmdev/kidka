<?php

namespace GetID\Helper;

use \Bitrix\Iblock\IblockTable;
use \Bitrix\Main\Loader;

Loader::IncludeModule('iblock');

class IBlock
{
    /**
     * Получает информацию об инфоблоке по его символьному коду (результат кешируются)
     * @param string $iBlockCode
     * @return array
     */
    public static function getInfoByCodeCache(string $iBlockCode): array
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance(); // получаем экземпляр класса
        if ($cache->initCache(36000000, 'get_info_by_code' . $iBlockCode)) { // проверяем кеш и задаём настройки
            $resIBlock = $cache->getVars(); // достаем переменные из кеша
        } elseif ($cache->startDataCache()) {
            $resIBlock = IblockTable::getList([
                'filter' => [
                    'CODE' => $iBlockCode,
                ],
                'select' => [
                    'IBLOCK_' => '*',
                ],
            ])->Fetch();
            $cache->endDataCache($resIBlock); // записываем в кеш
        }

        if ($resIBlock) {
            $res = $resIBlock;
        } else {
            $res['ERROR'] = 'Инфоблок не найден';
        }

        return $res;
    }

    /**
     * Получает информацию о инфоблоке по его ID
     * @param string $iBlockId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getInfoById(string $iBlockId): array
    {
        $resIBlock = IblockTable::getList([
            'filter' => [
                'ID' => $iBlockId,
            ],
            'select' => [
                'IBLOCK_' => '*',
            ],
        ])->Fetch();

        if ($resIBlock) {
            $res = $resIBlock;
        } else {
            $res['ERROR'] = 'Инфоблок не найден';
        }

        return $res;
    }

    /**
     * Получает все свойства инфоблока по его ID
     * @param string $iBlockID
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getPropertyById(string $iBlockID): array
    {
        $rsProperty = \Bitrix\Iblock\PropertyTable::getList([
            'filter' => [
                'IBLOCK_ID' => $iBlockID,
                'ACTIVE' => 'Y',
            ],
            'cache' => [
                'ttl' => 3600,
                'cache_joins' => true,
            ],
        ]);

        $res = [];
        while($prop = $rsProperty->fetch()) {
            $res[$prop['CODE']] = $prop;
        }

        if ($res) {
            return $res;
        } else {
            return ['ERROR' => 'Свойства не найдены'];
        }
    }
    public static function GetFormByCode(string $code): string{
        $rsForm = \CForm::GetBySID($code);
        $arForm = $rsForm->Fetch();
        if($arForm['ID']){
            return $arForm['ID'];
        }else{
            return 'Форма не найдена';
        }

    }
}
