<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class Indoor_payment
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

        $indoor_treatment_payment_treatment_id   = if_empty($_POST['indoor_treatment_payment_treatment_id']);
        $indoor_treatment_payment_details   = if_empty($_POST['indoor_treatment_payment_details']);
        $indoor_treatment_payment_amount   = if_empty($_POST['indoor_treatment_payment_amount']);
        $indoor_treatment_payment_released   = if_empty($_POST['indoor_treatment_payment_released']);


        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 3]);

        if ($check_token && $check_permission) {
            try {
                $post_content = "INSERT INTO indoor_treatment_payment (indoor_treatment_payment_user_added_id, indoor_treatment_payment_treatment_id,indoor_treatment_payment_details,
                             indoor_treatment_payment_amount,indoor_treatment_payment_released) 
                    VALUES ('$request_user_id', '$indoor_treatment_payment_treatment_id','$indoor_treatment_payment_details','$indoor_treatment_payment_amount','$indoor_treatment_payment_released')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    $post_content = "UPDATE indoor_treatment SET indoor_treatment_modification_time = NOW() where indoor_treatment_id = '$indoor_treatment_payment_treatment_id'";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
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
if (isset($_POST['content']) && ($_POST['content'] == "indoor_payment")) {
    $authenticate = new Indoor_payment();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
