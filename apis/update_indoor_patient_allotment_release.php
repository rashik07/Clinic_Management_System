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

                $indoor_treatment_released = if_empty($_POST['indoor_treatment_released']);

                $post_content = "UPDATE indoor_treatment SET 
                            indoor_treatment_released='$indoor_treatment_released'
                            where indoor_treatment_id='$indoor_treatment_id'";
                //echo $post_content;
                $result = $conn->exec($post_content);


                //release the last bed
                $post_content = "SELECT * FROM indoor_treatment_bed WHERE indoor_treatment_bed_treatment_id='$indoor_treatment_id' ORDER BY indoor_treatment_bed_id DESC LIMIT 1";
                // echo $post_content;
                $getJson = $conn->prepare($post_content);
                $getJson->execute();
                $result_admited = $getJson->fetchAll(PDO::FETCH_ASSOC);
                // echo $result_content;
                if (count($result_admited) > 0) {
                    $last_bed = $result_admited[0]['indoor_treatment_bed_bed_id'];

                    $post_content = "UPDATE indoor_bed SET 
                            indoor_bed_status='available'
                            where indoor_bed_id='$last_bed'";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
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
