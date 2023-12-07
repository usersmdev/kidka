<?
include('include/debugger.php');

include(\Bitrix\Main\Application::getInstance()->getDocumentRoot() . "/vendor/autoload.php");

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/autoload.php')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/autoload.php');
}

if(file_exists($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php")) @require($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php");

CModule::AddAutoloadClasses(
	"",
	[
		"\\Tanais\\getContacts" => "/bitrix/php_interface/include/geo/contacts/geoContacts.php",
		"\\Tanais\\User" => "/bitrix/php_interface/include/lk/user.php",
		"\\Tanais\\orderHelper" => "/bitrix/php_interface/include/order/orderHelper.php",
		"\\Tanais\\orderList" => "/bitrix/php_interface/include/order/orderList.php",
	]
);

AddEventHandler("main", "OnPageStart", "TrinetSpiderAuthorize");

function TrinetSpiderAuthorize()
{
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Sokol') !== false )
	{
		if (isset($GLOBALS['USER']) && is_a($GLOBALS['USER'], 'CUser'))
		{
			$user = $GLOBALS['USER'];
		} else {
			$user = new CUser();
			$GLOBALS['USER'] = $user;
		}
		$user->Authorize(8935);
	}
}


\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "sale",
    "OnOrderNewSendEmail",
    [
    	"\\Tanais\\orderList",
    	"modifyOrderList4MailTemplate"
    ]
);


\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnBeforeUserRegister",
    "onBeforeUserRegisterHandler"
);

function onBeforeUserRegisterHandler(&$arFields) {
	if(isset($_REQUEST["user-type"]) &&
			$_REQUEST["user-type"] == "designer") {
		$arFields["ACTIVE"] = "N";
		$arFields["UF_DESIGNER"] = 1;
		return true;
	}
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "sale",
    "onSaleDeliveryRestrictionsClassNamesBuildList",
    "deliveryRestrictionEventResult"
);


\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnAfterUserRegister",
    "onAfterUserRegisterHandler"
);

function onAfterUserRegisterHandler(&$arFields) {
	session_start();
    $user = new CUser;
    $ID = $arFields["USER_ID"];
    $arrGroups_old = $user->GetUserGroupArray();
    var_dump($arrGroups_old);
    if ($arrGroups_old[0] == 2 && $_SESSION['sms_phone2'] == 1) {
        $fields = array("ACTIVE" => "Y",);
        $user->Update($ID, $fields);
        $user->Authorize($ID);
        LocalRedirect('/registratsiya/dobavit-rebenka.php');
    }


	if(isset($_REQUEST["user-type"]) &&
			$_REQUEST["user-type"] == "designer") {

		if (!empty($arFields["USER_ID"])) {
		// if($arFields["RESULT_MESSAGE"]["TYPE"] == "OK" && 
		// 		$arFields["RESULT_MESSAGE"]["ID"] > 0) {

			$_SESSION["NEW_DESIGNER_USER_ID"] = $arFields["USER_ID"];

			$ob = CUser::GetByID($arFields["USER_ID"]);
			$res = $ob->GetNext();

			$file = !empty($res['UF_DIPLOMA']) ? \CFile::GetFileArray($res['UF_DIPLOMA']) : false;
			$fileLink = $file ? 'https://decomaster.su' . $file['SRC'] : '';

			CEvent::Send("DESIGNER_REGISTRATION", SITE_ID, [
				"USER_ID" => $arFields["USER_ID"],
				"FIO" => $res["NAME"]." ".$res["LAST_NAME"],
				'PHONE' => $res['PERSONAL_PHONE'],
				'EMAIL' => $res['EMAIL'],
				'DIPLOMA_LINK' => $fileLink,
				"URL" => "https://decomaster.su/bitrix/admin/user_edit.php?lang=ru&ID=".$arFields["USER_ID"]
			]);

			$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
			LocalRedirect($request->getRequestUri());
		}
		
	}
}



function deliveryRestrictionEventResult() {
	return new \Bitrix\Main\EventResult(
        \Bitrix\Main\EventResult::SUCCESS,
        array(
            "\\Tns\\deliveryRestriction" =>
            	"/bitrix/php_interface/include/delivery_restriction/deliveryRestriction.php",
        )
    );
}

AddEventHandler("main", "OnPageStart", Array("dmClass", "OnPageStartHandler"));
AddEventHandler("main", "OnEndBufferContent", Array("dmClass", "OnEndBufferContentHandler"));
AddEventHandler("sale", "OnOrderNewSendEmail", Array("dmClass", "OnOrderNewSendEmailHandler"));

AddEventHandler('main', 'OnBeforeEventSend', 'WBLOnBeforeEventSendHandler');
function WBLOnBeforeEventSendHandler(&$arFields, &$arTemplate){

  if( $arTemplate['EVENT_NAME'] == 'SALE_NEW_ORDER'){

    $email = '';
    switch (date('w')){ // Порядковый номер дня недели
      case '1':
      case '2':
      case '3':
      case '4':
      case '5':
        $email = 'no-reply@decomaster.ru';
        break;
      case '6':
      case '0':
        $email = 'no-reply@decomaster.ru,info@decomaster.su,roomer@decomaster.su';
        break;
    }

    if( !empty($email) ){
      $arFields['EMAIL_TO'] = $email;
    }
  }
}

class dmClass
{
	static public function OnPageStartHandler()
	{
		global $APPLICATION;

		/* Mobile version detect START */
		require_once $_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/scripts/Mobile_Detect.php';

		$detect = new Mobile_Detect;
		if( ($detect->isMobile() || $detect->isTablet()) )
		{
			$APPLICATION->SetPageProperty("isMobile", true);
		}
	}

    static public function OnEndBufferContentHandler(&$content)
	{
		$content = str_replace('<i class="rub"><u>руб.</u></i>', '<i class="rub"><u><i class="rub"><u>руб.</u></i></u></i>', $content);
	}

	function OnOrderNewSendEmailHandler($ORDER_ID, &$eventName, &$arFields)
	{
	   $handle = fopen($_SERVER["DOCUMENT_ROOT"]."/.OnOrderNewSendEmailHandler.txt", "a+");
	   fputs($handle, var_export($eventName,true));
	   fputs($handle, var_export($arFields,true));
	   fclose($handle);

	   	if($arFields["ORDER_USER"])
	   	{
			$rsUser = CUser::GetByLogin($arFields["ORDER_USER"]);
			if($arUser = $rsUser->Fetch())
			{
				if(in_array(11, CUser::GetUserGroup($arUser["ID"])))
				{
					//$arFields["SALE_EMAIL"] = "";
				}
				if(in_array(12, CUser::GetUserGroup($arUser["ID"])))
				{
					//$arFields["SALE_EMAIL"] = "";
				}
			}
	   	}

		$arFields["USER_PROPS"] = "";
		$db_order = CSaleOrder::GetList(
		        array("DATE_UPDATE" => "DESC"),
		        array("ID" => $ORDER_ID)
		);
		if ($arOrder = $db_order->Fetch())
		{
			$arFields["ORDER_USER"] = "";

			$db_props = CSaleOrderProps::GetList(
			        array("SORT" => "ASC"),
			        array(
			                "PERSON_TYPE_ID" => $arOrder["PERSON_TYPE_ID"]
			                //"IS_PAYER" => "Y"
				)
			);
			while ($arProps = $db_props->Fetch())
			{
				$db_vals = CSaleOrderPropsValue::GetList(
					array("SORT" => "ASC"),
					array(
						"ORDER_ID" => $ORDER_ID,
						"ORDER_PROPS_ID" => $arProps["ID"]
					)
				);
				if ($arVals = $db_vals->Fetch())
				{
					if ($arVals["NAME"])
					{
						if ($arProps["TYPE"] == "LOCATION")
						{
							$arLocs = CSaleLocation::GetByID($arVals["VALUE"], LANGUAGE_ID);
							$arFields["ORDER_USER"] .= $arVals["NAME"].": ".$arLocs["COUNTRY_NAME"]." - ".$arLocs["CITY_NAME"]."\n";
						}elseif($arProps["TYPE"] == "RADIO" || $arProps["TYPE"] == "SELECT")
						{
							$arVal = CSaleOrderPropsVariant::GetByValue($arProps["ID"], $arVals["VALUE"]);
							$arFields["ORDER_USER"] .= $arVals["NAME"].": ".$arVal["NAME"]."\n";
						}else{
							$arFields["ORDER_USER"] .= $arVals["NAME"].": ".$arVals["VALUE"]."\n";
						}
					}
				}
			}
			$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
			if ($arDeliv)
			{
				$arFields["ORDER_USER"]  .= "Доставка: \"".$arDeliv["NAME"]."\" стоит ".CurrencyFormat($arDeliv["PRICE"], $arDeliv["CURRENCY"])."\n";

				cmodule::includemodule('sale'); 
				cmodule::includemodule('catalog');
				$order = \Bitrix\Sale\Order::Load($ORDER_ID);
				$shipcol = $order->getShipmentCollection(); 
				foreach ($shipcol as $shipment) 
				{ 
					$store_id = $shipment->getStoreId();
					if($store_id)
					{
						$rsStore = CCatalogStore::GetList(array(), array("ID" => $store_id)); 
						if($arIDStore = $rsStore->Fetch())
						{
							$arFields["ORDER_USER"] .= "Склад самовывоза: ".$arIDStore["TITLE"]."\n";
						}
					}
				}

			}
			$arPaySys = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"], $arOrder["PERSON_TYPE_ID"]);
			if ($arPaySys)
			{
				$arFields["ORDER_USER"]  .= "Платежная система: \"".$arPaySys["NAME"]."\"\n";
			}
		}
	}
}

function dmShowTitle()
{
	global $APPLICATION;

	if(
		$APPLICATION->GetCurPage() != '/index.php' && 
		$APPLICATION->GetCurPage() != '/' && 
		$APPLICATION->GetPageProperty("NOT_SHOW_TITLE") != "Y"
	){
		return '<h1>'.$APPLICATION->GetTitle(false).'</h1>';
	}
	return '';
}




/*
	AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "checkGoogleCaptcha");
	function checkGoogleCaptcha(&$arFields) {
	//	if ($arFields['IBLOCK_ID'] == 6 && $_REQUEST['iblock_submit']) { 
			global $APPLICATION;
			if ($_SESSION['g-recaptcha-response']) {
				$result = file_get_contents(
					'https://www.google.com/recaptcha/api/siteverify',
					false,
					stream_context_create(
						array(
							'http' => array(
							'method' => 'POST',
							'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
							'content' => 'secret=6Lcq1EMUAAAAAHdBTSktUV8Tnl60QC5N7yCqJFGX&response='. 
								$_SESSION['g-recaptcha-response'].'&remoteip='.$_SERVER['HTTP_X_REAL_IP'],
							),
						)
					)
				);
				$result = json_decode($result, true);
				if ($result['success'] !== true) {
					$APPLICATION->throwException("Вы не прошли проверку подтверждения личности");
					return false;
				}
			} else {
				$APPLICATION->throwException("Вы не прошли проверку подтверждения личности");
				return false;
			}
	//	} 
	}
*/	


/*
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/iblock-imgs-cleaner.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/iblock-imgs-cleaner.php");
*/

if ( !function_exists('clean_expire_cache') ) {
    function clean_expire_cache($path = "") {

        if (!class_exists("CFileCacheCleaner")) {
            require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/cache_files_cleaner.php");
        }

        $curentTime = mktime();
        if (defined("BX_CRONTAB") && BX_CRONTAB === true)
            $endTime = time()+5; //Если на кроне, то работаем 5 секунд
        else
            $endTime = time()+1; //Если на хитах, то не более секунды

        //Работаем со всем кешем
        $obCacheCleaner = new CFileCacheCleaner("all");

        if(!$obCacheCleaner->InitPath($path)) {
            //Произошла ошибка
            return "clean_expire_cache();";
        }

        $obCacheCleaner->Start();
        while($file = $obCacheCleaner->GetNextFile()) {
            if (is_string($file)) {
                $date_expire = $obCacheCleaner->GetFileExpiration($file);
                if($date_expire) {
                    if($date_expire < $curentTime) {
                        unlink($file);
                    }
                }
                if(time() >= $endTime)
                    break;
            }
        }

        if (is_string($file)) {
            return "clean_expire_cache(\"".$file."\");";
        } 
        else {
            return "clean_expire_cache();";
        }
    }
}

include_once('include/web_form_events.php');
include_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

AddEventHandler('main', 'OnEpilog', array('CMainHandlers', 'OnEpilogHandler'));
class CMainHandlers { 
   public static function OnEpilogHandler() {
      if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])>0) {
         $title = $GLOBALS['APPLICATION']->GetTitle();
         $GLOBALS['APPLICATION']->SetPageProperty('title', $title.' | Cтраница '.intval($_GET['PAGEN_1']));
      }
   }
}

define('CATALOG_IBLOCK_TYPE', 'aspro_max_catalog');
define('CATALOG_IBLOCK_ID', 72);
define('SECTION_IBLOCK_TYPE', 'xmlcatalog');
define('SECTION_IBLOCK_ID', 46);

include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/IblockHelper.php");
include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/DelayCatalogUpdateHandler.php");
include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/CMaxCacheExt.php");
include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/CatalogHelper.php");
include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/VideoUrlUtils.php");
include_once($_SERVER['DOCUMENT_ROOT']."/local/catalog/PhoneAuthExt.php");

AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("DelayCatalogUpdateHandler", "OnAfterIBlockElementAdd"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("DelayCatalogUpdateHandler", "OnAfterIBlockElementUpdate"));
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("DelayCatalogUpdateHandler", "OnBeforeIBlockElementDelete"));
AddEventHandler("catalog", "OnProductAdd", Array("DelayCatalogUpdateHandler", "OnProductAdd"));
AddEventHandler("catalog", "OnProductUpdate", Array("DelayCatalogUpdateHandler", "OnProductUpdate"));

AddEventHandler("sale", "OnSaleComponentOrderResultPrepared", Array("IblockHelper", "OnSaleComponentOrderResultPrepared"));
AddEventHandler("aspro.max", "OnAsproGetTotalQuantityBlock", Array("CatalogHelper", "OnAsproGetTotalQuantityBlock"));
AddEventHandler("main", "OnAfterUserLogin", Array("PhoneAuthExt", "OnAfterUserLogin"));
AddEventHandler("main", "OnAfterUserAuthorize", Array("PhoneAuthExt", "OnAfterUserAuthorize"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "notifyOnAfterAddArchbureauElement");

function notifyOnAfterAddArchbureauElement($fields) {
	$ARCHBUREAU_IBLOCK_ID = 79;
	if ($fields['IBLOCK_ID'] != $ARCHBUREAU_IBLOCK_ID) {
		return;
	}

	$eventType = 'ARCHBUREAU_ADD';
	$arMail = array(
		'ELEMENT_ID' => $fields['ID'],
	);

	$ok = CEvent::Send($eventType, "s1", $arMail);
}