<?php

/*
	Работа с Instagram
*/

function insta_login($user, $pass) {
	
	$headers = array(
	
		'Accept: */*',
		'Accept-Encoding: gzip, deflate, br',
		'Accept-Language: en-US,en;q=0.5',
		'Connection: keep-alive',
		'Content-Type: application/x-www-form-urlencoded',
		'DNT: 1',
		'Host: www.instagram.com',
		'Referer: https://www.instagram.com/accounts/login/?source=auth_switcher',
		'TE: Trailers',
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0',
		'X-Requested-With: XMLHttpRequest',
	
	);
	
	$post = array(
	
		'username' => $user,
		'password' => $pass,
		'queryParams' => json_encode(array('source' => 'auth_switcher')),
		'optInfoOneTap' => 'false',
	
	);
	
	$ci = curl_init();
	
	curl_setopt($ci, CURLOPT_URL, 'https://www.instagram.com/accounts/login/ajax/');
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ci, CURLOPT_HEADER, 1);
	curl_setopt($ci, CURLOPT_COOKIEFILE, 'cc');
	curl_setopt($ci, CURLOPT_COOKIEJAR, 'cc');
	curl_setopt($ci, CURLOPT_POST, 1); 
	curl_setopt($ci, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	
	$ce = curl_exec($ci);
	curl_close($ci);
	
	echo $ce;
	return true;
	
}

insta_login('slavac90', 'sbIN7828421');
//get_d('slavac90');
?>