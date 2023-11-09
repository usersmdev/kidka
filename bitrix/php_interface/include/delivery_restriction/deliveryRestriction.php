<?
	namespace Tns;

	\Bitrix\Main\Loader::includeModule("iblock");

	class deliveryRestriction extends \Bitrix\Sale\Delivery\Restrictions\Base {

		const CATALOG_IBLOCK_ID = 4;
		const CATALOG_SAMPLE_SECTION_ID = 352;

		public static function getClassTitle() {
	        return "по наличию образца";
	    }

	    public static function getClassDescription() {
	        return "Ограничение по наличию образца в заказе";
	    }

	    protected static function extractParams(\Bitrix\Sale\Internals\Entity $shipment) {

	    	foreach ($shipment->getShipmentItemCollection() as $shipmentItem) {
 
    	    	$basketItem = $shipmentItem->getBasketItem();

    	       	$dbItems = \Bitrix\Iblock\ElementTable::getList(array(
    	        	"select" => array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID"),
    	        	"filter" => array("IBLOCK_ID" => self::CATALOG_IBLOCK_ID, "ID" => $basketItem->getProductId())
    	        ));

    	        if($arItem = $dbItems->Fetch()) {
    	        	if($arItem["IBLOCK_SECTION_ID"] == self::CATALOG_SAMPLE_SECTION_ID) {
    	        		return array(
    	        			"ISSET_SAMPLE" => true
    	        		);
    	        	}
    	        }   
    
    	    }

            return null;
        }

        public static function getParamsStructure($deliveryId = 0) {
            return array();
        }

        public static function check($shipmentParams, array $restrictionParams, $deliveryId = 0) {
        	return isset($shipmentParams["ISSET_SAMPLE"]);
        }


	}

?>