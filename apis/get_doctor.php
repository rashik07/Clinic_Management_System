<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetDoctor{

    function getAllDoctor(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from doctor";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'doctor_id'=>$data['doctor_id'],
                            'doctor_user_added_id'=>$data['doctor_user_added_id'],
                            'doctor_name'=>$data['doctor_name'],
                            'doctor_description'=>$data['doctor_description'],
                            'doctor_specialization'=>$data['doctor_specialization'],
                            'doctor_experience'=>$data['doctor_experience'],
                            'doctor_age'=>$data['doctor_age'],
                            'doctor_email'=>$data['doctor_email'],
                            'doctor_dob'=>$data['doctor_dob'],
                            'doctor_gender'=>$data['doctor_gender'],
                            'doctor_blood_group'=>$data['doctor_blood_group'],
                            'doctor_visit_fee'=>$data['doctor_visit_fee'],
                            'doctor_phone'=>$data['doctor_phone'],
                            'doctor_emergency_phone'=>$data['doctor_emergency_phone'],
                            'doctor_address'=>$data['doctor_address'],
                            'doctor_status'=>$data['doctor_status'],
                            'photo_url'=>$data['photo_url'],
                            'document_url'=>$data['document_url'],
                            'doctor_creation_time'=>$data['doctor_creation_time'],
                            'doctor_modification_time'=>$data['doctor_modification_time']

                        ));
                }
                echo json_encode(array("doctor"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("doctor"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("doctor"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function getSingleDoctor(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $doctor_id   = $_POST['doctor_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from doctor where doctor_id='$doctor_id'";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'doctor_id'=>$data['doctor_id'],
                            'doctor_user_added_id'=>$data['doctor_user_added_id'],
                            'doctor_name'=>$data['doctor_name'],
                            'doctor_description'=>$data['doctor_description'],
                            'doctor_specialization'=>$data['doctor_specialization'],
                            'doctor_experience'=>$data['doctor_experience'],
                            'doctor_age'=>$data['doctor_age'],
                            'doctor_email'=>$data['doctor_email'],
                            'doctor_dob'=>$data['doctor_dob'],
                            'doctor_gender'=>$data['doctor_gender'],
                            'doctor_blood_group'=>$data['doctor_blood_group'],
                            'doctor_visit_fee'=>$data['doctor_visit_fee'],
                            'doctor_phone'=>$data['doctor_phone'],
                            'doctor_emergency_phone'=>$data['doctor_emergency_phone'],
                            'doctor_address'=>$data['doctor_address'],
                            'doctor_status'=>$data['doctor_status'],
                            'photo_url'=>$data['photo_url'],
                            'document_url'=>$data['document_url'],
                            'doctor_creation_time'=>$data['doctor_creation_time'],
                            'doctor_modification_time'=>$data['doctor_modification_time']

                        ));
                }
                echo json_encode(array("doctor"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("doctor"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("doctor"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "doctor"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetDoctor();
    $authenticate->getAllDoctor();
}
else if(isset($_POST['content']) && ($_POST['content'] == "doctor_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetDoctor();
    $authenticate->getSingleDoctor();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}
