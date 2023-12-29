<?php
header('Acess-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../vendor/autoload.php';

// $requestUri = $_SERVER['REQUEST_URI' == 'api/user'];
// $requestMetodo = $_SERVER['REQUEST_METHOD' == 'GET'];
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     if ($_SERVER['REQUEST_URI'] === '/api/user') {

// api/user/1
if ($_GET['url']) {
    $url = explode('/', $_GET['url']);

    if ($url[0] === 'api') {
        array_shift($url);

        $service = 'App\Services\\' . ucfirst($url[0]) . 'Service';
        array_shift($url);

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try {
            $response = call_user_func_array(array(new $service, $method), $url);

            http_response_code(200);
            echo json_encode(array('status' => 'success', 'data' => $response));
            exit;
        } catch (\Exception $e) {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}

