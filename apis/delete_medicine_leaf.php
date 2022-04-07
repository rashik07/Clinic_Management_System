<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteMedicineLeaf{

    function delete(){
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
        $check_permission = $token_generator->check_permission($request_user_id,$conn,6);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE FROM medicine_leaf WHERE medicine_leaf_id='$medicine_leaf_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("medicine_leaf" => "Successful", $status => 1, $message => "Delete Medicine Leaf Successful"));
                } else {
                    echo json_encode(array("medicine_leaf" => "Error", $status => 0, $message => "Delete Medicine Leaf Failed"));
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
if(isset($_POST['content']) && ($_POST['content'] == "medicine_leaf"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteMedicineLeaf();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}