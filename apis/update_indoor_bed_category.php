<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateIndoorBedCategory{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $indoor_bed_category_id  = if_empty($_POST['indoor_bed_category_id']);
        $token  = $_POST['token'];

        $indoor_bed_category_name  = if_empty($_POST['indoor_bed_category_name']);
        $indoor_bed_category_description  = if_empty($_POST['indoor_bed_category_description']);

        $indoor_bed_category_status   = if_empty($_POST['indoor_bed_category_status']);
        //echo $outdoor_patient_discharge_time;
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,[1,2,3,4]);

        if($check_token && $check_permission)
        {
            try {

                $post_content = "UPDATE indoor_bed_category SET indoor_bed_category_name = '$indoor_bed_category_name',
                    indoor_bed_category_description = '$indoor_bed_category_description',
                    indoor_bed_category_status = '$indoor_bed_category_status'
                    where indoor_bed_category_id='$indoor_bed_category_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("indoor_bed_category" => "Successful", $status => 1, $message => "Update Indoor Bed Category Successful"));
                } else {
                    echo json_encode(array("indoor_bed_category" => "Error", $status => 0, $message => "Update Indoor Bed Category Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("indoor_bed_category"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_bed_category"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed_category"))
{
    $authenticate = new UpdateIndoorBedCategory();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}