<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteOutdoorService{

    function delete(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $outdoor_service_id  = $_POST['outdoor_service_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,[1,2,3]);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE FROM outdoor_service WHERE outdoor_service_id='$outdoor_service_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("outdoor_service" => "Successful", $status => 1, $message => "Delete Outdoor Service Successful"));
                } else {
                    echo json_encode(array("outdoor_service" => "Error", $status => 0, $message => "Delete Outdoor Service Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("outdoor_service"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("outdoor_service"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
}
if(isset($_POST['content']) && ($_POST['content'] == "outdoor_service"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteOutdoorService();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}