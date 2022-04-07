<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateMedicineLeaf{

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

        $medicine_leaf_name   = if_empty($_POST['medicine_leaf_name']);
        $medicine_leaf_description   = if_empty($_POST['medicine_leaf_description']);
        $medicine_leaf_total_per_box   = if_empty($_POST['medicine_leaf_total_per_box']);



        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $post_content = "INSERT INTO medicine_leaf (medicine_leaf_user_added_id, medicine_leaf_name,
                               medicine_leaf_description, medicine_leaf_total_per_box) 
                    VALUES ('$request_user_id','$medicine_leaf_name','$medicine_leaf_description', '$medicine_leaf_total_per_box')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("medicine_leaf" => "Successful","medicine_leaf_id"=>$last_id, $status => 1, $message => "Create Medicine Leaf Successful"));
                } else {
                    echo json_encode(array("medicine_leaf" => "Error", $status => 0, $message => "Create Medicine Leaf Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("medicine_leaf"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "medicine_leaf"))
{
    $authenticate = new CreateMedicineLeaf();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}