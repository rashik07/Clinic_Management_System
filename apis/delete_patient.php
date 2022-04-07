<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeletePatient{

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
        $patient_id   = $_POST['patient_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,3);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE FROM patient WHERE patient_id='$patient_id'";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("patient" => "Successful", $status => 1, $message => "Delete Patient Successful"));
                } else {
                    echo json_encode(array("patient" => "Error", $status => 0, $message => "Delete Patient Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("patient"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("patient"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
}
if(isset($_POST['content']) && ($_POST['content'] == "patient"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeletePatient();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}