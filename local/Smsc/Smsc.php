<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/local/Smsc/SmsApi.php');

use Bitrix\Main\Error;
use Bitrix\MessageService\Sender\Base;
use Bitrix\MessageService\Sender\Result\SendMessage;

\CModule::IncludeModule('messageservice');

class Smsc extends \Bitrix\MessageService\Sender\Base
{
    private $login;

    private $password;

    private $client;

    public function __construct() {
        $this->login = '0882252';
        $this->password = '111qqq@@@';

        $this->client = new \SmsApi($this->login, $this->password);
    }

    public function sendMessage(array $messageFields) {
        if (!$this->canUse()) {
            $result = new SendMessage();
            $result->addError(new Error('Ошибка отправки. СМС-сервис отключен'));
            return $result;
        }

        $parameters = [
            'phones' => $messageFields['MESSAGE_TO'],
            'mes' => $messageFields['MESSAGE_BODY'],
        ];

        if ($messageFields['MESSAGE_FROM']) {
            $parameters['sender'] = $messageFields['MESSAGE_FROM'];
        }

        $result = new SendMessage();
        $response = $this->client->send($parameters);

        if (!$response->isSuccess()) {
            $result->addErrors($response->getErrors());
            return $result;
        }

        return $result;
    }

    public function getShortName() {
        return 'smsc.ru';
    }

    public function getId() {
        return 'smscru';
    }

    public function getName() {
        return 'SMS-центр';
    }

    public function canUse() {
        return true;
    }

    public function getFromList():array {
        $data = $this->client->getSenderList();
        if ($data->isSuccess()) {
            return $data->getData();
        }

        return [];
    }
}