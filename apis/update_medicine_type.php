<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateMedicineType{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $medicine_type_id   = $_POST['medicine_type_id'];
        $token  = $_POST['token'];

        $medicine_type_name   = if_empty($_POST['medicine_type_name']);
        $medicine_type_description   = if_empty($_POST['medicine_type_description']);

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);

        if($check_token && $check_permission)
        {
            try {

                $post_content = "UPDATE medicine_type SET medicine_type_name = '$medicine_type_name',
                    medicine_type_description = '$medicine_type_description'
                 where medicine_type_id='$medicine_type_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("medicine_type" => "Successful", $status => 1, $message => "Update Medicine Type Successful"));
                } else {
                    echo json_encode(array("medicine_type" => "Error", $status => 0, $message => "Update Medicine Type Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("medicine_type"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_type"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_type"))
{
    $authenticate = new UpdateMedicineType();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}