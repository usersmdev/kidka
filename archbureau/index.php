<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ($APPLICATION->GetCurPage() === '/archbureau/') {
	$APPLICATION->SetPageProperty("body_class", "page-archbureau");
}
$APPLICATION->SetTitle("");?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"lookbooks", 
	array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"IBLOCK_CATALOG_ID" => "72",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "100000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "lookbooks",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"COUNT_IN_LINE" => "4",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "LINK_BRANDS",
			2 => "LINK_VACANCY",
			3 => "LINK_NEWS",
			4 => "LINK_REVIEWS",
			5 => "LINK_PARTNERS",
			6 => "FORM_QUESTION",
			7 => "LINK_PROJECTS",
			8 => "LINK_GOODS",
			9 => "SEZON",
			10 => "LINK_STAFF",
			11 => "LINK_BLOG",
			12 => "STYLE",
			13 => "LINK_TIZERS",
			14 => "LINK_SERVICES",
			15 => "COLOR",
			16 => "PRICE_CAT",
			17 => "LINK_LANDINGS",
			18 => "SITE",
			19 => "PHONE",
			20 => "DOCUMENTS",
			21 => "PHOTOS",
			22 => "SIDE_IMAGE",
			23 => "TEST",
			24 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_NAME" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_catalog"]["aspro_max_lookbook"][0],
		"IBLOCK_TYPE" => "aspro_max_catalog",
		"IMAGE_POSITION" => "left",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "SITE",
			2 => "PHONE",
			3 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "300",
		"SEF_FOLDER" => "/archbureau/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_DETAIL_LINK" => "Y",
		"SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "Y",
		"USE_REVIEW" => "Y",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"VIEW_TYPE" => "table",
		"STRICT_SECTION_CHECK" => "N",
		"T_REVIEWS" => "",
		"T_DOCS" => "",
		"T_PROJECTS" => "",
		"LINKED_PRODUCTS_PROPERTY" => "LINK_GOODS",
		"SHOW_LINKED_PRODUCTS" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "OPT",
			2 => "",
		),
		"STORES" => array(
			0 => "",
			1 => "1",
			2 => "",
		),
		"T_GOODS" => "Товары",
		"T_GALLERY" => "Галерея",
		"SHOW_GALLERY" => "Y",
		"GALLERY_PRODUCTS_PROPERTY" => "PHOTOS",
		"SECTION_ELEMENTS_TYPE_VIEW" => "FROM_MODULE",
		"ELEMENT_TYPE_VIEW" => "element_1",
		"T_GOODS_SECTION" => "",
		"LIST_VIEW" => "slider",
		"LINKED_ELEMENST_PAGE_COUNT" => "20",
		"SHOW_MEASURE" => "N",
		"DEFAULT_LIST_TEMPLATE" => "block",
		"SHOW_UNABLE_SKU_PROPS" => "Y",
		"SHOW_ARTICLE_SKU" => "N",
		"SHOW_MEASURE_WITH_RATIO" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
		"ALT_TITLE_GET" => "NORMAL",
		"SHOW_DISCOUNT_TIME" => "Y",
		"SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
		"SHOW_RATING" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_WISH_BUTTONS" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"LIST_PROPERTY_CATALOG_CODE" => array(
			0 => "MORE_PHOTO",
			1 => "PROP_2104",
			2 => "PROP_2033",
			3 => "PROP_305",
			4 => "PROP_352",
			5 => "PROP_317",
			6 => "PROP_357",
			7 => "PROP_2102",
			8 => "PROP_318",
			9 => "PROP_159",
			10 => "PROP_349",
			11 => "PROP_327",
			12 => "PROP_2052",
			13 => "PROP_370",
			14 => "PROP_336",
			15 => "PROP_2115",
			16 => "PROP_346",
			17 => "PROP_2120",
			18 => "PROP_2053",
			19 => "PROP_363",
			20 => "PROP_320",
			21 => "PROP_2089",
			22 => "PROP_374",
			23 => "PROP_325",
			24 => "PROP_2103",
			25 => "PROP_2085",
			26 => "PROP_300",
			27 => "PROP_322",
			28 => "PROP_362",
			29 => "PROP_365",
			30 => "PROP_359",
			31 => "PROP_284",
			32 => "PROP_364",
			33 => "PROP_356",
			34 => "PROP_343",
			35 => "PROP_373",
			36 => "PROP_2083",
			37 => "PROP_314",
			38 => "PROP_348",
			39 => "PROP_316",
			40 => "PROP_350",
			41 => "PROP_333",
			42 => "PROP_372",
			43 => "PROP_332",
			44 => "PROP_360",
			45 => "PROP_353",
			46 => "PROP_347",
			47 => "PROP_25",
			48 => "PROP_2114",
			49 => "PROP_301",
			50 => "PROP_2101",
			51 => "PROP_2067",
			52 => "PROP_323",
			53 => "PROP_324",
			54 => "PROP_355",
			55 => "PROP_304",
			56 => "PROP_358",
			57 => "PROP_319",
			58 => "PROP_344",
			59 => "PROP_328",
			60 => "PROP_338",
			61 => "PROP_2113",
			62 => "PROP_371",
			63 => "PROP_2065",
			64 => "PROP_366",
			65 => "PROP_302",
			66 => "PROP_303",
			67 => "PROP_2054",
			68 => "PROP_341",
			69 => "PROP_223",
			70 => "PROP_283",
			71 => "PROP_354",
			72 => "PROP_313",
			73 => "PROP_2066",
			74 => "PROP_329",
			75 => "PROP_342",
			76 => "PROP_367",
			77 => "PROP_2084",
			78 => "PROP_340",
			79 => "PROP_351",
			80 => "PROP_368",
			81 => "PROP_369",
			82 => "PROP_331",
			83 => "PROP_337",
			84 => "PROP_345",
			85 => "PROP_339",
			86 => "PROP_310",
			87 => "PROP_309",
			88 => "PROP_330",
			89 => "PROP_2017",
			90 => "PROP_335",
			91 => "PROP_321",
			92 => "PROP_308",
			93 => "PROP_206",
			94 => "PROP_334",
			95 => "PROP_2100",
			96 => "PROP_311",
			97 => "PROP_2132",
			98 => "SHUM",
			99 => "PROP_361",
			100 => "PROP_326",
			101 => "PROP_315",
			102 => "PROP_2091",
			103 => "PROP_2026",
			104 => "PROP_307",
			105 => "",
		),
		"SORT_BUTTONS" => array(
			0 => "POPULARITY",
			1 => "NAME",
			2 => "PRICE",
		),
		"SORT_PRICES" => "REGION_PRICE",
		"SORT_REGION_PRICE" => "BASE",
		"IBLOCK_CATALOG_TYPE" => "aspro_max_catalog",
		"SALE_STIKER" => "-",
		"STIKERS_PROP" => "HIT",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "SIZES",
			1 => "COLOR_REF",
			2 => "SIZES3",
			3 => "SIZES4",
			4 => "SIZES5",
		),
		"OFFER_HIDE_NAME_PROPS" => "N",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "SIZES",
			1 => "COLOR_REF",
			2 => "SIZES3",
			3 => "SIZES4",
			4 => "SIZES5",
			5 => "",
		),
		"LIST_OFFERS_LIMIT" => "5",
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"DEPTH_LEVEL_BRAND" => "2",
		"USE_PRICE_COUNT" => "N",
		"CONVERT_CURRENCY" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"FILE_404" => "",
		"USE_SHARE" => "N",
		"NUM_NEWS" => "20",
		"NUM_DAYS" => "30",
		"YANDEX" => "N",
		"SIDE_LEFT_BLOCK" => "FROM_MODULE",
		"TYPE_LEFT_BLOCK" => "FROM_MODULE",
		"SIDE_LEFT_BLOCK_DETAIL" => "FROM_MODULE",
		"TYPE_LEFT_BLOCK_DETAIL" => "FROM_MODULE",
		"IBLOCK_LINK_NEWS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_news"][0],
		"IBLOCK_LINK_SERVICES_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_services"][0],
		"IBLOCK_LINK_TIZERS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_tizers"][0],
		"IBLOCK_LINK_REVIEWS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_reviews"][0],
		"IBLOCK_LINK_STAFF_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_staff"][0],
		"IBLOCK_LINK_VACANCY_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_vacancy"][0],
		"IBLOCK_LINK_BLOG_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_blog"][0],
		"IBLOCK_LINK_PROJECTS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_projects"][0],
		"IBLOCK_LINK_BRANDS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_brands"][0],
		"IBLOCK_LINK_LANDINGS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_catalog"]["aspro_max_landings"][0],
		"BLOCK_SERVICES_NAME" => "",
		"BLOCK_NEWS_NAME" => "",
		"BLOCK_TIZERS_NAME" => "",
		"BLOCK_REVIEWS_NAME" => "",
		"BLOCK_STAFF_NAME" => "",
		"BLOCK_VACANCY_NAME" => "",
		"BLOCK_PROJECTS_NAME" => "",
		"BLOCK_BRANDS_NAME" => "",
		"BLOCK_BLOG_NAME" => "",
		"BLOCK_LANDINGS_NAME" => "",
		"IBLOCK_LINK_PARTNERS_ID" => CMaxCache::$arIBlocks[SITE_ID]["aspro_max_content"]["aspro_max_partners"][0],
		"BLOCK_PARTNERS_NAME" => "",
		"GALLERY_TYPE" => "small",
		"STAFF_TYPE_DETAIL" => "list",
		"DETAIL_LINKED_GOODS_SLIDER" => "Y",
		"DETAIL_BLOCKS_ALL_ORDER" => "tizers,preview_text,char,docs,services,news,vacancy,blog,projects,brands,staff,gallery,partners,landings,goods_sections,goods,goods_catalog,form_order,desc,reviews,comments",
		"DETAIL_USE_COMMENTS" => "Y",
		"DETAIL_BLOG_USE" => "Y",
		"DETAIL_VK_USE" => "N",
		"DETAIL_FB_USE" => "N",
		"DETAIL_BLOG_URL" => "catalog_comments",
		"COMMENTS_COUNT" => "5",
		"BLOG_TITLE" => "Общение",
		"DETAIL_BLOG_EMAIL_NOTIFY" => "N",
		"SHOW_ICONS_SECTION" => "N",
		"SHOW_COUNT_ELEMENTS" => "Y",
		"AJAX_FILTER_CATALOG" => "Y",
		"SHOW_GALLERY_GOODS" => "N",
		"MAX_GALLERY_GOODS_ITEMS" => "5",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_DETAIL_TO_SLIDER" => "Y",
		"SIZE_IN_ROW" => "4",
		"BG_POSITION" => "top left",
		"ONLY_ELEMENT_DISPLAY_VARIANT" => "N",
		"USE_SUBSCRIBE_IN_TOP" => "N",
		"SHOW_ONE_CLICK_BUY" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"PRICE_VAT_INCLUDE" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"CATEGORY_IBLOCK" => "",
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_ITEMS_COUNT" => "5",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"MAX_VOTE" => "5",
		"VOTE_NAMES" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "5",
			5 => "",
		),
		"DISPLAY_AS_RATING" => "rating",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>