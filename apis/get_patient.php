<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetPatient
{

    function getAllPatient()
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
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        if ($check_token) {
            $get_content = "select * from patient";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if (count($result_content) > 0) {
                foreach ($result_content as $data) {
                    array_push(
                        $response,
                        array(
                            'patient_id' => $data['patient_id'],
                            'patient_user_added_id' => $data['patient_user_added_id'],
                            'patient_name' => $data['patient_name'],
                            'patient_description' => $data['patient_description'],
                            'patient_age' => $data['patient_age'],
                            'patient_email' => $data['patient_email'],
                            'patient_dob' => $data['patient_dob'],
                            'patient_gender' => $data['patient_gender'],
                            'patient_blood_group' => $data['patient_blood_group'],
                            'patient_phone' => $data['patient_phone'],
                            'patient_address' => $data['patient_address'],
                            'patient_status' => $data['patient_status'],
                            'patient_creation_time' => $data['patient_creation_time'],
                            'patient_modification_time' => $data['patient_modification_time']

                        )
                    );
                }
                echo json_encode(array("patient" => $response, "token" => $token, $status => 1, $message => "Fetched All Data"));
                die();
            } else {
                echo json_encode(array("patient" => null, $status => 0, $message => "No Data"));
                die();
            }
        } else {
            echo json_encode(array("patient" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
    function getSinglePatient()
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

        $patient_id   = $_POST['patient_id'];
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        if ($check_token) {
            $get_content = "select * from patient where patient_id='$patient_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if (count($result_content) > 0) {
                foreach ($result_content as $data) {
                    array_push(
                        $response,
                        array(
                            'patient_id' => $data['patient_id'],
                            'patient_user_added_id' => $data['patient_user_added_id'],
                            'patient_name' => $data['patient_name'],
                            'patient_description' => $data['patient_description'],
                            'patient_age' => $data['patient_age'],
                            'patient_email' => $data['patient_email'],
                            'patient_dob' => $data['patient_dob'],
                            'patient_gender' => $data['patient_gender'],
                            'patient_blood_group' => $data['patient_blood_group'],
                            'patient_phone' => $data['patient_phone'],
                            'patient_address' => $data['patient_address'],
                            'patient_status' => $data['patient_status'],
                            'patient_creation_time' => $data['patient_creation_time'],
                            'patient_modification_time' => $data['patient_modification_time']

                        )
                    );
                }
                echo json_encode(array("patient" => $response, "token" => $token, $status => 1, $message => "Fetched All Data"));
                die();
            } else {
                echo json_encode(array("patient" => null, $status => 0, $message => "No Data"));
                die();
            }
        } else {
            echo json_encode(array("patient" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
    function getSinglePatientByPhone()
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

        $patient_phone   = $_POST['patient_phone'];
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        if ($check_token) {
            $get_content = "select * from patient where patient_phone='$patient_phone'";
            //echo $get_content;
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if (count($result_content) > 0) {
                foreach ($result_content as $data) {
                    array_push(
                        $response,
                        array(
                            'patient_id' => $data['patient_id'],
                            'patient_user_added_id' => $data['patient_user_added_id'],
                            'patient_name' => $data['patient_name'],
                            'patient_description' => $data['patient_description'],
                            'patient_age' => $data['patient_age'],
                            'patient_email' => $data['patient_email'],
                            'patient_dob' => $data['patient_dob'],
                            'patient_gender' => $data['patient_gender'],
                            'patient_blood_group' => $data['patient_blood_group'],
                            'patient_phone' => $data['patient_phone'],
                            'patient_address' => $data['patient_address'],
                            'patient_status' => $data['patient_status'],
                            'patient_creation_time' => $data['patient_creation_time'],
                            'patient_modification_time' => $data['patient_modification_time']

                        )
                    );
                }
                echo json_encode(array("patient" => $response, "token" => $token, $status => 1, $message => "Fetched All Data"));
                die();
            } else {
                echo json_encode(array("patient" => null, $status => 0, $message => "No Data"));
                die();
            }
        } else {
            echo json_encode(array("patient" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }

    function patient_indoor_treatment_admission_id()
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

        $indoor_treatment_admission_id   = $_POST['indoor_treatment_admission_id'];
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        if ($check_token) {
            $get_content = "select * from indoor_treatment NATURAL JOIN patient where indoor_treatment_admission_id='$indoor_treatment_admission_id'";
            // echo $get_content;
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if (count($result_content) > 0) {
                foreach ($result_content as $data) {
                    array_push(
                        $response,
                        array(
                            'patient_id' => $data['patient_id'],
                            'patient_user_added_id' => $data['patient_user_added_id'],
                            'patient_name' => $data['patient_name'],
                            'patient_description' => $data['patient_description'],
                            'patient_age' => $data['patient_age'],
                            'patient_email' => $data['patient_email'],
                            'patient_dob' => $data['patient_dob'],
                            'patient_gender' => $data['patient_gender'],
                            'patient_blood_group' => $data['patient_blood_group'],
                            'patient_phone' => $data['patient_phone'],
                            'patient_address' => $data['patient_address'],
                            'patient_status' => $data['patient_status'],
                            'patient_creation_time' => $data['patient_creation_time'],
                            'patient_modification_time' => $data['patient_modification_time'],
                            'indoor_treatment_id' => $data['indoor_treatment_id'],

                        )
                    );
                }
                echo json_encode(array("patient" => $response, "token" => $token, $status => 1, $message => "Fetched All Data"));
                die();
            } else {
                echo json_encode(array("patient" => null, $status => 0, $message => "No Data"));
                die();
            }
        } else {
            echo json_encode(array("patient" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "patient"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPatient();
    $authenticate->getAllPatient();
} else if (isset($_POST['content']) && ($_POST['content'] == "patient_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPatient();
    $authenticate->getSinglePatient();
} else if (isset($_POST['content']) && ($_POST['content'] == "patient_single_phone"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPatient();
    $authenticate->getSinglePatientByPhone();
} else if (isset($_POST['content']) && ($_POST['content'] == "patient_indoor_treatment_admission_id"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetPatient();
    $authenticate->patient_indoor_treatment_admission_id();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
