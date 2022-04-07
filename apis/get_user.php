<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetUser{

    function getAllUser(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from user left join user_type ut on user.user_type_id = ut.user_type_id";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'user_id'=>$data['user_id'],
                            'user_Full_Name'=>$data['user_Full_Name'],
                            'user_PhoneNo'=>$data['user_PhoneNo'],
                            'username'=>$data['username'],
                            'user_Email'=>$data['user_Email'],
                            'user_Status'=>$data['user_Status'],
                            'user_creation_time'=>$data['user_creation_time'],
                            'user_modification_time'=>$data['user_modification_time'],
                            'user_type_id'=>$data['user_type_id'],
                            'user_type_Name'=>$data['user_type_Name'],
                            'user_type_access_level'=>$data['user_type_access_level']

                        ));
                }
                echo json_encode(array("user"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("user"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("user"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function getSingleUser(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $user_id   = $_POST['user_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from user left join user_type ut on user.user_type_id = ut.user_type_id
                            where user.user_id='$user_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'user_id'=>$data['user_id'],
                            'user_Full_Name'=>$data['user_Full_Name'],
                            'user_PhoneNo'=>$data['user_PhoneNo'],
                            'username'=>$data['username'],
                            'user_Email'=>$data['user_Email'],
                            'user_Status'=>$data['user_Status'],
                            'user_creation_time'=>$data['user_creation_time'],
                            'user_modification_time'=>$data['user_modification_time'],
                            'user_type_id'=>$data['user_type_id'],
                            'user_type_Name'=>$data['user_type_Name'],
                            'user_type_access_level'=>$data['user_type_access_level']

                        ));
                }
                echo json_encode(array("user"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("user"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("user"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "user"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetUser();
    $authenticate->getAllUser();
}
else if(isset($_POST['content']) && ($_POST['content'] == "user_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetUser();
    $authenticate->getSingleUser();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}