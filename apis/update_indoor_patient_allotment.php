<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class UpdateIndoorPatientAllotment{

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

        $indoor_treatment_id = $_POST['indoor_treatment_id'];
        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,1) || $token_generator->check_permission($request_user_id,$conn,2);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $indoor_patient_id  = if_empty($_POST['outdoor_patient_id']);
                $indoor_patient_name = if_empty($_POST['outdoor_patient_name']);
                $indoor_treatment_admission_date = if_empty($_POST['indoor_treatment_admission_date']);
                $indoor_treatment_referer_doctor_id = if_emptyNull($_POST['indoor_treatment_referer_doctor_id']);

                $indoor_treatment_total_bill  = if_empty0($_POST['indoor_treatment_total_bill']);
                $indoor_treatment_service_charge  = if_empty0($_POST['indoor_treatment_service_charge']);
                $indoor_treatment_discount_pc   = if_empty0($_POST['indoor_treatment_discount_pc']);
                $indoor_treatment_total_bill_after_discount  = if_empty0($_POST['indoor_treatment_total_bill_after_discount']);
                $indoor_treatment_total_paid  = if_empty0($_POST['indoor_treatment_total_paid']);
                $indoor_treatment_total_due  = if_empty0($_POST['indoor_treatment_total_due']);
                $indoor_treatment_payment_type   = if_empty($_POST['indoor_treatment_payment_type']);
                $indoor_treatment_payment_type_no  = if_empty($_POST['indoor_treatment_payment_type_no']);
                $indoor_treatment_note   = if_empty($_POST['indoor_treatment_note']);

                $indoor_patient_bed_bed_id = if_empty($_POST['indoor_patient_bed_bed_id']);
                $indoor_bed_category_name   = if_empty($_POST['indoor_bed_category_name']);
                $indoor_bed_price  = if_empty($_POST['indoor_bed_price']);
                $indoor_bed_total_bill  = if_empty($_POST['bed_total_bill']);
                $indoor_patient_bed_entry_time  = if_empty($_POST['indoor_patient_bed_entry_time']);
                $indoor_patient_bed_discharge_time = if_empty($_POST['indoor_patient_bed_discharge_time']);

                $indoor_patient_doctor_doctor_id = $_POST['indoor_patient_doctor_doctor_id'];
                $indoor_doctor_specialization  = $_POST['doctor_specialization'];
                $indoor_doctor_visit_fee = $_POST['doctor_visit_fee'];
                $indoor_doctor_total_bill = $_POST['doctor_total_bill'];
                $indoor_patient_doctor_entry_time = $_POST['indoor_patient_doctor_entry_time'];
                $indoor_patient_doctor_discharge_time = $_POST['indoor_patient_doctor_discharge_time'];

                $outdoor_service_id = if_empty($_POST['outdoor_service_id']);
                $outdoor_service_quantity  = if_empty($_POST['outdoor_service_quantity']);
                $outdoor_service_rate  = if_empty($_POST['outdoor_service_rate']);
                $outdoor_service_total  = if_empty($_POST['outdoor_service_total']);

                $pathology_test_id = if_empty($_POST['pathology_test_id']);
                $pathology_test_room_no   = if_empty($_POST['pathology_test_room_no']);
                $pathology_investigation_test_price = if_empty($_POST['pathology_investigation_test_price']);
                $pathology_investigation_test_quantity = if_empty($_POST['pathology_investigation_test_quantity']);
                $pathology_investigation_test_total_bill  = if_empty($_POST['pathology_investigation_test_total_bill']);

                $ot_treatment_pharmacy_item_medicine_id = if_empty($_POST['ot_treatment_pharmacy_item_medicine_id']);
                $ot_treatment_pharmacy_item_batch_id = if_empty($_POST['ot_treatment_pharmacy_item_batch_id']);
                $ot_treatment_pharmacy_item_stock_qty = if_empty($_POST['ot_treatment_pharmacy_item_stock_qty']);
                $ot_treatment_pharmacy_item_per_piece_price = if_empty($_POST['ot_treatment_pharmacy_item_per_piece_price']);
                $ot_treatment_pharmacy_item_quantity = if_empty($_POST['ot_treatment_pharmacy_item_quantity']);
                $ot_treatment_pharmacy_item_bill = if_empty($_POST['ot_treatment_pharmacy_item_bill']);
                $ot_treatment_pharmacy_item_note = if_empty($_POST['ot_treatment_pharmacy_item_note']);

                $ot_treatment_item_name = if_empty($_POST['ot_treatment_item_name']);
                $ot_treatment_item_price = if_empty($_POST['ot_treatment_item_price']);
                $ot_treatment_item_qty = if_empty($_POST['ot_treatment_item_qty']);
                $ot_treatment_item_total = if_empty($_POST['ot_treatment_item_total']);
                $ot_treatment_item_note = if_empty($_POST['ot_treatment_item_note']);

                $post_content = "UPDATE indoor_treatment SET 
                            indoor_treatment_total_bill='$indoor_treatment_total_bill',
                            indoor_treatment_total_bill_after_discount='$indoor_treatment_total_bill_after_discount',
                            indoor_treatment_discount_pc='$indoor_treatment_discount_pc',
                            indoor_treatment_total_paid='$indoor_treatment_total_paid',
                            indoor_treatment_total_due='$indoor_treatment_total_due',
                            indoor_treatment_payment_type='$indoor_treatment_payment_type',
                            indoor_treatment_payment_type_no='$indoor_treatment_payment_type_no',
                            indoor_treatment_note='$indoor_treatment_note',
                            indoor_treatment_admission_date='$indoor_treatment_admission_date',
                            indoor_treatment_referer_doctor_id=$indoor_treatment_referer_doctor_id,
                            indoor_treatment_service_charge='$indoor_treatment_service_charge'
                            where indoor_treatment_id='$indoor_treatment_id'";
                //echo $post_content;
                $result_indoor = $conn->exec($post_content);

                $post_content = "SELECT * FROM indoor_treatment_bed WHERE indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                //echo $post_content;
                $getJson = $conn->prepare($post_content);
                $getJson->execute();
                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                foreach($result_content as $data)
                {
                    $bed_id = $data['indoor_treatment_bed_bed_id'];
                    $post_content = "UPDATE indoor_bed SET
                    indoor_bed_status = 'available'
                    where indoor_bed_id='$bed_id'";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                }
                $delete_content = "DELETE FROM indoor_treatment_bed WHERE indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
               

                $count_service =0;
                foreach( $indoor_patient_bed_bed_id as $rowservice) {

                    $bed_id  = $indoor_patient_bed_bed_id[$count_service];
                    if(empty($bed_id) || $bed_id == "" || $bed_id == null || is_nan($bed_id)) {
                        continue;
                    }
                    $category_name  = if_empty($indoor_bed_category_name[$count_service]);
                    $bed_price  = if_empty0($indoor_bed_price[$count_service]);
                    $bed_total_bill = if_empty0($indoor_bed_total_bill[$count_service]);
                    $bed_entry  = if_emptyNull($indoor_patient_bed_entry_time[$count_service]);
                    $bed_discharge  = if_emptyNull($indoor_patient_bed_discharge_time[$count_service]);
                    if(empty($bed_discharge) || $bed_discharge == "" || $bed_discharge == null) {
                       //for each bed make it booked
                        $post_content = "UPDATE indoor_bed SET
                        indoor_bed_status = 'booked'
                        where indoor_bed_id='$bed_id'";
                        //echo $post_content;
                        $result = $conn->exec($post_content);
                    }
                    else
                    {
                        //for each bed make it available
                        $post_content = "UPDATE indoor_bed SET
                        indoor_bed_status = 'available'
                        where indoor_bed_id='$bed_id'";
                        //echo $post_content;
                        $result = $conn->exec($post_content);
                    }
                    

                    //insert treatment-bed
                    $post_content = "INSERT INTO indoor_treatment_bed (indoor_treatment_bed_user_added_id,
                                  indoor_treatment_bed_treatment_id, indoor_treatment_bed_bed_id,
                                  indoor_treatment_bed_category_name,indoor_treatment_bed_price,
                                  indoor_treatment_bed_total_bill,                                  
                                  indoor_treatment_bed_entry_time,indoor_treatment_bed_discharge_time) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$bed_id','$category_name','$bed_price',
                            '$bed_total_bill', $bed_entry, $bed_discharge)";
                    // echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM indoor_treatment_doctor WHERE indoor_treatment_doctor_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach( $indoor_patient_doctor_doctor_id as $rowservice) {

                    $doctor_id  = $indoor_patient_doctor_doctor_id[$count_service];
                    if(empty($doctor_id) || $doctor_id == "" || $doctor_id == null || is_nan($doctor_id)) {
                        continue;
                    }
                    $doctor_specialization  = if_empty($indoor_doctor_specialization[$count_service]);
                    $doctor_visit_fee  = if_empty0($indoor_doctor_visit_fee[$count_service]);
                    $doctor_total_bill  = if_empty0($indoor_doctor_total_bill[$count_service]);
                    $doctor_entry  = if_emptyNull($indoor_patient_doctor_entry_time[$count_service]);
                    $doctor_discharge  = if_emptyNull($indoor_patient_doctor_discharge_time[$count_service]);

                    $post_content = "INSERT INTO indoor_treatment_doctor (indoor_treatment_doctor_user_added_id,
                                     indoor_treatment_doctor_treatment_id, indoor_treatment_doctor_doctor_id,
                                     indoor_treatment_doctor_specialization,indoor_treatment_doctor_visit_fee,
                                     indoor_treatment_doctor_total_bill,
                                     indoor_treatment_doctor_entry_time,indoor_treatment_doctor_discharge_time) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$doctor_id','$doctor_specialization',
                            '$doctor_visit_fee','$doctor_total_bill',
                            $doctor_entry, $doctor_discharge)";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM indoor_treatment_service WHERE indoor_treatment_service_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach( $outdoor_service_id as $rowservice) {

                    $service_id  = $outdoor_service_id[$count_service];
                    if(empty($service_id) || $service_id == "" || $service_id == null || is_nan($service_id)) {
                        continue;
                    }
                    $service_quantity  = if_empty0($outdoor_service_quantity[$count_service]);
                    $service_rate  = if_empty0($outdoor_service_rate[$count_service]);
                    $service_total = if_empty0($outdoor_service_total[$count_service]);

                    $post_content = "INSERT INTO indoor_treatment_service (indoor_treatment_service_user_added_id,
                                    indoor_treatment_service_treatment_id, indoor_treatment_service_service_id,
                                    indoor_treatment_service_service_quantity, indoor_treatment_service_service_rate,
                                    indoor_treatment_service_service_total) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$service_id', '$service_quantity',
                            '$service_rate','$service_total')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM indoor_pathology_investigation_test WHERE pathology_investigation_test_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach( $pathology_test_id as $rowservice) {

                    $test_id  = $pathology_test_id[$count_service];
                    if(empty($test_id) || $test_id == "" || $test_id == null || is_nan($test_id)) {
                        continue;
                    }
                    $room_no  = if_empty($pathology_test_room_no[$count_service]);
                    $test_price  = if_empty0($pathology_investigation_test_price[$count_service]);
                    $test_quantity = if_empty0($pathology_investigation_test_quantity[$count_service]);
                    $total_bill  = if_empty0($pathology_investigation_test_total_bill[$count_service]);

                    $post_content = "INSERT INTO indoor_pathology_investigation_test (pathology_investigation_test_user_added_id,
                                          pathology_investigation_test_treatment_id,
                                          pathology_investigation_test_pathology_test_id, 
                                          pathology_investigation_test_room_no,
                                          pathology_investigation_test_price,
                                          pathology_investigation_test_quantity,
                                          pathology_investigation_test_total_bill) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$test_id','$room_no',
                            '$test_price','$test_quantity','$total_bill')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM indoor_pharmacy_sell_medicine WHERE indoor_pharmacy_sell_medicine_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach($ot_treatment_pharmacy_item_medicine_id as $rowservice) {

                    $medicine_id  = $ot_treatment_pharmacy_item_medicine_id[$count_service];
                    if(empty($medicine_id) || $medicine_id == "" || $medicine_id == null || is_nan($medicine_id)) {
                        continue;
                    }
                    $batch_id  = if_empty($ot_treatment_pharmacy_item_batch_id[$count_service]);
                    $stock_qty  = $ot_treatment_pharmacy_item_stock_qty[$count_service];
                    $per_piece_price  = if_empty0($ot_treatment_pharmacy_item_per_piece_price[$count_service]);
                    $item_qty  = if_empty0($ot_treatment_pharmacy_item_quantity[$count_service]);
                    $item_bill  = if_empty0($ot_treatment_pharmacy_item_bill[$count_service]);
                    $item_note  = if_empty($ot_treatment_pharmacy_item_note[$count_service]);

                    $post_content = "INSERT INTO indoor_pharmacy_sell_medicine (indoor_pharmacy_sell_medicine_user_added_id,
                                     indoor_pharmacy_sell_medicine_medicine_id, indoor_pharmacy_sell_medicine_treatment_id,
                                     indoor_pharmacy_sell_medicine_batch_id, indoor_pharmacy_sell_medicine_per_piece_price, 
                                     indoor_pharmacy_sell_medicine_selling_piece, indoor_pharmacy_sell_medicine_total_selling_price,
                                     indoor_pharmacy_sell_medicine_note) 
                    VALUES ('$request_user_id','$medicine_id', '$indoor_treatment_id', '$batch_id',
                    '$per_piece_price', '$item_qty', '$item_bill', '$item_note')";
                    // echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $delete_content = "DELETE FROM ot_treatment_item WHERE ot_treatment_item_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $count_service =0;
                foreach( $ot_treatment_item_name as $rowservice) {

                    $item_name  = $ot_treatment_item_name[$count_service];
                    if(empty($item_name) || $item_name == "" || $item_name == null) {
                        continue;
                    }
                    $item_bill  = if_empty0($ot_treatment_item_price[$count_service]);
                    $item_qty  =  if_empty0($ot_treatment_item_qty[$count_service]);
                    $item_total  = if_empty0($ot_treatment_item_total[$count_service]);
                    $item_note  = if_empty($ot_treatment_item_note[$count_service]);
                   
                    $post_content = "INSERT INTO ot_treatment_item (ot_treatment_item_user_added_id,
                                     ot_treatment_item_treatment_id, ot_treatment_item_name,
                                     ot_treatment_item_price, ot_treatment_item_qty, 
                                     ot_treatment_item_total, ot_treatment_item_note) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$item_name',
                    '$item_bill', '$item_qty', '$item_total', '$item_note')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result_indoor) {
                    echo json_encode(array("indoor_allotment" => "Successful","indoor_treatment_id"=>$indoor_treatment_id, $status => 1, $message => "Update Indoor Treatment Successful"));
                } else {
                    echo json_encode(array("indoor_allotment" => "Error", $status => 0, $message => "Update Indoor Treatment Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("indoor_allotment"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_allotment"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "indoor_allotment"))
{
    $authenticate = new UpdateIndoorPatientAllotment();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}