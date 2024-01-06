<div class="modal fade" id="yandexdetail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog for_map">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Область на карте</h4>
            </div>
            <div class="modal-body">
                <div id="map"></div>
            </div>

        </div>
    </div>
</div>
<!--<div class="modal fade" id="fast_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--                <h4 class="modal-title" id="myModalLabel">Быстрый ответ</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                --><?//
//                $APPLICATION->IncludeComponent(
//                    "bitrix:form",
//                    "popup",
//                    array(
//                        "AJAX_MODE" => "Y",
//                        "AJAX_OPTION_ADDITIONAL" => "",
//                        "AJAX_OPTION_HISTORY" => "N",
//                        "AJAX_OPTION_JUMP" => "N",
//                        "AJAX_OPTION_STYLE" => "Y",
//                        "CACHE_TIME" => "3600",
//                        "CACHE_TYPE" => "A",
//                        "CHAIN_ITEM_LINK" => "",
//                        "CHAIN_ITEM_TEXT" => "",
//                        "COMPOSITE_FRAME_MODE" => "A",
//                        "COMPOSITE_FRAME_TYPE" => "AUTO",
//                        "EDIT_ADDITIONAL" => "N",
//                        "EDIT_STATUS" => "N",
//                        "IGNORE_CUSTOM_TEMPLATE" => "N",
//                        "NAME_TEMPLATE" => "",
//                        "NOT_SHOW_FILTER" => array(
//                            0 => "",
//                            1 => "",
//                        ),
//                        "NOT_SHOW_TABLE" => array(
//                            0 => "",
//                            1 => "",
//                        ),
//                        "RESULT_ID" => $_REQUEST["RESULT_ID"],
//                        "SEF_MODE" => "N",
//                        "SHOW_ADDITIONAL" => "Y",
//                        "SHOW_ANSWER_VALUE" => "N",
//                        "SHOW_EDIT_PAGE" => "N",
//                        "SHOW_LIST_PAGE" => "N",
//                        "SHOW_STATUS" => "N",
//                        "SHOW_VIEW_PAGE" => "N",
//                        "START_PAGE" => "new",
//                        "SUCCESS_URL" => "",
//                        "USE_EXTENDED_ERRORS" => "N",
//                        "WEB_FORM_ID" => "10",
//                        "COMPONENT_TEMPLATE" => "popup",
//                        "VARIABLE_ALIASES" => array(
//                            "action" => "action",
//                        )
//                    ),
//                    false
//                ); ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="modal fade" id="more_information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Запрос информации</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center; color: #333;">Укажите контактные данные - с вами свяжется специалист и
                    ответит на все волнующие вопросы</p>
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:form",
                    "popup1",
                    array(
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CHAIN_ITEM_LINK" => "",
                        "CHAIN_ITEM_TEXT" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_ADDITIONAL" => "N",
                        "EDIT_STATUS" => "N",
                        "IGNORE_CUSTOM_TEMPLATE" => "N",
                        "NAME_TEMPLATE" => "",
                        "NOT_SHOW_FILTER" => array(
                            0 => "",
                            1 => "",
                        ),
                        "NOT_SHOW_TABLE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "RESULT_ID" => $_REQUEST["RESULT_ID"],
                        "SEF_MODE" => "N",
                        "SHOW_ADDITIONAL" => "Y",
                        "SHOW_ANSWER_VALUE" => "N",
                        "SHOW_EDIT_PAGE" => "N",
                        "SHOW_LIST_PAGE" => "N",
                        "SHOW_STATUS" => "N",
                        "SHOW_VIEW_PAGE" => "N",
                        "START_PAGE" => "new",
                        "SUCCESS_URL" => "",
                        "USE_EXTENDED_ERRORS" => "N",
                        "WEB_FORM_ID" => "12",
                        "COMPONENT_TEMPLATE" => "popup",
                        "VARIABLE_ALIASES" => array(
                            "action" => "action1",
                        )
                    ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cheaper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Нашли дешевле?</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center; color: #333;">Сообщите нам, если вы нашли дешевле
                    <span class="lager_name"></span>, и мы снизим цену.</p>
                <?
                $APPLICATION->IncludeComponent("bitrix:form", "popup1", Array(
	"AJAX_MODE" => "Y",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"EDIT_ADDITIONAL" => "N",	// Выводить на редактирование дополнительные поля
		"EDIT_STATUS" => "N",	// Выводить форму смены статуса
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
		"NAME_TEMPLATE" => "",
		"NOT_SHOW_FILTER" => array(	// Коды полей, которые нельзя показывать в фильтре
			0 => "",
			1 => "",
		),
		"NOT_SHOW_TABLE" => array(	// Коды полей, которые нельзя показывать в таблице
			0 => "",
			1 => "",
		),
		"RESULT_ID" => $_REQUEST["RESULT_ID"],	// ID результата
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SHOW_ADDITIONAL" => "N",	// Показать дополнительные поля веб-формы
		"SHOW_ANSWER_VALUE" => "N",	// Показать значение параметра ANSWER_VALUE
		"SHOW_EDIT_PAGE" => "N",	// Показывать страницу редактирования результата
		"SHOW_LIST_PAGE" => "N",	// Показывать страницу со списком результатов
		"SHOW_STATUS" => "N",	// Показать текущий статус результата
		"SHOW_VIEW_PAGE" => "N",	// Показывать страницу просмотра результата
		"START_PAGE" => "new",	// Начальная страница
		"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
		"WEB_FORM_ID" => "19",	// ID веб-формы
		"COMPONENT_TEMPLATE" => "popup",
		"VARIABLE_ALIASES" => array(
			"action" => "action",
		)
	),
	false
); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Бронирование путевки</h4>
            </div>
            <div class="modal-body">
                <div class="text_before">
                    <div class="form_flex">
                        <div class="lager">Организация:</div>
                        <div class="lager_name_name"></div>
                    </div>
                    <div class="form_flex">
                        <div class="lager">Смена:</div>
                        <div class="lager_name_type"></div>
                    </div>
                    <div class="form_flex mob">
                        <div class="lager">Стоимость:</div>
                        <div class="lager_real_price mob"></div>
                    </div>
                    <div class="form_flex mob">
                        <div class="lager_sale_price mob"></div>
                        <div class="lager_base_price mob"></div>
                    </div>
                    <div class="form_flex">
                        <div class="lager pc">Стоимость:</div>

                        <div class="lager_price pc">
                            <div class="lager_real_price"></div>
                            <div class="lager_base_price"></div>
                            <div class="lager_sale_price"></div>
                        </div>
                    </div>
                </div>
                <div class="form-control">
                    <label><span>Дата путевки</span></label>
                    <select name="modal_price" id="modal_price">
                    </select>
                </div>

                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:form",
                    "popup1",
                    array(
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CHAIN_ITEM_LINK" => "",
                        "CHAIN_ITEM_TEXT" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_ADDITIONAL" => "N",
                        "EDIT_STATUS" => "N",
                        "IGNORE_CUSTOM_TEMPLATE" => "N",
                        "NAME_TEMPLATE" => "",
                        "NOT_SHOW_FILTER" => array(
                            0 => "",
                            1 => "",
                        ),
                        "NOT_SHOW_TABLE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "RESULT_ID" => $_REQUEST["RESULT_ID"],
                        "SEF_MODE" => "N",
                        "SHOW_ADDITIONAL" => "Y",
                        "SHOW_ANSWER_VALUE" => "N",
                        "SHOW_EDIT_PAGE" => "N",
                        "SHOW_LIST_PAGE" => "N",
                        "SHOW_STATUS" => "N",
                        "SHOW_VIEW_PAGE" => "N",
                        "START_PAGE" => "new",
                        "SUCCESS_URL" => "",
                        "USE_EXTENDED_ERRORS" => "N",
                        "WEB_FORM_ID" => "19",
                        "COMPONENT_TEMPLATE" => "popup",
                        "VARIABLE_ALIASES" => array(
                            "action" => "action",
                        )
                    ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Область на карте</h4>
            </div>

            <div class="modal-body">
                <div id="mapYa"></div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modalAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Адреса</h4>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>