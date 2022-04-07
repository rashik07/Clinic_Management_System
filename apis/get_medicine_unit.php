<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicineUnit{

    function GetAllMedicineUnit(){
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
            $get_content = "select * from medicine_unit";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_unit_id'=>$data['medicine_unit_id'],
                            'medicine_unit_user_added_id'=>$data['medicine_unit_user_added_id'],
                            'medicine_unit_name'=>$data['medicine_unit_name'],
                            'medicine_unit_description'=>$data['medicine_unit_description'],
                            'medicine_unit_creation_time'=>$data['medicine_unit_creation_time'],
                            'medicine_unit_modification_time'=>$data['medicine_unit_modification_time']

                        ));
                }
                echo json_encode(array("medicine_unit"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_unit"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_unit"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicineUnit(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_unit_id   = $_POST['medicine_unit_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine_unit where medicine_unit_id='$medicine_unit_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_unit_id'=>$data['medicine_unit_id'],
                            'medicine_unit_user_added_id'=>$data['medicine_unit_user_added_id'],
                            'medicine_unit_name'=>$data['medicine_unit_name'],
                            'medicine_unit_description'=>$data['medicine_unit_description'],
                            'medicine_unit_creation_time'=>$data['medicine_unit_creation_time'],
                            'medicine_unit_modification_time'=>$data['medicine_unit_modification_time']

                        ));
                }
                echo json_encode(array("medicine_unit"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_unit"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_unit"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_unit"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineUnit();
    $authenticate->GetAllMedicineUnit();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_unit_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineUnit();
    $authenticate->GetSingleMedicineUnit();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}