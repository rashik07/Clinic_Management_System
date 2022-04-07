<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteIndoorBedCategory{

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
        $indoor_bed_category_id   = $_POST['indoor_bed_category_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,4);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE FROM indoor_bed_category WHERE indoor_bed_category_id='$indoor_bed_category_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("indoor_bed_category" => "Successful", $status => 1, $message => "Delete Indoor Bed Category Successful"));
                } else {
                    echo json_encode(array("indoor_bed_category" => "Error", $status => 0, $message => "Delete Indoor Bed Category Failed"));
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
if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed_category"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteIndoorBedCategory();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}