<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateOutdoorService
{

    function post()
    {
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status = "status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token  = $_POST['token'];

        $outdoor_service_name   = if_empty($_POST['outdoor_service_name']);
        $outdoor_service_Category   = if_empty($_POST['outdoor_service_Category']);
        $outdoor_service_description   = if_empty($_POST['outdoor_service_description']);
        $outdoor_service_room_no   = if_empty($_POST['outdoor_service_room_no']);
        $outdoor_service_rate   = if_empty($_POST['outdoor_service_rate']);

        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1,2,3]);

        if ($check_token && $check_permission) {
            try {
                $post_content = "INSERT INTO outdoor_service (outdoor_service_user_added_id, outdoor_service_name,outdoor_service_Category,
                             outdoor_service_room_no,outdoor_service_description, outdoor_service_rate) 
                    VALUES ('$request_user_id', '$outdoor_service_name','$outdoor_service_Category','$outdoor_service_room_no',
                            '$outdoor_service_description',
                            '$outdoor_service_rate')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("outdoor_service" => "Successful", "outdoor_service_id" => $last_id, $status => 1, $message => "Create Outdoor Service Successful"));
                } else {
                    echo json_encode(array("outdoor_service" => "Error", $status => 0, $message => "Create Outdoor Service Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("outdoor_service" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("outdoor_service" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "outdoor_service")) {
    $authenticate = new CreateOutdoorService();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
