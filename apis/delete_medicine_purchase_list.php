<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class DeleteMedicine
{

    function delete()
    {
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status = "status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $pharmacy_purchase_id   = $_POST['pharmacy_purchase_id'];
        // $pharmacy_medicine_id   = $_POST['pharmacy_medicine_id'];
        $pharmacy_purchase_medicine_medicine_id = $_POST['pharmacy_purchase_medicine_medicine_id'];

        $pharmacy_purchase_medicine_batch_id = $_POST['pharmacy_purchase_medicine_batch_id'];
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 6]);

        if ($check_token && $check_permission) {
            try {
                $delete_content = "DELETE pharmacy_purchase_medicine,pharmacy_purchase FROM pharmacy_purchase_medicine inner join pharmacy_purchase on pharmacy_purchase_medicine.pharmacy_purchase_medicine_purchase_id=pharmacy_purchase.pharmacy_purchase_id  WHERE pharmacy_purchase_medicine_purchase_id='$pharmacy_purchase_id' ";
                $result = $conn->exec($delete_content);



                $get_sum_content = "select  sum(pharmacy_purchase_medicine_total_pieces) as medicine_total_pieces from pharmacy_purchase_medicine 
                
                where pharmacy_purchase_medicine_medicine_id='$pharmacy_purchase_medicine_medicine_id'";
                //echo $get_content;
                $getJson = $conn->prepare($get_sum_content);
                $getJson->execute();
                $result_sum_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                $mtp_pharmacy_purchase_medicine_total_pieces = $result_sum_content[0]['medicine_total_pieces'];


                if ($mtp_pharmacy_purchase_medicine_total_pieces>0) {
                    $post_content = "UPDATE pharmacy_medicine SET pharmacy_medicine_quantity = '$mtp_pharmacy_purchase_medicine_total_pieces'
    where pharmacy_medicine_id='$pharmacy_purchase_medicine_medicine_id' and pharmacy_medicine_batch_id='$pharmacy_purchase_medicine_batch_id' 
      ";

                    //echo $post_content;
                    $result_content = $conn->exec($post_content);
                } 
                else{
                    $post_content = "UPDATE pharmacy_medicine SET pharmacy_medicine_quantity = '0'
                    where pharmacy_medicine_id='$pharmacy_purchase_medicine_medicine_id' and pharmacy_medicine_batch_id='$pharmacy_purchase_medicine_batch_id' 
                      ";
                
                                    //echo $post_content;
                                    $result_content = $conn->exec($post_content);
                }
                // else {
                //     $delete_content = "DELETE FROM  pharmacy_medicine   WHERE pharmacy_medicine_id='$pharmacy_purchase_medicine_medicine_id' ";
                //     $result = $conn->exec($delete_content);
                // }



                if ($result) {
                    echo json_encode(array("medicine" => "Successful", $status => 1, $message => "Delete Medicine Successful"));
                } else {
                    echo json_encode(array("medicine" => "Error", $status => 0, $message => "Delete Medicine Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("medicine" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("medicine" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "medicine_purchase_list"))   // it checks whether the user clicked login button or not
{
    $authenticate = new DeleteMedicine();
    $authenticate->delete();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
