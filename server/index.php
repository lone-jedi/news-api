<?php

require_once 'init.php';

http_response_code(200);

$url  = $_GET['querysystemurl'] ?? '';
$args = explode('/', $url);
$type = $args[0];

try {
    if(!isset($type)) {
        throw new HttpException("Bad url", 404);
    }

    $method    = strtolower($_SERVER['REQUEST_METHOD']);
    $dbconnect = new DbModel(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $news      = new NewsController($dbconnect, $type, $args);

    if(!method_exists($news, $method)) {
        throw new HttpException('Method not implemented', 501);
    }

    $response["data"] = $news->$method();
} 
catch(HttpException $e) {
    http_response_code($e->getHttpCode());
    $response = ['error-msg' => $e->getMessage()];
}
catch(PDOException $e) {
    http_response_code(500);
    $response = ['error-msg' => $e->getMessage()];
}
catch(Exception $e) {
    $response = ['error-msg' => $e->getMessage()];
}
finally {
    if(!isset($response['data']) && !isset($response['error-msg'])) {
        http_response_code(405);
        $response = ['error-msg' => 'Error! This url is not supported'];
    }
    echo json_encode($response);
}