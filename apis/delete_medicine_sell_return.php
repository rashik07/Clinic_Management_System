<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class DeleteMedicineReturn{

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
        $pharmacy_sell_return_id   = $_POST['pharmacy_sell_return_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,[1,2,6]);

        if($check_token && $check_permission)
        {
            try{
                $delete_content = "DELETE pharmacy_sell_medicine_return,pharmacy_sell_return FROM pharmacy_sell_medicine_return inner join pharmacy_sell_return on pharmacy_sell_medicine_return.pharmacy_sell_medicine_return_sell_id=pharmacy_sell_return.pharmacy_sell_return_id  WHERE pharmacy_sell_medicine_return_sell_id='$pharmacy_sell_return_id' ";
                $result = $conn->exec($delete_content);

                
                if ($result  ) {
                    echo json_encode(array("medicine" => "Successful", $status => 1, $message => "Delete Medicine Successful"));
                } else {
                    echo json_encode(array("medicine" => "Error", $status => 0, $message => "Delete Medicine Failed"));
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
if(isset($_POST['content']) && ($_POST['content'] == "medicine_sell_return_list"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteMedicineReturn();
    $authenticate->delete();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}