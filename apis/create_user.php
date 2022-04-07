<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateUser{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token  = $_POST['token'];
        $user_Full_Name   = $_POST['user_Full_Name'];
        $user_PhoneNo  = $_POST['user_PhoneNo'];
        $username   = $_POST['username'];
        $user_Email  = $_POST['user_Email'];
        $user_Password   = $_POST['user_Password'];
        $user_Status  = $_POST['user_Status'];
        $user_type_id  = $_POST['user_type_id'];

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,1);

        if($check_token && $check_permission)
        {

            try {
                $post_content = "INSERT INTO user (user_Full_Name,user_PhoneNo,
                    username,user_Email,user_Password,user_Status,user_type_id) 
                    VALUES ('$user_Full_Name','$user_PhoneNo','$username',
                            '$user_Email',MD5('$user_Password'),'$user_Status','$user_type_id')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("user" => "Successful","user_id"=>$last_id, $status => 1, $message => "Create User Successful"));
                } else {
                    echo json_encode(array("user" => "Error", $status => 0, $message => "Create User Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("user"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("user"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "user"))
{
    $authenticate = new CreateUser();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}