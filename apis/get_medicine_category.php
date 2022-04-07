<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicineCategory{

    function GetAllMedicineCategory(){
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
            $get_content = "select * from medicine_category";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_category_id'=>$data['medicine_category_id'],
                            'medicine_category_user_added_id'=>$data['medicine_category_user_added_id'],
                            'medicine_category_name'=>$data['medicine_category_name'],
                            'medicine_category_description'=>$data['medicine_category_description'],
                            'medicine_category_creation_time'=>$data['medicine_category_creation_time'],
                            'medicine_category_modification_time'=>$data['medicine_category_modification_time']

                        ));
                }
                echo json_encode(array("medicine_category"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_category"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_category"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicineCategory(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_category_id   = $_POST['medicine_category_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine_category where medicine_category_id='$medicine_category_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_category_id'=>$data['medicine_category_id'],
                            'medicine_category_user_added_id'=>$data['medicine_category_user_added_id'],
                            'medicine_category_name'=>$data['medicine_category_name'],
                            'medicine_category_description'=>$data['medicine_category_description'],
                            'medicine_category_creation_time'=>$data['medicine_category_creation_time'],
                            'medicine_category_modification_time'=>$data['medicine_category_modification_time']

                        ));
                }
                echo json_encode(array("medicine_category"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_category"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_category"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_category"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineCategory();
    $authenticate->GetAllMedicineCategory();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_category_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineCategory();
    $authenticate->GetSingleMedicineCategory();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}