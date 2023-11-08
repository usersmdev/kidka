<?

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loader::includeModule('aspro.max');

class PhoneAuthExt extends \Aspro\Max\PhoneAuth {
    public static function modifyResult(&$arResult, $arParams)
    {
		// get phone auth params
		list($bPhoneAuthSupported, $bPhoneAuthShow, $bPhoneAuthRequired, $bPhoneAuthUse) = self::getOptions();

		// auth by phone?
		$bByPhoneRequest = $bPhoneAuthUse && isset($_POST['USER_PHONE_NUMBER']) && isset($_POST['Login']);

		if($bByPhoneRequest){
			// phone number in request
			$phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($_POST['USER_PHONE_NUMBER']);

			// check captcha
			$bNeedCheckCaptcha = $GLOBALS['APPLICATION']->NeedCAPTHAForLogin($arResult['USER_LOGIN']);
			if($bNeedCheckCaptcha){
				$bCaptchaError = true;
				$captcha_sid = isset($_POST['captcha_sid']) ? strtoupper(trim($_POST['captcha_sid'])) : '';
				$captcha_word = isset($_POST['captcha_word']) ? strtoupper(trim($_POST['captcha_word'])) : '';

				if(strlen($captcha_word) && strlen($captcha_sid)){
					if($GLOBALS['APPLICATION']->captchaCheckCode($captcha_word, $captcha_sid)){
						$bCaptchaError = false;
					}
				}
			}
			else{
				$bCaptchaError = false;
			}

			if(!$bCaptchaError){
				// search user
				$arUser = \Bitrix\Main\UserPhoneAuthTable::getList([
					'select' => array('USER_ID'),
					'filter' => array('=PHONE_NUMBER' => $phoneNumber),
				])->fetch();
				if(!$arUser){
                    $userCreated = static::createUser($phoneNumber);
				}
			}
        }
        parent::modifyResult($arResult, $arParams);
    }
    
    public static function getNewPassword()
    {
        $groupIds = [];
		$defaultGroups = Option::get('main', 'new_user_registration_def_group', '');

		if (!empty($defaultGroups))
		{
			$groupIds = explode(',', $defaultGroups);
        }
        
        $arPolicy = $GLOBALS['USER']->GetGroupPolicy($groupIds);
    
        $passwordMinLength = (int)$arPolicy['PASSWORD_LENGTH'];
        if ($passwordMinLength <= 0)
        {
            $passwordMinLength = 6;
        }
        $passwordChars = array(
            'abcdefghijklnmopqrstuvwxyz',
            'ABCDEFGHIJKLNMOPQRSTUVWXYZ',
            '0123456789',
        );
        if ($arPolicy['PASSWORD_PUNCTUATION'] === 'Y')
        {
            $passwordChars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
        }
        return randString($passwordMinLength + 2, $passwordChars);
    }

    public static function createUser($phoneNumber)
    {
		$newPassword = $newPasswordConfirm = static::getNewPassword();

        $intPhone = preg_replace('/\D+/', '', $phoneNumber);

        $u = new CUser;
        $fields = [
            "LOGIN" => $intPhone,
            "PHONE_NUMBER" => $phoneNumber,
            "PERSONAL_PHONE" => $intPhone,
            "PERSONAL_MOBILE" => $intPhone,
            "UF_BXMAKER_AUPHONE" => $intPhone,
            "LID" => "ru",
            "ACTIVE" => "N",
            'PASSWORD' => $newPassword,
			'PASSWORD_CONFIRM' => $newPasswordConfirm,
        ];
        $id = $u->Add($fields);

        if ($id) {
            $_SESSION['PHONE_AUTH_USER'][$intPhone] = [
                'ID' => $id,
            ];
        }

        return $id;
    }   

    public static function OnAfterUserLogin($params)
    {
        $login = $params['LOGIN'];
        if ($login) {
            static::activateSessionUser($login);
        }
        // file_put_contents(__FILE__.'.log', print_r(['OnAfterUserLogin', $params], true), FILE_APPEND);
    }

    public static function OnAfterUserAuthorize($params)
    {
        $login = $params['LOGIN'];
        $login = $login ? $login : $params['user_fields']['LOGIN'];
        if ($login) {
            static::activateSessionUser($login);
        }
        // file_put_contents(__FILE__.'.log', print_r(['OnAfterUserAuthorize', $params], true), FILE_APPEND);
    }

    public static function activateSessionUser($login)
    {
        if (!empty($_SESSION['PHONE_AUTH_USER'][$login])) {
            $userId = $_SESSION['PHONE_AUTH_USER'][$login]['ID'];
            $u = new CUser;
            $u->Update($userId, [
                'ACTIVE' => 'Y',
            ]);

            unset($_SESSION['PHONE_AUTH_USER'][$login]);
        }
    }
}