<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreatePatient{

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

        $patient_name   = if_empty($_POST['patient_name']);
        $patient_description   = if_empty($_POST['patient_description']);
        $patient_age   = if_empty($_POST['patient_age']);
        $patient_email  = if_empty($_POST['patient_email']);
        $patient_dob   = if_empty($_POST['patient_dob']);
        $patient_gender   = if_empty($_POST['patient_gender']);
        $patient_blood_group   = if_empty($_POST['patient_blood_group']);
        $patient_phone   = if_empty($_POST['patient_phone']);
        $patient_address   = if_empty($_POST['patient_address']);
        $patient_status   = if_empty($_POST['patient_status']);


       // echo "testing";
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        $check_permission = $token_generator->check_permission($request_user_id,$conn,3);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if($check_token && $check_permission)
        {
            try {
                $post_content = "INSERT INTO patient (patient_user_added_id, patient_name, patient_description,
                     patient_age, patient_email, patient_dob, patient_gender, patient_blood_group,
                     patient_phone, patient_address, patient_status) 
                    VALUES ('$request_user_id','$patient_name','$patient_description', '$patient_age',
                            '$patient_email','$patient_dob','$patient_gender',
                            '$patient_blood_group','$patient_phone','$patient_address','$patient_status')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();
                if ($result) {
                    echo json_encode(array("patient" => "Successful","patient_id"=>$last_id, $status => 1, $message => "Create Patient Successful"));
                } else {
                    echo json_encode(array("patient" => "Error", $status => 0, $message => "Create Patient Failed"));
                }
                die();
            }
            catch(Exception $e)
            {
                echo json_encode(array("patient"=>null,$status=>0, $message=>$e));
                die();
            }
        }
        else{
            echo json_encode(array("patient"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "patient"))
{
    $authenticate = new CreatePatient();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}