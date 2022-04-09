<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateMedicine{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $medicine_id  = $_POST['medicine_id'];
        $token  = $_POST['token'];

        $medicine_name  = if_empty($_POST['medicine_name']);
        $medicine_generic_name   = if_empty($_POST['medicine_generic_name']);
        $medicine_description   = if_empty($_POST['medicine_description']);
        $medicine_quantity   = if_empty($_POST['medicine_quantity']);
        $medicine_purchase_price  = if_empty($_POST['medicine_purchase_price']);
        $medicine_selling_price   = if_empty($_POST['medicine_selling_price']);
        $medicine_vat   = if_empty($_POST['medicine_vat']);
        $medicine_batch_id   = if_empty($_POST['medicine_batch_id']);

        $medicine_exp_date   = if_empty($_POST['medicine_exp_date']);

        $medicine_category   = $_POST['medicine_category'];
        $medicine_unit   = $_POST['medicine_unit'];
        $medicine_type   = $_POST['medicine_type'];
        $medicine_leaf   = $_POST['medicine_leaf'];
        $medicine_manufacturer   = $_POST['medicine_manufacturer'];

        $medicine_status  = if_empty($_POST['medicine_status']);


        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);

        if($check_token && $check_permission)
        {
            try {

                $post_content = "UPDATE medicine SET medicine_name = '$medicine_name',
                    medicine_generic_name = '$medicine_generic_name', medicine_description='$medicine_description',
                    medicine_purchase_price = '$medicine_purchase_price', medicine_selling_price = '$medicine_selling_price',
                    medicine_category = '$medicine_category', medicine_unit = '$medicine_unit',
                    medicine_type = '$medicine_type', medicine_leaf = '$medicine_leaf',
                    medicine_manufacturer = '$medicine_manufacturer', medicine_status = '$medicine_status'
                    where medicine_id='$medicine_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("medicine" => "Successful", $status => 1, $message => "Update Medicine Successful"));
                } else {
                    echo json_encode(array("medicine" => "Error", $status => 0, $message => "Update Medicine Failed"));
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
    $authenticate = new UpdateMedicine();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}