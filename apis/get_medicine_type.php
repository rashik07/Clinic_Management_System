<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicineType{

    function GetAllMedicineType(){
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
            $get_content = "select * from medicine_type";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_type_id'=>$data['medicine_type_id'],
                            'medicine_type_user_added_id'=>$data['medicine_type_user_added_id'],
                            'medicine_type_name'=>$data['medicine_type_name'],
                            'medicine_type_description'=>$data['medicine_type_description'],
                            'medicine_type_creation_time'=>$data['medicine_type_creation_time'],
                            'medicine_type_modification_time'=>$data['medicine_type_modification_time']

                        ));
                }
                echo json_encode(array("medicine_type"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_type"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_type"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicineType(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_type_id   = $_POST['medicine_type_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine_type where medicine_type_id='$medicine_type_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_type_id'=>$data['medicine_type_id'],
                            'medicine_type_user_added_id'=>$data['medicine_type_user_added_id'],
                            'medicine_type_name'=>$data['medicine_type_name'],
                            'medicine_type_description'=>$data['medicine_type_description'],
                            'medicine_type_creation_time'=>$data['medicine_type_creation_time'],
                            'medicine_type_modification_time'=>$data['medicine_type_modification_time']

                        ));
                }
                echo json_encode(array("medicine_type"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_type"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_type"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_type"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineType();
    $authenticate->GetAllMedicineType();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_type_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineType();
    $authenticate->GetSingleMedicineType();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}