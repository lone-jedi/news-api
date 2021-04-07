<?php

require_once 'init.php';

http_response_code(200);

$url =  $_GET['querysystemurl'] ?? '';
$args = explode('/', $url);
$type = $args[0];

try {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($type)) {
                if($type === 'all') {
                    $response["data"] =  $news->all();
                } else if($type === 'one') {
                    if(isset($args[1]) && is_numeric($args[1])) {
                        $response["data"] =  $news->one($args[1]);
                    } else {
                        throw new Exception('Incorrect argument "id"', 404);
                    }
                }
            }
            break;
        case 'POST':
            if(isset($type)) {
                if($type === 'add') {
                    if(isset($_POST['title']) && isset($_POST['content'])) {
                        $response["data"] =  $news->add($_POST['title'], $_POST['content']); 
                    } else {
                        throw new Exception('Arguments "title" or "content" for add not found', 404);
                    }
                }
            }
            break;
        case 'PUT':
            if(isset($type)) {
                if($type === 'update') {
                    $data = file_get_contents('php://input');
                    $data = json_decode($data, true);
                    if(isset($data['id']) && isset($data['title']) && isset($data['content'])) {
                        $response["data"] = $news->update($data['id'], $data['title'], $data['content']); 
                    } else {
                        throw new Exception('Arguments "id" or "title" or "content" for update not found', 404);
                    }
                }
            }
            break;
        case 'DELETE':
            if(isset($type)) {
                if($type === 'delete') {
                    if(isset($args[1]) && is_numeric($args[1])) {
                        $response["data"] = $news->delete($args[1]); 
                    } else {
                        throw new Exception('Arguments "id" for delete not found', 404);
                    }
                }
            }
            break;  
        default:
            throw new Exception('Method not supported', 405);
            break;
    }
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