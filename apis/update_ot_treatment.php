<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreteOTTreatment{

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

        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,1) || $token_generator->check_permission($request_user_id,$conn,2);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $ot_treatment_id  = $_POST['ot_treatment_id'];

                $ot_treatment_patient_id  = if_empty($_POST['ot_treatment_patient_id']);
                $ot_treatment_patient_name = if_empty($_POST['ot_treatment_patient_name']);
                
                $ot_treatment_total_bill  = if_empty($_POST['ot_treatment_total_bill']);
                $ot_treatment_discount_pc   = if_empty($_POST['ot_treatment_discount_pc']);
                $ot_treatment_total_bill_after_discount  = if_empty($_POST['ot_treatment_total_bill_after_discount']);
                $ot_treatment_total_paid = if_empty($_POST['ot_treatment_total_paid']);
                $ot_treatment_total_due  = if_empty($_POST['ot_treatment_total_due']);
                $ot_treatment_total_due = $ot_treatment_total_due == NULL || !isset($ot_treatment_total_due)  || empty($ot_treatment_total_due) ? 0 : $ot_treatment_total_due;

                $ot_treatment_payment_type   = if_empty($_POST['ot_treatment_payment_type']);
                $ot_treatment_payment_type_no  = if_empty($_POST['ot_treatment_payment_type_no']);
                $ot_treatment_note   = if_empty($_POST['ot_treatment_note']);

                $ot_treatment_doctor_doctor_id = if_empty($_POST['ot_treatment_doctor_doctor_id']);
                $ot_treatment_doctor_bill   = if_empty($_POST['ot_treatment_doctor_bill']);
                $ot_treatment_doctor_note  = if_empty($_POST['ot_treatment_doctor_note']);               

                $ot_treatment_guest_doctor_doctor_name = if_empty($_POST['ot_treatment_guest_doctor_doctor_name']);
                $ot_treatment_guest_doctor_bill  = if_empty($_POST['ot_treatment_guest_doctor_bill']);
                $ot_treatment_guest_doctor_note = if_empty($_POST['ot_treatment_guest_doctor_note']);
                
                $ot_treatment_item_name = if_empty($_POST['ot_treatment_item_name']);
                $ot_treatment_item_price = if_empty($_POST['ot_treatment_item_price']);
                $ot_treatment_item_note = if_empty($_POST['ot_treatment_item_note']);

                $ot_treatment_pharmacy_item_medicine_id = if_empty($_POST['ot_treatment_pharmacy_item_medicine_id']);
                $ot_treatment_pharmacy_item_batch_id = if_empty($_POST['ot_treatment_pharmacy_item_batch_id']);
                $ot_treatment_pharmacy_item_stock_qty = if_empty($_POST['ot_treatment_pharmacy_item_stock_qty']);
                $ot_treatment_pharmacy_item_per_piece_price = if_empty($_POST['ot_treatment_pharmacy_item_per_piece_price']);
                $ot_treatment_pharmacy_item_quantity = if_empty($_POST['ot_treatment_pharmacy_item_quantity']);
                $ot_treatment_pharmacy_item_bill = if_empty($_POST['ot_treatment_pharmacy_item_bill']);
                $ot_treatment_pharmacy_item_note = if_empty($_POST['ot_treatment_pharmacy_item_note']);

                // update indoor treatment
                    $post_content = "UPDATE ot_treatment SET 
                        ot_treatment_total_bill='$ot_treatment_total_bill',
                        ot_treatment_total_bill_after_discount='$ot_treatment_total_bill_after_discount',
                        ot_treatment_discount_pc='$ot_treatment_discount_pc',
                        ot_treatment_total_paid='$ot_treatment_total_paid',
                        ot_treatment_total_due='$ot_treatment_total_due',
                        ot_treatment_payment_type='$ot_treatment_payment_type',
                        ot_treatment_payment_type_no='$ot_treatment_payment_type_no',
                        ot_treatment_note='$ot_treatment_note'
                        where ot_treatment_id='$ot_treatment_id'";
                //echo $post_content;
                $result = $conn->exec($post_content);
                
                $delete_content = "DELETE FROM ot_treatment_doctor WHERE ot_treatment_doctor_treatment_id='$ot_treatment_id'";
                $result = $conn->exec($delete_content);
                // inserting treatment-doctor
                $count_service =0;
                foreach($ot_treatment_doctor_doctor_id as $rowservice) {

                    $doctor_id  = $ot_treatment_doctor_doctor_id[$count_service];
                    $doctor_bill  = $ot_treatment_doctor_bill[$count_service];
                    $doctor_note  = $ot_treatment_doctor_note[$count_service];

                    //insert treatment-bed
                    $post_content = "INSERT INTO ot_treatment_doctor (ot_treatment_doctor_user_added_id,
                                  ot_treatment_doctor_treatment_id, ot_treatment_doctor_doctor_id,
                                  ot_treatment_doctor_bill,ot_treatment_doctor_note) 
                    VALUES ('$request_user_id','$ot_treatment_id','$doctor_id','$doctor_bill','$doctor_note')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM ot_treatment_guest_doctor WHERE ot_treatment_guest_doctor_treatment_id='$ot_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach( $ot_treatment_guest_doctor_doctor_name as $rowservice) {

                    $doctor_name  = $ot_treatment_guest_doctor_doctor_name[$count_service];
                    $doctor_bill  = $ot_treatment_guest_doctor_bill[$count_service];
                    $doctor_note  = $ot_treatment_guest_doctor_note[$count_service];
                   
                    $post_content = "INSERT INTO ot_treatment_guest_doctor (ot_treatment_guest_doctor_user_added_id,
                                     ot_treatment_guest_doctor_treatment_id, ot_treatment_guest_doctor_doctor_name,
                                     ot_treatment_guest_doctor_bill,ot_treatment_guest_doctor_note) 
                    VALUES ('$request_user_id','$ot_treatment_id','$doctor_name','$doctor_bill', '$doctor_note')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM ot_treatment_item WHERE ot_treatment_item_treatment_id='$ot_treatment_id'";
                $result = $conn->exec($delete_content);

                $count_service =0;
                foreach( $ot_treatment_item_name as $rowservice) {

                    $item_name  = $ot_treatment_item_name[$count_service];
                    $item_bill  = $ot_treatment_item_price[$count_service];
                    $item_note  = $ot_treatment_item_note[$count_service];
                   
                    $post_content = "INSERT INTO ot_treatment_item (ot_treatment_item_user_added_id,
                                     ot_treatment_item_treatment_id, ot_treatment_item_name,
                                     ot_treatment_item_price,ot_treatment_item_note) 
                    VALUES ('$request_user_id','$ot_treatment_id','$item_name','$item_bill', '$item_note')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM ot_treatment_pharmacy_item WHERE ot_treatment_pharmacy_item_treatment_id='$ot_treatment_id'";
                $result = $conn->exec($delete_content);

                $count_service =0;
                foreach( $ot_treatment_pharmacy_item_medicine_id as $rowservice) {

                    $medicine_id  = $ot_treatment_pharmacy_item_medicine_id[$count_service];
                    $batch_id  = $ot_treatment_pharmacy_item_batch_id[$count_service];
                    $stock_qty  = $ot_treatment_pharmacy_item_stock_qty[$count_service];
                    $per_piece_price  = $ot_treatment_pharmacy_item_per_piece_price[$count_service];
                    $item_qty  = $ot_treatment_pharmacy_item_quantity[$count_service];
                    $item_bill  = $ot_treatment_pharmacy_item_bill[$count_service];
                    $item_note  = $ot_treatment_pharmacy_item_note[$count_service];

                    $post_content = "INSERT INTO ot_treatment_pharmacy_item (ot_treatment_pharmacy_item_user_added_id,
                                     ot_treatment_pharmacy_item_treatment_id, ot_treatment_pharmacy_item_medicine_id,
                                     ot_treatment_pharmacy_item_batch_id, ot_treatment_pharmacy_item_stock_qty,
                                     ot_treatment_pharmacy_item_per_piece_price, ot_treatment_pharmacy_item_quantity,
                                     ot_treatment_pharmacy_item_bill, ot_treatment_pharmacy_item_note) 
                    VALUES ('$request_user_id','$ot_treatment_id', '$medicine_id', '$batch_id', '$stock_qty', '$per_piece_price', '$item_qty', '$item_bill', '$item_note')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result) {
                    echo json_encode(array("ot_treatment" => "Successful","ot_treatment_id"=>$ot_treatment_id, $status => 1, $message => "Update OT Treatment Successful"));
                } else {
                    echo json_encode(array("ot_treatment" => "Error", $status => 0, $message => "Update OT Treatment Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("ot_treatment"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("ot_treatment"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "ot_allotment"))
{
    $authenticate = new CreteOTTreatment();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}