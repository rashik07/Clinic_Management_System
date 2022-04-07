<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreatePathologyTest{

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

        $pathology_test_name   = if_empty($_POST['pathology_test_name']);
        $pathology_test_description   = if_empty($_POST['pathology_test_description']);
        $pathology_test_room_no   = if_empty($_POST['pathology_test_room_no']);
        $pathology_test_price   = if_empty($_POST['pathology_test_price']);



        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,5);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $post_content = "INSERT INTO pathology_test (pathology_test_user_added_id,
                            pathology_test_name, pathology_test_description, pathology_test_room_no,
                            pathology_test_price) 
                    VALUES ('$request_user_id','$pathology_test_name','$pathology_test_description',
                            '$pathology_test_room_no','$pathology_test_price')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("pathology_test" => "Successful","pathology_test_id"=>$last_id, $status => 1, $message => "Create Pathology Test Successful"));
                } else {
                    echo json_encode(array("pathology_test" => "Error", $status => 0, $message => "Create Pathology Test Failed"));
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
    $authenticate = new CreatePathologyTest();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}