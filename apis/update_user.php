<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateUser
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
        $user_id   = $_POST['user_id'];
        $token  = $_POST['token'];

        $user_Full_Name   = if_empty($_POST['user_Full_Name']);
        $user_PhoneNo  = if_empty($_POST['user_PhoneNo']);
        $username   = if_empty($_POST['username']);
        $user_Email  = if_empty($_POST['user_Email']);
        $user_Password   = if_empty($_POST['user_Password']);
        $user_Status  = if_empty($_POST['user_Status']);
        $user_type_id  = if_empty($_POST['user_type_id']);

        $check_token = $token_generator->check_token($request_user_id, $conn, $token);

        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2]);


        if (($check_token && $check_permission) || $request_user_id == $user_id) {
            try {
                if (empty($user_Password)) {
                    $post_content = "UPDATE user SET user_Full_Name = '$user_Full_Name',
                    user_PhoneNo = '$user_PhoneNo', username = '$username', user_Email = '$user_Email',
                    user_Status = '$user_Status', user_type_id = '$user_type_id' where user_id='$user_id'";
                } else {
                    $post_content = "UPDATE user SET user_Full_Name = '$user_Full_Name',
                    user_PhoneNo = '$user_PhoneNo', username = '$username', user_Email = '$user_Email',
                    user_Password = MD5('$user_Password'), user_Status = '$user_Status', 
                    user_type_id = '$user_type_id' where user_id='$user_id'";
                }

                // echo $post_content;
                $result = $conn->exec($post_content);
                // echo $result;
                if ($result) {
                    echo json_encode(array("user" => "Successful", $status => 1, $message => "Update User Successful"));
                } else {
                    echo json_encode(array("user" => "Error", $status => 0, $message => "Update User Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("user" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("user" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "user")) {
    $authenticate = new UpdateUser();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
