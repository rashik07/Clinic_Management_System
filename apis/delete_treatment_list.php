<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteOutdoorService{

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
        $outdoor_service_id  = $_POST['treatment_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,3);
        // DELETE T1, T2
        // FROM T1
        // INNER JOIN T2 ON T1.key = T2.key
        // WHERE condition;
        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE outdoor_treatment_service,outdoor_treatment FROM outdoor_treatment_service inner join outdoor_treatment on outdoor_treatment_service.outdoor_treatment_service_treatment_id=outdoor_treatment.outdoor_treatment_id  WHERE outdoor_treatment_service_treatment_id='$outdoor_service_id' 
                ";
                $result = $conn->exec($delete_content);
                if ($result) {
                    echo json_encode(array("outdoor_treatment" => "Successful", $status => 1, $message => "Delete Outdoor Service Successful"));
                } else {
                    echo json_encode(array("outdoor_treatment" => "Error", $status => 0, $message => "Delete Outdoor Service Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("outdoor_treatment"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("outdoor_treatment"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
}
if(isset($_POST['content']) && ($_POST['content'] == "outdoor_treatment"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteOutdoorService();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}