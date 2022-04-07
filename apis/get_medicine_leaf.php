<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicineLeaf{

    function GetAllMedicineLeaf(){
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
            $get_content = "select * from medicine_leaf";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_leaf_id'=>$data['medicine_leaf_id'],
                            'medicine_leaf_user_added_id'=>$data['medicine_leaf_user_added_id'],
                            'medicine_leaf_name'=>$data['medicine_leaf_name'],
                            'medicine_leaf_description'=>$data['medicine_leaf_description'],
                            'medicine_leaf_total_per_box'=>$data['medicine_leaf_total_per_box'],
                            'medicine_leaf_creation_time'=>$data['medicine_leaf_creation_time'],
                            'medicine_leaf_modification_time'=>$data['medicine_leaf_modification_time']

                        ));
                }
                echo json_encode(array("medicine_leaf"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicineLeaf(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_leaf_id   = $_POST['medicine_leaf_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine_leaf where medicine_leaf_id='$medicine_leaf_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_leaf_id'=>$data['medicine_leaf_id'],
                            'medicine_leaf_user_added_id'=>$data['medicine_leaf_user_added_id'],
                            'medicine_leaf_name'=>$data['medicine_leaf_name'],
                            'medicine_leaf_description'=>$data['medicine_leaf_description'],
                            'medicine_leaf_total_per_box'=>$data['medicine_leaf_total_per_box'],
                            'medicine_leaf_creation_time'=>$data['medicine_leaf_creation_time'],
                            'medicine_leaf_modification_time'=>$data['medicine_leaf_modification_time']

                        ));
                }
                echo json_encode(array("medicine_leaf"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_leaf"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineLeaf();
    $authenticate->GetAllMedicineLeaf();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_leaf_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicineLeaf();
    $authenticate->GetSingleMedicineLeaf();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}