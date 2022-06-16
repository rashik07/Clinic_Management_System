<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteDoctor
{

    function delete()
    {
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status = "status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $indoor_treatment_payment_id   = $_POST['indoor_treatment_payment_id'];
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 3]);

        if ($check_token && $check_permission) {
            try {
                $delete_content = "DELETE FROM indoor_treatment_payment WHERE indoor_treatment_payment_id='$indoor_treatment_payment_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("doctor" => "Successful", $status => 1, $message => "Delete Payment Successful"));
                } else {
                    echo json_encode(array("doctor" => "Error", $status => 0, $message => "Delete Payment Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("doctor" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("doctor" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "indoor_treatment_payment"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteDoctor();
    $authenticate->delete();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
