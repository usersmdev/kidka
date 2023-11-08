<?
$aMenuLinks = Array(
	Array(
		"Мой профиль", 
		"/personal/profile/", 
		Array(), 
		Array(), 
		"\$USER->IsAuthorized()" 
	),
	Array(
		"Мои заказы", 
		"/personal/order/", 
		Array(), 
		Array(), 
		"\$USER->IsAuthorized()" 
	),
	Array(
		"Моя корзина", 
		"/personal/cart/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Рекламные материалы", 
		"/personal/promo/", 
		Array(), 
		Array(), 
		"\$USER->IsAuthorized() && in_array('11',\$USER->GetUserGroupArray())" 
	),
	Array(
		"Календарь событий", 
		"/personal/calendar/",
		Array(), 
		Array(), 
		"\Tanais\User::getInstance()->isDesigner()" 
	),
	Array(
		"Справочник для дизайнеров", 
		"/personal/handbook/",
		Array(), 
		Array(), 
		"\Tanais\User::getInstance()->isDesigner()" 
	),
    Array(
        "Подписка на новости",
        "/personal/calendar/subscribe/",
        Array(),
        Array(),
        "\Tanais\User::getInstance()->isDesigner()"
    ),
    Array(
        "Запрос на каталог",
        "/personal/handbook/request-catalog/",
        Array(),
        Array(),
        "\Tanais\User::getInstance()->isDesigner()"
    ),
);
?>