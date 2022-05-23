<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreateDoctor{

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

        $doctor_name   = if_empty($_POST['doctor_name']);
        $doctor_description   = if_empty($_POST['doctor_description']);
        $doctor_specialization   = if_empty($_POST['doctor_specialization']);
        $doctor_experience  = if_empty($_POST['doctor_experience']);
        $doctor_age   = if_empty($_POST['doctor_age']);
        $doctor_email  = if_empty($_POST['doctor_email']);
        $doctor_dob   = if_empty($_POST['doctor_dob']);
        $doctor_gender   = if_empty($_POST['doctor_gender']);
        $doctor_blood_group   = if_empty($_POST['doctor_blood_group']);
        $doctor_visit_fee   = if_empty($_POST['doctor_visit_fee']);
        $doctor_phone   = if_empty($_POST['doctor_phone']);
        $doctor_emergency_phone   = if_empty($_POST['doctor_emergency_phone']);
        $doctor_address   = if_empty($_POST['doctor_address']);
        $doctor_status   = if_empty($_POST['doctor_status']);


        // echo "testing";
        $upOne = dirname(__DIR__, 1);

        $target_dir_thumbnail = $upOne."/assets/images/";
        $target_file_thumbnail = $target_dir_thumbnail . basename($_FILES["photo_url"]["name"]);
        $thumb_file_name = "assets/images/". basename($_FILES["photo_url"]["name"]);

        $target_dir_document = $upOne."/assets/document/";
        $target_file_document = $target_dir_document . basename($_FILES["document_url"]["name"]);
        $document_file_name = "assets/document/". basename($_FILES["document_url"]["name"]);

        $image_upload = false;
        $document_uploaded = false;
        $image_exist = false;
        $document_exist = false;

        if ($_FILES['photo_url']['size'] != 0)
        {
            // cover_image is empty (and not an error)
            $image_exist = true;
            if(move_uploaded_file($_FILES["photo_url"]["tmp_name"], $target_file_thumbnail))
            {
                $image_upload = true;
                chmod($target_file_thumbnail, 0777);
            }
            else
            {
                $image_upload = false;
                echo json_encode(array("doctor" => null, $status => 0, $message => "Image Upload Error"));
                die();
            }
        }
        if ($_FILES['document_url']['size'] != 0)
        {
            // cover_image is empty (and not an error)
            $document_exist = true;
            if(move_uploaded_file($_FILES["document_url"]["tmp_name"], $target_file_document))
            {
                $document_uploaded = true;
                chmod($target_file_document, 0777);
            }
            else
            {
                $document_uploaded = false;
                echo json_encode(array("doctor" => null, $status => 0, $message => "Document Upload Error"));
                die();
            }
        }
        if($image_exist == false && $document_exist == false)
        {
            $thumb_file_name = '';
            $document_file_name = '';
        }
        //echo $thumb_file_name;
        //console.log($thumb_file_name);
            //$content_type = mime_content_type($target_file_thumbnail);
            //echo $content_type;
            $check_token = $token_generator->check_token($request_user_id,$conn,$token);
            $check_permission = $token_generator->check_permission($request_user_id,$conn,[1,2,3]);            //echo $check_token;

           
            //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
            if($check_token && $check_permission)
            {
                try {
                    $post_content = "INSERT INTO doctor (doctor_user_added_id, doctor_name, doctor_description,
                        doctor_specialization,doctor_experience, doctor_age, doctor_email, doctor_dob, doctor_gender,
                        doctor_blood_group, doctor_visit_fee, doctor_phone, doctor_emergency_phone, doctor_address, doctor_status, photo_url, document_url) 
                        VALUES ('$request_user_id','$doctor_name','$doctor_description', '$doctor_specialization',
                                '$doctor_experience','$doctor_age', '$doctor_email','$doctor_dob','$doctor_gender',
                                '$doctor_blood_group','$doctor_visit_fee','$doctor_phone', '$doctor_emergency_phone', '$doctor_address','$doctor_status', '$thumb_file_name', '$document_file_name')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    if ($result) {
                        echo json_encode(array("doctor" => "Successful","doctor_id"=>$last_id, $status => 1, $message => "Create Doctor Successful"));
                    } else {
                        echo json_encode(array("doctor" => "Error", $status => 0, $message => "Create Doctor Failed"));
                    }
                    die();
                }
                catch(Exception $e)
                {
                    echo json_encode(array("doctor"=>null,$status=>0, $message=>$e));
                    die();
                }
            }
            else{
                echo json_encode(array("doctor"=>null,$status=>0, $message=>"Authentication Error"));
                die();
            }
    }
}
if(isset($_POST['content']) && ($_POST['content'] == "doctor"))
{
    $authenticate = new CreateDoctor();
    $authenticate->post();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}