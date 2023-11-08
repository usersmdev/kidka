
<?php
use Bitrix\Sale\Internals\CollectableEntity;
use Bitrix\Sale\Internals\PersonTypeTable;
use Bitrix\Sale\ShipmentCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Order;

Loc::loadMessages(__FILE__);

class tanaiska extends Bitrix\Sale\Delivery\Restrictions\Base
{
   /**
    * @param $personTypeId
    * @param array $params
    * @param int $deliveryId
    * @return bool
    */
   public static function check($usergroupId, array $params, $deliveryId = 0)
   {
      if (is_array($params) && isset($params['USER_GROUP_ID']))
      {
         return sizeof(array_intersect($usergroupId, $params['USER_GROUP_ID']))>0;
      }

      return true;
   }

   /**
    * @param CollectableEntity $entity
    * @return int
    */
   public static function extractParams(CollectableEntity $entity)
   {
      /** @var ShipmentCollection $collection */
      $collection = $entity->getCollection();

      /** @var Order $order */
      $order = $collection->getOrder();
        if($GLOBALS['USER']->isAuthorized()){
            $usergroupId=$GLOBALS['USER']->GetUserGroupArray();
        }else
            $usergroupId=array(2);
    return $usergroupId;
   }

   /**
    * @return mixed
    */
   public static function getClassTitle()
   {
      return 'Tanaiska - по образцам';
   }

   /**
    * @return mixed
    */
   public static function getClassDescription()
   {
      return 'Tanaiska - по образцам - описание';
   }

   /**
    * @param $deliveryId
    * @return array
    * @throws \Bitrix\Main\ArgumentException
    */
   public static function getParamsStructure($deliveryId = 0)
   {
     
   }

   /**
    * @param $mode
    * @return int
    */
   public static function getSeverity($mode)
   {
      return \Bitrix\Sale\Delivery\Restrictions\Manager::SEVERITY_STRICT;
   }
}
 