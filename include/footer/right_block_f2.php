<div class="info">
    <div class="row">
        <?if(\Bitrix\Main\Loader::includeModule('subscribe')):?>
            <div class="col-md-12 col-sm-12">
                <div class="subscribe_button">
                    <span class="btn" data-event="jqm" data-param-id="subscribe" data-param-type="subscribe" data-name="subscribe"><?=GetMessage('SUBSCRIBE_TITLE')?><?=CMax::showIconSvg('subscribe', SITE_TEMPLATE_PATH.'/images/svg/subscribe_small_footer.svg')?></span>
                </div>
            </div>
        <?endif;?>
        <div class="col-md-12 col-sm-12">
            <div class="phone blocks">
                <div class="inline-block">
                    <div class="phone white sm">
                        <div class="wrap">
                            <div>
                                <i class="svg inline  svg-inline-phone" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="5" height="11" viewBox="0 0 5 11"><path data-name="Shape 51 copy 13" class="cls-1" d="M402.738,141a18.086,18.086,0,0,0,1.136,1.727,0.474,0.474,0,0,1-.144.735l-0.3.257a1,1,0,0,1-.805.279,4.641,4.641,0,0,1-1.491-.232,4.228,4.228,0,0,1-1.9-3.1,9.614,9.614,0,0,1,.025-4.3,4.335,4.335,0,0,1,1.934-3.118,4.707,4.707,0,0,1,1.493-.244,0.974,0.974,0,0,1,.8.272l0.3,0.255a0.481,0.481,0,0,1,.113.739c-0.454.677-.788,1.159-1.132,1.731a0.43,0.43,0,0,1-.557.181l-0.468-.061a0.553,0.553,0,0,0-.7.309,6.205,6.205,0,0,0-.395,2.079,6.128,6.128,0,0,0,.372,2.076,0.541,0.541,0,0,0,.7.3l0.468-.063a0.432,0.432,0,0,1,.555.175h0Z" transform="translate(-399 -133)"></path></svg></i>					<a rel="nofollow" href="tel:+74993910846">+7 (499) 391-08-46</a>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="inline-block callback_wrap">
                        <span class="callback-block colored" style="cursor: pointer" data-toggle="modal" data-target="#callback_m"><?=GetMessage("CALLBACK")?></span>
                    </div>

            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="email blocks">
                <i class="svg inline  svg-inline-email" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9">
                        <path data-name="Rectangle 583 copy 16" class="cls-1" d="M367,142h-7a2,2,0,0,1-2-2v-5a2,2,0,0,1,2-2h7a2,2,0,0,1,2,2v5A2,2,0,0,1,367,142Zm0-2v-3.039L364,139h-1l-3-2.036V140h7Zm-6.634-5,3.145,2.079L366.634,135h-6.268Z" transform="translate(-358 -133)"></path></svg></i>
                <a href="mailto:info@kidka.ru" target="_blank">info@kidka.ru</a>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="address blocks">
                <i class="svg inline  svg-inline-addr" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="12" viewBox="0 0 9 12">
                        <path class="cls-1" d="M959.135,82.315l0.015,0.028L955.5,87l-3.679-4.717,0.008-.013a4.658,4.658,0,0,1-.83-2.655,4.5,4.5,0,1,1,9,0A4.658,4.658,0,0,1,959.135,82.315ZM955.5,77a2.5,2.5,0,0,0-2.5,2.5,2.467,2.467,0,0,0,.326,1.212l-0.014.022,2.181,3.336,2.034-3.117c0.033-.046.063-0.094,0.093-0.142l0.066-.1-0.007-.009a2.468,2.468,0,0,0,.32-1.2A2.5,2.5,0,0,0,955.5,77Z" transform="translate(-951 -75)"></path></svg></i>
                г. Москва</div>
        </div>
    </div>
</div>