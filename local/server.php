<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("server");
?>
<pre>
<?

print_r([
	'SERVER_NAME' => $_SERVER['SERVER_NAME'],
	'SCRIPT_URI' => $_SERVER['SCRIPT_URI'],
	'HTTP_X_FORWARDED_FOR' => $_SERVER['HTTP_X_FORWARDED_FOR'],
	'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
	'REMOTE_ADDR_hostname' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
	'gethostname' => gethostname(),
	'gethostbynamel' => gethostbynamel(gethostname()),
	1/0
]);
?>
</pre>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>