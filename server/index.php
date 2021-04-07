<?php

require_once 'init.php';

http_response_code(200);

$url =  $_GET['querysystemurl'] ?? '';
$args = explode('/', $url);
$type = $args[0];

try {
    if(!isset($type)) {
        throw new Exception("Bad url", 404);
    }

    $dbconnect = new DbModel(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $response["data"] = (new NewsController($dbconnect, $type, $args))->$method();
} 
catch(Exception $e) {
    http_response_code($e->getCode());
    $response = ['error-msg' => $e->getMessage()];
}
finally {
    if(!isset($response['data']) && !isset($response['error-msg'])) {
        http_response_code(405);
        $response = ['error-msg' => 'Error! This url is not supported'];
    }
    echo json_encode($response);
}