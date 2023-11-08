<?
function pr($arr) {
	global $USER;
	if($USER->IsAdmin()) {

		echo '<pre style="background-color:#000;color:#0ef735;font-family:sans-serif;text-align:left !important;display:block;clear:both;max-width:1000px;">';
		if(is_array($arr)) {
			print_r($arr);
		} else {
			var_dump($arr);
		}

		if($ex = $GLOBALS["APPLICATION"]->GetException()) {
			$strError = $ex->GetString();
			print_r($strError);
		}

		echo "</pre>";
	}
}