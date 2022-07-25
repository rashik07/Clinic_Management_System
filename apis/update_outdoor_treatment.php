<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';
class UpdatePatientOutdoorTreatment
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
        // $doctor_id   = $_POST['doctor_id'];
        $token  = $_POST['token'];

        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 3, 4]) || $token_generator->check_permission($request_user_id, $conn, [1, 2, 3, 4]);

        if ($check_token && $check_permission) {
            try {

                $outdoor_treatment_id  = if_empty($_POST['outdoor_treatment_id']);
                $outdoor_treatment_patient_id  = if_empty($_POST['outdoor_treatment_patient_id']);
                $outdoor_treatment_consultant = if_empty($_POST['outdoor_treatment_consultant']);

                $outdoor_treatment_total_bill  = if_empty($_POST['outdoor_treatment_total_bill']);
                $outdoor_treatment_discount_pc   = $_POST['outdoor_treatment_discount_pc'];
                $outdoor_treatment_exemption = if_empty($_POST['outdoor_treatment_exemption']);
                $outdoor_treatment_total_bill_after_discount  = if_empty($_POST['outdoor_treatment_total_bill_after_discount']);
                $outdoor_treatment_due_collection  = if_empty($_POST['outdoor_treatment_due_collection']);
                $outdoor_treatment_total_paid  = if_empty($_POST['outdoor_treatment_total_paid']);
                $outdoor_treatment_total_due  = if_empty($_POST['outdoor_treatment_total_due']);
                $outdoor_treatment_payment_type   = if_empty($_POST['outdoor_treatment_payment_type']);
                $outdoor_treatment_payment_type_no  = if_empty($_POST['outdoor_treatment_payment_type_no']);
                $outdoor_treatment_note   = if_empty($_POST['outdoor_treatment_note']);
                $outdoor_treatment_reference = if_empty($_POST['outdoor_treatment_reference']);
                $outdoor_treatment_report_delivery_date = if_empty_return_null($_POST['outdoor_treatment_report_delivery_date']);

                $outdoor_service_id = $_POST['outdoor_service_id'];
                $outdoor_service_quantity  = $_POST['outdoor_service_quantity'];
                $outdoor_service_rate  = $_POST['outdoor_service_rate'];
                $outdoor_service_total  = $_POST['outdoor_service_total'];
                $outdoor_treatment_service_discount_pc = $_POST['outdoor_treatment_service_discount_pc'];


                $post_content = "UPDATE outdoor_treatment SET outdoor_treatment_patient_id = '$outdoor_treatment_patient_id', outdoor_treatment_report_delivery_date='$outdoor_treatment_report_delivery_date',
                outdoor_treatment_consultant='$outdoor_treatment_consultant',
                outdoor_treatment_reference='$outdoor_treatment_reference',
                outdoor_treatment_total_bill = '$outdoor_treatment_total_bill',
                outdoor_treatment_total_bill_after_discount='$outdoor_treatment_total_bill_after_discount',
                outdoor_treatment_discount_pc = '$outdoor_treatment_discount_pc',
                outdoor_treatment_exemption = '$outdoor_treatment_exemption',
                outdoor_treatment_total_paid = '$outdoor_treatment_total_paid',
                outdoor_treatment_total_due = '$outdoor_treatment_total_due',
                outdoor_treatment_payment_type = '$outdoor_treatment_payment_type',
                outdoor_treatment_payment_type_no = '$outdoor_treatment_payment_type_no',
                outdoor_treatment_note = '$outdoor_treatment_note'
                where outdoor_treatment_id='$outdoor_treatment_id'";

                //echo $post_content;
                $result_treatment_update = $conn->exec($post_content);
                //echo $outdoor_service_id;
                $count_service = 0;
                $result_treatment_service = true;

                $post_content = "INSERT INTO outdoor_treatment_payment (outdoor_treatment_payment_user_added_id, outdoor_treatment_payment_treatment_id,outdoor_treatment_payment_details,
                outdoor_treatment_payment_amount) 
                VALUES ('$request_user_id', '$outdoor_treatment_id','$outdoor_treatment_payment_type','$outdoor_treatment_due_collection')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();

                $get_content = "select * from outdoor_treatment_service 
                where outdoor_treatment_service_treatment_id = '$outdoor_treatment_id'";
                $getJson = $conn->prepare($get_content);
                $getJson->execute();
                $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result_content as $data) {
                    $id = $data['outdoor_treatment_service_id'];
                    $delete_content = "DELETE FROM outdoor_treatment_service WHERE outdoor_treatment_service_id='$id'";
                    $result = $conn->exec($delete_content);
                }


                foreach ($outdoor_service_id as $rowservice) {

                    $service_id  = $outdoor_service_id[$count_service];
                    $service_quantity  = $outdoor_service_quantity[$count_service];
                    $service_rate  = $outdoor_service_rate[$count_service];
                    $service_total = $outdoor_service_total[$count_service];
                    $service_discount_pc = $outdoor_treatment_service_discount_pc[$count_service];

                    $post_content = "INSERT INTO outdoor_treatment_service (outdoor_treatment_service_user_added_id,
                                       outdoor_treatment_service_treatment_id, outdoor_treatment_service_service_id,
                    outdoor_treatment_service_service_quantity,outdoor_treatment_service_service_rate,outdoor_treatment_service_discount_pc,
                     outdoor_treatment_service_service_total) 
                    VALUES ('$request_user_id','$outdoor_treatment_id','$service_id', '$service_quantity',
                            '$service_rate','$service_discount_pc','$service_total')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $result_treatment_service = $result_treatment_service & $result;
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }

                if ($result_treatment_update || $result_treatment_service) {
                    echo json_encode(array("patient_treatment" => "Successful", $status => 1, $message => "Update Patient Treatment Successful"));
                } else {
                    echo json_encode(array("patient_treatment" => "Error", $status => 0, $message => "Update Patient Treatment Failed"));
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
    $authenticate = new UpdatePatientOutdoorTreatment();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
