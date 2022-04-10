<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreatePatientOutdoorTreatment
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
        $outdoor_patient_id  = $_POST['outdoor_patient_id'];

        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, 3);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if ($check_token && $check_permission) {
            try {

                $outdoor_treatment_total_bill  = if_empty($_POST['outdoor_treatment_total_bill']);
                $outdoor_treatment_discount_pc   = if_empty($_POST['outdoor_treatment_discount_pc']);
                $outdoor_treatment_total_bill_after_discount  = if_empty($_POST['outdoor_treatment_total_bill_after_discount']);
                $outdoor_treatment_total_paid  = if_empty($_POST['outdoor_treatment_total_paid']);
                $outdoor_treatment_total_due  = if_empty($_POST['outdoor_treatment_total_due']);
                $outdoor_treatment_payment_type   = if_empty($_POST['outdoor_treatment_payment_type']);
                $outdoor_treatment_payment_type_no  = if_empty($_POST['outdoor_treatment_payment_type_no']);
                $outdoor_treatment_note   = if_empty($_POST['outdoor_treatment_note']);
                $outdoor_treatment_indoor_treatment_id  = if_empty($_POST['outdoor_treatment_indoor_treatment_id']);

                $outdoor_service_id = $_POST['outdoor_service_id'];
                $outdoor_service_quantity  = $_POST['outdoor_service_quantity'];
                $outdoor_service_rate  = $_POST['outdoor_service_rate'];
                $outdoor_service_total  = $_POST['outdoor_service_total'];


                $post_content = "INSERT INTO outdoor_treatment (outdoor_treatment_user_added_id, outdoor_treatment_patient_id, outdoor_treatment_indoor_treatment_id,
                             outdoor_treatment_total_bill, outdoor_treatment_total_bill_after_discount, outdoor_treatment_discount_pc, 
                             outdoor_treatment_total_paid, outdoor_treatment_total_due,outdoor_treatment_payment_type,
                               outdoor_treatment_payment_type_no, outdoor_treatment_note) 
                    VALUES ('$request_user_id','$outdoor_patient_id','$outdoor_treatment_indoor_treatment_id', '$outdoor_treatment_total_bill',
                            '$outdoor_treatment_total_bill_after_discount', '$outdoor_treatment_discount_pc',
                            '$outdoor_treatment_total_paid', '$outdoor_treatment_total_due', '$outdoor_treatment_payment_type',
                            '$outdoor_treatment_payment_type_no','$outdoor_treatment_note')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $outdoor_treatment_id = $conn->lastInsertId();

                $count_service = 0;
                foreach ($outdoor_service_id as $rowservice) {

                    $service_id  = $outdoor_service_id[$count_service];
                    $service_quantity  = $outdoor_service_quantity[$count_service];
                    $service_rate  = $outdoor_service_rate[$count_service];
                    $service_total = $outdoor_service_total[$count_service];

                    $post_content = "INSERT INTO outdoor_treatment_service (outdoor_treatment_service_user_added_id,
                                       outdoor_treatment_service_treatment_id, outdoor_treatment_service_service_id,
                    outdoor_treatment_service_service_quantity,outdoor_treatment_service_service_rate,
                     outdoor_treatment_service_service_total) 
                    VALUES ('$request_user_id','$outdoor_treatment_id','$service_id', '$service_quantity',
                            '$service_rate','$service_total')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result) {
                    echo json_encode(array("patient_treatment" => "Successful", "outdoor_treatment_id" => $outdoor_treatment_id, $status => 1, $message => "Create Treatment Successful"));
                } else {
                    echo json_encode(array("patient_treatment" => "Error", $status => 0, $message => "Create Treatment Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("patient_treatment" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("patient_treatment" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "patient_treatment")) {
    $authenticate = new CreatePatientOutdoorTreatment();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
