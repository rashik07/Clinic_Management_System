<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeletePathologyTest{

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
        $pathology_test_id   = $_POST['pathology_test_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,5);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE FROM pathology_test WHERE pathology_test_id='$pathology_test_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("pathology_test" => "Successful", $status => 1, $message => "Delete Pathology Test Successful"));
                } else {
                    echo json_encode(array("pathology_test" => "Error", $status => 0, $message => "Delete Pathology Test Failed"));
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
if(isset($_POST['content']) && ($_POST['content'] == "pathology_test"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeletePathologyTest();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}