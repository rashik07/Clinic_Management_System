<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdatePathologyTest{

    function post(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $pathology_test_id   = $_POST['pathology_test_id'];
        $token  = $_POST['token'];

        $pathology_test_name   = if_empty($_POST['pathology_test_name']);
        $pathology_test_description   = if_empty($_POST['pathology_test_description']);
        $pathology_test_room_no   = if_empty($_POST['pathology_test_room_no']);
        $pathology_test_price   = if_empty($_POST['pathology_test_price']);

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,5);

        if($check_token && $check_permission)
        {
            try {

                $post_content = "UPDATE pathology_test SET pathology_test_name = '$pathology_test_name',
                    pathology_test_description = '$pathology_test_description',
                    pathology_test_room_no = '$pathology_test_room_no',
                    pathology_test_price = '$pathology_test_price'
                 where pathology_test_id='$pathology_test_id'";

                //echo $post_content;
                $result = $conn->exec($post_content);
                if ($result) {
                    echo json_encode(array("pathology_test" => "Successful", $status => 1, $message => "Update Pathology Test Successful"));
                } else {
                    echo json_encode(array("pathology_test" => "Error", $status => 0, $message => "Update Pathology Test Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("pathology_test"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("pathology_test"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "pathology_test"))
{
    $authenticate = new UpdatePathologyTest();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}