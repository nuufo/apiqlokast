<?php 

header('Content-Type: text/json');

function __autoload($class) {
	require_once($class.".class.php");
}

$url_Parts = getUrlParts($_GET);

$method   = $_SERVER['REQUEST_METHOD'];
$resource = $url_Parts[0];
$data     = getHTTPData($method);

$allowed_resoucres = ['course', 'grade']; 

if(in_array($resource, $allowed_resoucres)) {
	require_once($resource.".class.php");
	$id = (isset($url_Parts[1])) ? $url_Parts[1] : NULL; 
	$obj = new $resource($id); 
	$method .= (isset($url_Parts[2])) ? $url_Parts[2] : ""; 
	$obj->$method($data); 
}else {
	
	header("HTTP/1.1 404 Not Found");
}

function getHTTPData($method) {
	switch ($method) {
		case 'GET':
			$data = $_GET;
			break;
		case 'POST':
			$data = $_POST;
			break;
		case 'PUT':
		case 'DELETE' : 
		parse_str(file_get_contents('php://input', false, null,-1, $_SERVER['CONTENT_LENGTH']), $data );
			break;
	}
	return $data; 

}

function getUrlParts($get) {

	$get_params = array_keys($get);

	$url = $get_params[0];

	$url_Parts = explode("/", $url);
	foreach ($url_Parts as $key => $value) {
		if($value) $array[] = $value;
	}
	$url_Parts = $array;

	return $url_Parts; 


 }

