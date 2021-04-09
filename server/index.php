<?php

require_once 'init.php';

http_response_code(200);

try {
    $response["data"] = Router::dispatch($_GET['querysystemurl'] ?? '');
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