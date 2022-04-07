<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicineManufacturer{

    function GetAllMedicineManufacturer(){
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
            $get_content = "select * from medicine_manufacturer";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_manufacturer_id'=>$data['medicine_manufacturer_id'],
                            'medicine_manufacturer_user_added_id'=>$data['medicine_manufacturer_user_added_id'],
                            'medicine_manufacturer_name'=>$data['medicine_manufacturer_name'],
                            'medicine_manufacturer_address'=>$data['medicine_manufacturer_address'],
                            'medicine_manufacturer_mobile'=>$data['medicine_manufacturer_mobile'],
                            'medicine_manufacturer_email'=>$data['medicine_manufacturer_email'],
                            'medicine_manufacturer_city'=>$data['medicine_manufacturer_city'],
                            'medicine_manufacturer_state'=>$data['medicine_manufacturer_state'],
                            'medicine_manufacturer_description'=>$data['medicine_manufacturer_description'],
                            'medicine_manufacturer_creation_time'=>$data['medicine_manufacturer_creation_time'],
                            'medicine_manufacturer_modification_time'=>$data['medicine_manufacturer_modification_time']

                        ));
                }
                echo json_encode(array("medicine_manufacturer"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicineManufacturer(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_manufacturer_id   = $_POST['medicine_manufacturer_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine_manufacturer where medicine_manufacturer_id='$medicine_manufacturer_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_manufacturer_id'=>$data['medicine_manufacturer_id'],
                            'medicine_manufacturer_user_added_id'=>$data['medicine_manufacturer_user_added_id'],
                            'medicine_manufacturer_name'=>$data['medicine_manufacturer_name'],
                            'medicine_manufacturer_address'=>$data['medicine_manufacturer_address'],
                            'medicine_manufacturer_mobile'=>$data['medicine_manufacturer_mobile'],
                            'medicine_manufacturer_email'=>$data['medicine_manufacturer_email'],
                            'medicine_manufacturer_city'=>$data['medicine_manufacturer_city'],
                            'medicine_manufacturer_state'=>$data['medicine_manufacturer_state'],
                            'medicine_manufacturer_description'=>$data['medicine_manufacturer_description'],
                            'medicine_manufacturer_creation_time'=>$data['medicine_manufacturer_creation_time'],
                            'medicine_manufacturer_modification_time'=>$data['medicine_manufacturer_modification_time']

                        ));
                }
                echo json_encode(array("medicine_manufacturer"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_manufacturer"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineManufacturer();
    $authenticate->GetAllMedicineManufacturer();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_manufacturer_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineManufacturer();
    $authenticate->GetSingleMedicineManufacturer();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}