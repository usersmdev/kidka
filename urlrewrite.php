<?php
$arUrlRewrite=array (
  13 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/([\\w\\d\\-]+)?(/)?(([\\w\\d\\-]+)(/)?)?#',
    'RULE' => 'REQUEST_OBJECT=$1&METHOD=$4',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/personal/promo/request/(\\d+)/(\\?(.*))?$#',
    'RULE' => 'PROMO_ID=$1',
    'PATH' => '/personal/promo/request/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/about/vacancies/resume/(\\d+)/(\\?(.*))?$#',
    'RULE' => 'VACANCY_ID=$1',
    'PATH' => '/about/vacancies/resume/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/personal/order/request/(\\d+)/(\\?(.*))?$#',
    'RULE' => 'PRODUCT_ID=$1',
    'PATH' => '/personal/order/request/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  118 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/personal/history-of-orders/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/history-of-orders/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/personal/calendar/(.*)/.*$#',
    'RULE' => 'SECTION_ID=$1',
    'ID' => '',
    'PATH' => '/personal/calendar/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  54 => 
  array (
    'CONDITION' => '#^/company/licenses/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/licenses/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  27 => 
  array (
    'CONDITION' => '#^/company/partners/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/partners/index.php',
    'SORT' => 100,
  ),
  42 => 
  array (
    'CONDITION' => '#^/contacts/stores/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/contacts/stores/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/company/reviews/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/reviews/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/company/vacancy/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/vacancy/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  123 => 
  array (
    'CONDITION' => '#^/about/vacancy/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/vacancy/index.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/company/staff/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/staff/index.php',
    'SORT' => 100,
  ),
  48 => 
  array (
    'CONDITION' => '#^/company/docs/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/docs/index.php',
    'SORT' => 100,
  ),
  50 => 
  array (
    'CONDITION' => '#^/company/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/company/news/index.php',
    'SORT' => 100,
  ),
  125 => 
  array (
    'CONDITION' => '#^/test-catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/test-catalog/index.php',
    'SORT' => 100,
  ),
  81 => 
  array (
    'CONDITION' => '#^/catalogs/3d/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/catalogs/3d/index.php',
    'SORT' => 100,
  ),
  38 => 
  array (
    'CONDITION' => '#^/info/brands/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/info/brands/index.php',
    'SORT' => 100,
  ),
  101 => 
  array (
    'CONDITION' => '#^/archbureau/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/archbureau/index.php',
    'SORT' => 100,
  ),
  91 => 
  array (
    'CONDITION' => '#^/exhibition/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/exhibition/index.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/lookbooks/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/lookbooks/index.php',
    'SORT' => 100,
  ),
  114 => 
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  67 => 
  array (
    'CONDITION' => '#^/contacts/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/contacts/page_contacts_2.php',
    'SORT' => 100,
  ),
  110 => 
  array (
    'CONDITION' => '#^/projects/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/projects/index.php',
    'SORT' => 100,
  ),
  41 => 
  array (
    'CONDITION' => '#^/landings/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/landings/index.php',
    'SORT' => 100,
  ),
  115 => 
  array (
    'CONDITION' => '#^/products/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/products/index.php',
    'SORT' => 100,
  ),
  124 => 
  array (
    'CONDITION' => '#^/articles/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
  ),
  92 => 
  array (
    'CONDITION' => '#^/catalogs/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/catalogs/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  119 => 
  array (
    'CONDITION' => '#^/content/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/content/index.php',
    'SORT' => 100,
  ),
  120 => 
  array (
    'CONDITION' => '#^/academy/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/academy/index.php',
    'SORT' => 100,
  ),
  88 => 
  array (
    'CONDITION' => '#^/brands/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/brands/index.php',
    'SORT' => 100,
  ),
  126 => 
  array (
    'CONDITION' => '#^/offers/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/offers/index.php',
    'SORT' => 100,
  ),
  127 => 
  array (
    'CONDITION' => '#^/uslugi/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/uslugi/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/auth/#',
    'RULE' => '',
    'ID' => 'aspro:auth.max',
    'PATH' => '/auth/index.php',
    'SORT' => 100,
  ),
  71 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
  95 => 
  array (
    'CONDITION' => '#^/sale/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/sale/index.php',
    'SORT' => 100,
  ),
);
