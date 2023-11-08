<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка");
?><?if(\Tanais\User::getInstance()->isDesigner()):?>&nbsp;<?$APPLICATION->IncludeComponent("bitrix:subscribe.edit", "subscribe_edit", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"ALLOW_ANONYMOUS" => "N",	// Разрешить анонимную подписку
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_AUTH_LINKS" => "N",	// Показывать ссылки на авторизацию при анонимной подписке
		"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
	),
	false
);?><?else:?>
	<?ShowError("Доступ запрещен! Раздел только для дизайнеров!");?>
<?endif;?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>