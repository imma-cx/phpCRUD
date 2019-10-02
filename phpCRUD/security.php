<?php

function scrubInput($ary = [], $type = '') {
	foreach($ary as $k => $v) {
		if(!is_array($ary[$k])) {
			//$ary[$k] = filter_var(mres(htmlentities(strip_tags($v), ENT_QUOTES)), FILTER_SANITIZE_STRING);
    	$ary[$k] = filter_var((htmlentities(strip_tags($v), ENT_QUOTES)), FILTER_SANITIZE_STRING);

		} else {
			$ary[$k] = scrubInput($v);
		}
	}
	return $ary;
}

 ?>
