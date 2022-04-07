<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateMedicineManufacturer{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token  = $_POST['token'];

        $medicine_manufacturer_name   = if_empty($_POST['medicine_manufacturer_name']);
        $medicine_manufacturer_address   = if_empty($_POST['medicine_manufacturer_address']);
        $medicine_manufacturer_mobile   = if_empty($_POST['medicine_manufacturer_mobile']);
        $medicine_manufacturer_email   = if_empty($_POST['medicine_manufacturer_email']);
        $medicine_manufacturer_city  = if_empty($_POST['medicine_manufacturer_city']);
        $medicine_manufacturer_state   = if_empty($_POST['medicine_manufacturer_state']);
        $medicine_manufacturer_description   = if_empty($_POST['medicine_manufacturer_description']);



        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $post_content = "INSERT INTO medicine_manufacturer (medicine_manufacturer_user_added_id,
                                   medicine_manufacturer_name,medicine_manufacturer_address,medicine_manufacturer_mobile,
                               medicine_manufacturer_email,medicine_manufacturer_city,medicine_manufacturer_state,
                                   medicine_manufacturer_description) 
                    VALUES ('$request_user_id','$medicine_manufacturer_name','$medicine_manufacturer_address',
                            '$medicine_manufacturer_mobile','$medicine_manufacturer_email','$medicine_manufacturer_city',
                            '$medicine_manufacturer_state', '$medicine_manufacturer_description')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("medicine_manufacturer" => "Successful","medicine_manufacturer_id"=>$last_id, $status => 1, $message => "Create Medicine Manufacturer Successful"));
                } else {
                    echo json_encode(array("medicine_manufacturer" => "Error", $status => 0, $message => "Create Medicine Manufacturer Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_manufacturer"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_manufacturer"))
{
    $authenticate = new CreateMedicineManufacturer();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}