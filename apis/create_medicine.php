<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateMedicine{

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

        $medicine_name  = if_empty($_POST['medicine_name']);
        $medicine_generic_name   = if_empty($_POST['medicine_generic_name']);
        $medicine_description   = if_empty($_POST['medicine_description']);
        $medicine_purchase_price  = if_empty($_POST['medicine_purchase_price']);
        $medicine_selling_price   = if_empty($_POST['medicine_selling_price']);
        // $medicine_category = $_POST['medicine_category'];
        $medicine_unit   = $_POST['medicine_unit'];
        // $medicine_type   = $_POST['medicine_type'];
        $medicine_leaf   = $_POST['medicine_leaf'];
        $medicine_manufacturer   = $_POST['medicine_manufacturer'];

        $medicine_status   = if_empty($_POST['medicine_status']);

        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $post_content = "INSERT INTO medicine (medicine_user_added_id, medicine_name, medicine_generic_name,
                                   medicine_description,medicine_purchase_price,medicine_selling_price,
                                   medicine_unit,medicine_leaf,
                                   medicine_manufacturer, medicine_status) 
                    VALUES ('$request_user_id','$medicine_name','$medicine_generic_name', '$medicine_description',
                            '$medicine_purchase_price','$medicine_selling_price',
                            '$medicine_unit', '$medicine_leaf',
                            '$medicine_manufacturer' , '$medicine_status')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("medicine" => "Successful","medicine_id"=>$last_id, $status => 1, $message => "Create Medicine Successful"));
                } else {
                    echo json_encode(array("medicine" => "Error", $status => 0, $message => "Create Medicine Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("medicine"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("medicine"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "medicine"))
{
    $authenticate = new CreateMedicine();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}