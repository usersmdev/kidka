<div class="modal fade" id="yandexdetail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog for_map">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Область на карте</h4>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 543px"></div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="fast_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Быстрый ответ</h4>
            </div>
            <div class="modal-body">
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:form",
                    "popup",
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
                        "WEB_FORM_ID" => "10",
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
                    "popup",
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
                            "action" => "action",
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
                <h4 class="modal-title" id="myModalLabel">Нашли этот лагерь дешевле?</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center; color: #333;">Сообщите нам, если вы нашли дешевле лагерь
                    <span class="lager_name"></span>, и мы снизим цену.</p>
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:form",
                    "popup",
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
                        "WEB_FORM_ID" => "18",
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
                        <div class="lager">Лагерь:</div>
                        <div class="lager_name_name"></div>
                    </div>
                    <div class="form_flex">
                        <div class="lager">Смена:</div>
                        <div class="lager_name_type"></div>
                    </div>
                    <div class="form_flex">
                        <div class="lager">Стоимость:</div>
                        <div class="lager_price">
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
                    "popup",
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
                <div id="mapYa" style="width: 100%; height: 543px"></div>
            </div>

        </div>
    </div>
</div>