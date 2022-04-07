<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetPathologyTest{

    function GetAllPathologyTest(){
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
            $get_content = "select * from pathology_test";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'pathology_test_id'=>$data['pathology_test_id'],
                            'pathology_test_user_added_id'=>$data['pathology_test_user_added_id'],
                            'pathology_test_name'=>$data['pathology_test_name'],
                            'pathology_test_description'=>$data['pathology_test_description'],
                            'pathology_test_room_no'=>$data['pathology_test_room_no'],
                            'pathology_test_price'=>$data['pathology_test_price'],
                            'pathology_test_creation_time'=>$data['pathology_test_creation_time'],
                            'pathology_test_modification_time'=>$data['pathology_test_modification_time']

                        ));
                }
                echo json_encode(array("pathology_test"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("pathology_test"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("pathology_test"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSinglePathologyTest(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $pathology_test_id   = $_POST['pathology_test_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from pathology_test where pathology_test_id='$pathology_test_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'pathology_test_id'=>$data['pathology_test_id'],
                            'pathology_test_user_added_id'=>$data['pathology_test_user_added_id'],
                            'pathology_test_name'=>$data['pathology_test_name'],
                            'pathology_test_description'=>$data['pathology_test_description'],
                            'pathology_test_room_no'=>$data['pathology_test_room_no'],
                            'pathology_test_price'=>$data['pathology_test_price'],
                            'pathology_test_creation_time'=>$data['pathology_test_creation_time'],
                            'pathology_test_modification_time'=>$data['pathology_test_modification_time']

                        ));
                }
                echo json_encode(array("pathology_test"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("pathology_test"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("pathology_test"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "pathology_test"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPathologyTest();
    $authenticate->GetAllPathologyTest();
}
else if(isset($_POST['content']) && ($_POST['content'] == "pathology_test_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPathologyTest();
    $authenticate->GetSinglePathologyTest();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}