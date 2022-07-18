<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class UpdateIndoorPatientAllotment
{

    function post()
    {
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status = "status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token  = $_POST['token'];

        $indoor_treatment_id = $_POST['indoor_treatment_id'];
        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 3, 4]) || $token_generator->check_permission($request_user_id, $conn, [1, 2, 3, 4]);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if ($check_token && $check_permission) {
            try {
                $indoor_patient_id  = if_empty($_POST['outdoor_patient_id']);
                // $indoor_patient_name = if_empty($_POST['outdoor_patient_name']);

                $indoor_treatment_total_bill  = if_empty($_POST['indoor_treatment_total_bill']);
                $indoor_treatment_discount_pc   = if_empty($_POST['indoor_treatment_discount_pc']);
                $indoor_treatment_total_bill_after_discount  = if_empty($_POST['indoor_treatment_total_bill_after_discount']);
                $indoor_treatment_total_paid  = if_empty($_POST['indoor_treatment_total_paid']);
                $indoor_treatment_total_due  = if_empty($_POST['indoor_treatment_total_due']);
                $indoor_treatment_payment_type   = if_empty($_POST['indoor_treatment_payment_type']);
                $indoor_treatment_payment_type_no  = if_empty($_POST['indoor_treatment_payment_type_no']);
                $indoor_treatment_note   = if_empty($_POST['indoor_treatment_note']);
                $indoor_treatment_released = if_empty_return_zero(isset($_POST['indoor_treatment_released']));

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

                $outdoor_service_id = $_POST['outdoor_service_id'];
                $outdoor_service_rate = $_POST['outdoor_service_rate'];



                $post_content = "UPDATE indoor_treatment SET 
                            indoor_treatment_total_bill='$indoor_treatment_total_bill',
                            indoor_treatment_total_bill_after_discount='$indoor_treatment_total_bill_after_discount',
                            indoor_treatment_discount_pc='$indoor_treatment_discount_pc',
                            indoor_treatment_total_paid='$indoor_treatment_total_paid',
                            indoor_treatment_total_due='$indoor_treatment_total_due',
                            indoor_treatment_payment_type='$indoor_treatment_payment_type',
                            indoor_treatment_payment_type_no='$indoor_treatment_payment_type_no',
                            indoor_treatment_note='$indoor_treatment_note',
                            indoor_treatment_released='$indoor_treatment_released'
                            where indoor_treatment_id='$indoor_treatment_id'";
                //echo $post_content;
                $result = $conn->exec($post_content);

                $post_content = "SELECT * FROM indoor_treatment_bed WHERE indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                //echo $post_content;
                $getJson = $conn->prepare($post_content);
                $getJson->execute();
                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                // foreach ($result_content as $data) {
                //     $bed_id = $data['indoor_treatment_bed_bed_id'];
                //     $post_content = "UPDATE indoor_bed SET
                //     indoor_bed_status = 'available'
                //     where indoor_bed_id='$bed_id'";
                //     //echo $post_content;
                //     $result = $conn->exec($post_content);
                // }
                $delete_content = "DELETE FROM indoor_treatment_bed WHERE indoor_treatment_bed_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $delete_content = "DELETE FROM indoor_treatment_doctor WHERE indoor_treatment_doctor_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);
                $delete_content = "DELETE FROM indoor_treatment_admission WHERE indoor_treatment_id='$indoor_treatment_id'";
                $result = $conn->exec($delete_content);

                $count_service = 0;

                foreach ($indoor_patient_bed_bed_id as $rowservice) {


                    $bed_id  = $indoor_patient_bed_bed_id[$count_service];
                    $cetegory_name  = $indoor_bed_category_name[$count_service];
                    $bed_price  = $indoor_bed_price[$count_service];
                    $bed_total_bill = $indoor_bed_total_bill[$count_service];
                    $bed_entry  = $indoor_patient_bed_entry_time[$count_service];
                    $bed_discharge  = $indoor_patient_bed_discharge_time[$count_service];
                    if (count($indoor_patient_bed_bed_id) - 1 == $count_service) {
                        $post_content = "UPDATE indoor_bed SET
                    indoor_bed_status = 'booked'
                    where indoor_bed_id='$bed_id'";

                        //echo $post_content;
                        $result = $conn->exec($post_content);
                    }

                    $post_content = "INSERT INTO indoor_treatment_bed (indoor_treatment_bed_user_added_id,
                                  indoor_treatment_bed_treatment_id, indoor_treatment_bed_bed_id,
                                  indoor_treatment_bed_category_name,indoor_treatment_bed_price,
                                  indoor_treatment_bed_total_bill,                                  
                                  indoor_treatment_bed_entry_time,indoor_treatment_bed_discharge_time) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$bed_id','$cetegory_name','$bed_price',
                            '$bed_total_bill','$bed_entry', '$bed_discharge')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();

                    $count_service = $count_service + 1;
                }

                $count_service = 0;
                foreach ($indoor_patient_doctor_doctor_id as $rowservice) {

                    $doctor_id  = $indoor_patient_doctor_doctor_id[$count_service];
                    $doctor_specialization  = $indoor_doctor_specialization[$count_service];
                    $doctor_visit_fee  = $indoor_doctor_visit_fee[$count_service];
                    $doctor_total_bill  = $indoor_doctor_total_bill[$count_service];
                    $doctor_entry  = $indoor_patient_doctor_entry_time[$count_service];
                    $doctor_discharge  = $indoor_patient_doctor_discharge_time[$count_service];

                    $post_content = "INSERT INTO indoor_treatment_doctor (indoor_treatment_doctor_user_added_id,
                                     indoor_treatment_doctor_treatment_id, indoor_treatment_doctor_doctor_id,
                                     indoor_treatment_doctor_specialization,indoor_treatment_doctor_visit_fee,
                                     indoor_treatment_doctor_total_bill,
                                     indoor_treatment_doctor_entry_time,indoor_treatment_doctor_discharge_time) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$doctor_id','$doctor_specialization',
                            '$doctor_visit_fee','$doctor_total_bill',
                            '$doctor_entry', '$doctor_discharge')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                $count_service = 0;
                foreach ($outdoor_service_id as $rowservice) {

                    $outdoor_service_id  = $outdoor_service_id[$count_service];
                    $outdoor_service_rate  = $outdoor_service_rate[$count_service];

                    $post_content = "INSERT INTO indoor_treatment_admission (indoor_treatment_doctor_user_added_id,
                                     indoor_treatment_id, outdoor_service_id,
                                     outdoor_service_rate) 
                    VALUES ('$request_user_id','$indoor_treatment_id','$outdoor_service_id','$outdoor_service_rate')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result) {
                    echo json_encode(array("indoor_allotment" => "Successful", "indoor_treatment_id" => $indoor_treatment_id, $status => 1, $message => "Update Indoor Treatment Successful"));
                } else {
                    echo json_encode(array("indoor_allotment" => "Error", $status => 0, $message => "Update Indoor Treatment Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("indoor_allotment" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("indoor_allotment" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "indoor_allotment")) {
    $authenticate = new UpdateIndoorPatientAllotment();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
