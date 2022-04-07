<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdateIndoorBed{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $indoor_bed_id  = if_empty($_POST['indoor_bed_id']);
        $token  = $_POST['token'];

        $indoor_bed_name  = if_empty($_POST['indoor_bed_name']);
        $indoor_bed_price  = if_empty($_POST['indoor_bed_price']);
        $indoor_bed_room_no  = if_empty($_POST['indoor_bed_room_no']);
        $indoor_bed_status  = if_empty($_POST['indoor_bed_status']);

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,4);

        if($check_token && $check_permission)
        {
            try {

                $post_content = "UPDATE indoor_bed SET indoor_bed_name = '$indoor_bed_name',
                    indoor_bed_price = '$indoor_bed_price', 
                    indoor_bed_room_no = '$indoor_bed_room_no',
                    indoor_bed_status = '$indoor_bed_status'
                    where indoor_bed_id='$indoor_bed_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("indoor_bed" => "Successful", $status => 1, $message => "Update Indoor Bed Successful"));
                } else {
                    echo json_encode(array("indoor_bed" => "Error", $status => 0, $message => "Update Indoor Bed Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed"))
{
    $authenticate = new UpdateIndoorBed();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}