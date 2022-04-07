<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetOutdoorService{

    function getAllOutdoorService(){
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
            $get_content = "select * from outdoor_service";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'outdoor_service_id'=>$data['outdoor_service_id'],
                            'outdoor_service_user_added_id'=>$data['outdoor_service_user_added_id'],
                            'outdoor_service_name'=>$data['outdoor_service_name'],
                            'outdoor_service_description'=>$data['outdoor_service_description'],
                            'outdoor_service_rate'=>$data['outdoor_service_rate'],
                            'outdoor_service_creation_time'=>$data['outdoor_service_creation_time'],
                            'outdoor_service_modification_time'=>$data['outdoor_service_modification_time']

                        ));
                }
                echo json_encode(array("outdoor_service"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("outdoor_service"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("outdoor_service"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function getSingleOutdoorService(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $outdoor_service_id   = $_POST['outdoor_service_id'];

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from outdoor_service 
            where outdoor_service_id='$outdoor_service_id'";


            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'outdoor_service_id'=>$data['outdoor_service_id'],
                            'outdoor_service_user_added_id'=>$data['outdoor_service_user_added_id'],
                            'outdoor_service_name'=>$data['outdoor_service_name'],
                            'outdoor_service_description'=>$data['outdoor_service_description'],
                            'outdoor_service_rate'=>$data['outdoor_service_rate'],
                            'outdoor_service_creation_time'=>$data['outdoor_service_creation_time'],
                            'outdoor_service_modification_time'=>$data['outdoor_service_modification_time']

                        ));
                }
                echo json_encode(array("outdoor_service"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("outdoor_service"=>null,$status=>0, $message=>"No Data"));
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
    $authenticate = new GetOutdoorService();
    $authenticate->getAllOutdoorService();
}
else if(isset($_POST['content']) && ($_POST['content'] == "outdoor_service_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetOutdoorService();
    $authenticate->getSingleOutdoorService();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}