<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class UpdatePathologyInvestigation{

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
        $pathology_investigation_id = $_POST['pathology_investigation_id'];
        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,1) || $token_generator->check_permission($request_user_id,$conn,2);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $pathology_investigation_patient_id  = if_empty($_POST['pathology_investigation_patient_id']);
                $pathology_investigation_patient_name = if_empty($_POST['pathology_investigation_patient_name']);
                $pathology_investigation_date = $_POST['pathology_investigation_date'];

                $pathology_investigation_total_bill  = if_empty($_POST['pathology_investigation_total_bill']);
                $pathology_investigation_discount_pc   = if_empty($_POST['pathology_investigation_discount_pc']);
                $pathology_investigation_total_bill_after_discount  = if_empty($_POST['pathology_investigation_total_bill_after_discount']);
                $pathology_investigation_total_paid= if_empty($_POST['pathology_investigation_total_paid']);
                $pathology_investigation_total_due  = if_empty($_POST['pathology_investigation_total_due']);
                $pathology_investigation_payment_type   = if_empty($_POST['pathology_investigation_payment_type']);
                $pathology_investigation_payment_type_no  = if_empty($_POST['pathology_investigation_payment_type_no']);
                $pathology_investigation_note   = if_empty($_POST['pathology_investigation_note']);

                $pathology_test_id = if_empty($_POST['pathology_test_id']);
                $pathology_test_room_no   = if_empty($_POST['pathology_test_room_no']);
                $pathology_investigation_test_price = if_empty($_POST['pathology_investigation_test_price']);
                $pathology_investigation_test_quantity = if_empty($_POST['pathology_investigation_test_quantity']);
                $pathology_investigation_test_total_bill  = if_empty($_POST['pathology_investigation_test_total_bill']);

                $post_content = "UPDATE pathology_investigation SET
                                    pathology_investigation_patient_id = '$pathology_investigation_patient_id',
                                    pathology_investigation_total_bill = '$pathology_investigation_total_bill',
                                    pathology_investigation_total_bill_after_discount = '$pathology_investigation_total_bill_after_discount',
                                    pathology_investigation_discount_pc = '$pathology_investigation_discount_pc',
                                    pathology_investigation_total_paid = '$pathology_investigation_total_paid',
                                    pathology_investigation_total_due = '$pathology_investigation_total_due',
                                    pathology_investigation_payment_type = '$pathology_investigation_payment_type',
                                    pathology_investigation_payment_type_no = '$pathology_investigation_payment_type_no',
                                    pathology_investigation_note = '$pathology_investigation_note',
                                    pathology_investigation_date = '$pathology_investigation_date'
                                where pathology_investigation_id = '$pathology_investigation_id'";
                //echo $post_content;
                $result = $conn->exec($post_content);

                $delete_content = "DELETE FROM pathology_investigation_test WHERE pathology_investigation_test_investigation_id='$pathology_investigation_id'";
                $result = $conn->exec($delete_content);


                $count_service =0;
                foreach( $pathology_test_id as $rowservice) {

                    $test_id  = $pathology_test_id[$count_service];
                    $room_no  = $pathology_test_room_no[$count_service];
                    $test_price  = $pathology_investigation_test_price[$count_service];
                    $test_quantity = $pathology_investigation_test_quantity[$count_service];
                    $total_bill  = $pathology_investigation_test_total_bill[$count_service];

                    $post_content = "INSERT INTO pathology_investigation_test (pathology_investigation_test_user_added_id,
                                          pathology_investigation_test_investigation_id,
                                          pathology_investigation_test_pathology_test_id, 
                                          pathology_investigation_test_room_no,
                                          pathology_investigation_test_price,
                                          pathology_investigation_test_quantity,
                                          pathology_investigation_test_total_bill) 
                    VALUES ('$request_user_id','$pathology_investigation_id','$test_id','$room_no',
                            '$test_price','$test_quantity','$total_bill')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result) {
                    echo json_encode(array("pathology_investigation" => "Successful","indoor_treatment_id"=>$pathology_investigation_id, $status => 1, $message => "Update Pathology Investigation Successful"));
                } else {
                    echo json_encode(array("pathology_investigation" => "Error", $status => 0, $message => "Update Pathology Investigation Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("pathology_investigation"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("pathology_investigation"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "pathology_investigation"))
{
    $authenticate = new UpdatePathologyInvestigation();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}