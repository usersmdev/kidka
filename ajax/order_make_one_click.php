<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;

use Bitrix\Main,    
    Bitrix\Main\Localization\Loc as Loc,    
    Bitrix\Main\Loader,    
    Bitrix\Main\Config\Option,    
    Bitrix\Sale\Delivery,    
    Bitrix\Sale\PaySystem,    
    Bitrix\Sale,    
    Bitrix\Sale\Order,    
    Bitrix\Sale\DiscountCouponsManager,    
    Bitrix\Main\Context;
    

if (!Loader::IncludeModule('sale') || (!isset($_GET["fio"]) || !isset($_GET["phone"])))
    die();

function getPropertyByCode($propertyCollection, $code)  {
    foreach ($propertyCollection as $property)
    {
        if($property->getField('CODE') == $code)
            return $property;
    }
}

$siteId = \Bitrix\Main\Context::getCurrent()->getSite();

$fio = htmlspecialcharsbx($_GET["fio"]);
$phone = htmlspecialcharsbx($_GET["phone"]);;
$email = htmlspecialcharsbx($_GET["email"]);;

$currencyCode = Option::get('sale', 'default_currency', 'RUB');

DiscountCouponsManager::init();

$comment = "Оформление заказа в 1 клик";

if(isset($_GET["pid"]) && $_GET["pid"] > 0) {
    \CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
    Add2BasketByProductID($_GET["pid"]);
    $comment = "Покупка товара в 1 клик";
}


$cntBasketItems = CSaleBasket::GetList(
    array(),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    array()
);

if ($cntBasketItems === 0) {
    die();
}

$order = Order::create($siteId, \CSaleUser::GetAnonymousUserID());

$order->setPersonTypeId(1);
$basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->getOrderableItems();

$order->setBasket($basket);

/*Shipment*/
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$shipmentItemCollection = $shipment->getShipmentItemCollection();
$shipment->setField('CURRENCY', $order->getCurrency());
foreach ($order->getBasket() as $item)
{
    $shipmentItem = $shipmentItemCollection->createItem($item);
    $shipmentItem->setQuantity($item->getQuantity());
}
$arDeliveryServiceAll = Delivery\Services\Manager::getRestrictedObjectsList($shipment);
$shipmentCollection = $shipment->getCollection();

if (!empty($arDeliveryServiceAll)) {
    reset($arDeliveryServiceAll);
    $deliveryObj = current($arDeliveryServiceAll);

    if ($deliveryObj->isProfile()) {
        $name = $deliveryObj->getNameWithParent();
    } else {
        $name = $deliveryObj->getName();
    }

    $shipment->setFields(array(
        'DELIVERY_ID' => $deliveryObj->getId(),
        'DELIVERY_NAME' => $name,
        'CURRENCY' => $order->getCurrency()
    ));

    $shipmentCollection->calculateDelivery();
}


/*Payment*/
$arPaySystemServiceAll = [];
$paySystemId = 3;
$paymentCollection = $order->getPaymentCollection();

$remainingSum = $order->getPrice() - $paymentCollection->getSum();
if ($remainingSum > 0 || $order->getPrice() == 0)
{
    $extPayment = $paymentCollection->createItem();
    $extPayment->setField('SUM', $remainingSum);
    $arPaySystemServices = PaySystem\Manager::getListWithRestrictions($extPayment);

    $arPaySystemServiceAll += $arPaySystemServices;

    if (array_key_exists($paySystemId, $arPaySystemServiceAll))
    {
        $arPaySystem = $arPaySystemServiceAll[$paySystemId];
    }
    else
    {
        reset($arPaySystemServiceAll);

        $arPaySystem = current($arPaySystemServiceAll);
    }

    if (!empty($arPaySystem))
    {
        $extPayment->setFields(array(
            'PAY_SYSTEM_ID' => $arPaySystem["ID"],
            'PAY_SYSTEM_NAME' => $arPaySystem["NAME"]
        ));
    }
    else
        $extPayment->delete();
}


$order->doFinalAction(true);
$propertyCollection = $order->getPropertyCollection();

if($email) {
    $emailProperty = getPropertyByCode($propertyCollection, 'EMAIL');
    $emailProperty->setValue($email);
}

$phoneProperty = getPropertyByCode($propertyCollection, 'F_PHONE');
$phoneProperty->setValue($phone);

$phoneProperty = getPropertyByCode($propertyCollection, 'NAME');
$phoneProperty->setValue($fio);


$order->setField('CURRENCY', $currencyCode);

//Комментарий покупателя
$order->setField('USER_DESCRIPTION', $comment);

$order->save();

$orderId = $order->GetId();

header("Location: /personal/order/make/?OC_ORDER_ID=" . $orderId);