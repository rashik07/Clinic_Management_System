<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetIndoorBed{

    function getAllIndoorBed(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $response_patient = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from indoor_bed_category
            left join indoor_bed ib on indoor_bed_category.indoor_bed_category_id = ib.indoor_bed_category_id";

            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'indoor_bed_category_id'=>$data['indoor_bed_category_id'],
                            'indoor_bed_category_user_added_id'=>$data['indoor_bed_category_user_added_id'],
                            'indoor_bed_category_name'=>$data['indoor_bed_category_name'],
                            'indoor_bed_category_description'=>$data['indoor_bed_category_description'],

                            'indoor_bed_category_status'=>$data['indoor_bed_category_status'],
                            'indoor_bed_category_creation_time'=>$data['indoor_bed_category_creation_time'],
                            'indoor_bed_category_modification_time'=>$data['indoor_bed_category_modification_time'],

                            'indoor_bed_id'=>$data['indoor_bed_id'],
                            'indoor_bed_user_added_id'=>$data['indoor_bed_user_added_id'],
                            'indoor_bed_name'=>$data['indoor_bed_name'],
                            'indoor_bed_price'=>$data['indoor_bed_price'],
                            'indoor_bed_room_no'=>$data['indoor_bed_room_no'],
                            'indoor_bed_status'=>$data['indoor_bed_status'],
                            'indoor_bed_creation_time'=>$data['indoor_bed_creation_time'],
                            'indoor_bed_modification_time'=>$data['indoor_bed_modification_time']


                        ));

                }
                echo json_encode(array("indoor_bed"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function getIndoorBedByCategory(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $indoor_bed_category_id  = $_POST['indoor_bed_category_id'];

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from indoor_bed_category
            left join indoor_bed ib on indoor_bed_category.indoor_bed_category_id = ib.indoor_bed_category_id
            where indoor_bed_category.indoor_bed_category_id ='$indoor_bed_category_id'";


            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'indoor_bed_category_id'=>$data['indoor_bed_category_id'],
                            'indoor_bed_category_user_added_id'=>$data['indoor_bed_category_user_added_id'],
                            'indoor_bed_category_name'=>$data['indoor_bed_category_name'],
                            'indoor_bed_category_description'=>$data['indoor_bed_category_description'],

                            'indoor_bed_category_status'=>$data['indoor_bed_category_status'],
                            'indoor_bed_category_creation_time'=>$data['indoor_bed_category_creation_time'],
                            'indoor_bed_category_modification_time'=>$data['indoor_bed_category_modification_time'],

                            'indoor_bed_id'=>$data['indoor_bed_id'],
                            'indoor_bed_user_added_id'=>$data['indoor_bed_user_added_id'],
                            'indoor_bed_name'=>$data['indoor_bed_name'],
                            'indoor_bed_price'=>$data['indoor_bed_price'],
                            'indoor_bed_room_no'=>$data['indoor_bed_room_no'],
                            'indoor_bed_status'=>$data['indoor_bed_status'],
                            'indoor_bed_creation_time'=>$data['indoor_bed_creation_time'],
                            'indoor_bed_modification_time'=>$data['indoor_bed_modification_time']
                        ));
                }
                echo json_encode(array("indoor_bed"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function getSingleIndoorBed(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $indoor_bed_id   = $_POST['indoor_bed_id'];

        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from indoor_bed_category
            left join indoor_bed ib on indoor_bed_category.indoor_bed_category_id = ib.indoor_bed_category_id
            where indoor_bed_id ='$indoor_bed_id'";


            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'indoor_bed_category_id'=>$data['indoor_bed_category_id'],
                            'indoor_bed_category_user_added_id'=>$data['indoor_bed_category_user_added_id'],
                            'indoor_bed_category_name'=>$data['indoor_bed_category_name'],
                            'indoor_bed_category_description'=>$data['indoor_bed_category_description'],

                            'indoor_bed_category_status'=>$data['indoor_bed_category_status'],
                            'indoor_bed_category_creation_time'=>$data['indoor_bed_category_creation_time'],
                            'indoor_bed_category_modification_time'=>$data['indoor_bed_category_modification_time'],

                            'indoor_bed_id'=>$data['indoor_bed_id'],
                            'indoor_bed_user_added_id'=>$data['indoor_bed_user_added_id'],
                            'indoor_bed_name'=>$data['indoor_bed_name'],
                            'indoor_bed_price'=>$data['indoor_bed_price'],
                            'indoor_bed_room_no'=>$data['indoor_bed_room_no'],
                            'indoor_bed_status'=>$data['indoor_bed_status'],
                            'indoor_bed_creation_time'=>$data['indoor_bed_creation_time'],
                            'indoor_bed_modification_time'=>$data['indoor_bed_modification_time']
                        ));
                }
                echo json_encode(array("indoor_bed"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("indoor_bed"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetIndoorBed();
    $authenticate->getAllIndoorBed();
}
else if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed_by_category"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetIndoorBed();
    $authenticate->getIndoorBedByCategory();
}
else if(isset($_POST['content']) && ($_POST['content'] == "indoor_bed_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetIndoorBed();
    $authenticate->getSingleIndoorBed();
}

else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}