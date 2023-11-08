<?
header("Content-Type: application/x-javascript");
$hash = "bx_random_hash";
$config = array("appmap" =>
	array("main" => "mobileapp",
		"left" => "/mobileapp/left.php",
		"right" => "/mobileapp/right.php",
		"settings" => "/mobileapp/settings.php",
		"hash" => substr($hash, rand(1, strlen($hash)))
	)
);
echo json_encode($config);
?>