<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateOutdoorService
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
        $outdoor_service_id   = if_empty($_POST['outdoor_service_id']);
        $token  = $_POST['token'];

        $outdoor_service_name   = if_empty($_POST['outdoor_service_name']);
        $outdoor_service_Category   = if_empty($_POST['outdoor_service_Category']);
        $outdoor_service_description   = if_empty($_POST['outdoor_service_description']);
        $outdoor_service_room_no   = if_empty($_POST['outdoor_service_room_no']);
        $outdoor_service_rate   = if_empty($_POST['outdoor_service_rate']);
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1,2,3,4]);

        if ($check_token && $check_permission) {
            try {

                $post_content = "UPDATE outdoor_service SET outdoor_service_name = '$outdoor_service_name',
                outdoor_service_Category = '$outdoor_service_Category',
                outdoor_service_room_no = '$outdoor_service_room_no',
                    outdoor_service_description = '$outdoor_service_description', 
                   outdoor_service_rate = '$outdoor_service_rate'
                    where outdoor_service_id='$outdoor_service_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("outdoor_service" => "Successful", $status => 1, $message => "Update Outdoor Service Successful"));
                } else {
                    echo json_encode(array("outdoor_service" => "Error", $status => 0, $message => "Update Outdoor Service Failed"));
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
    $authenticate = new UpdateOutdoorService();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
