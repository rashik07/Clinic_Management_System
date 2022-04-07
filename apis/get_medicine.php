<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
class GetMedicine{

    function GetAllMedicine(){
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
            $get_content = "select * from medicine
            left join medicine_category mc on mc.medicine_category_id = medicine.medicine_category
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
            left join medicine_type mt on mt.medicine_type_id = medicine.medicine_type
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_id'=>$data['medicine_id'],
                            'medicine_user_added_id'=>$data['medicine_user_added_id'],
                            'medicine_name'=>$data['medicine_name'],
                            'medicine_generic_name'=>$data['medicine_generic_name'],
                            'medicine_description'=>$data['medicine_description'],
                            'medicine_purchase_price'=>$data['medicine_purchase_price'],
                            'medicine_selling_price'=>$data['medicine_selling_price'],
                            'medicine_status'=>$data['medicine_status'],
                            'medicine_creation_time'=>$data['medicine_creation_time'],
                            'medicine_modification_time'=>$data['medicine_modification_time'],

                            'medicine_category_id'=>$data['medicine_category_id'],
                            'medicine_category_user_added_id'=>$data['medicine_category_user_added_id'],
                            'medicine_category_name'=>$data['medicine_category_name'],
                            'medicine_category_description'=>$data['medicine_category_description'],
                            'medicine_category_creation_time'=>$data['medicine_category_creation_time'],
                            'medicine_category_modification_time'=>$data['medicine_category_modification_time'],
    
                            'medicine_unit_id'=>$data['medicine_unit_id'],
                            'medicine_unit_user_added_id'=>$data['medicine_unit_user_added_id'],
                            'medicine_unit_name'=>$data['medicine_unit_name'],
                            'medicine_unit_description'=>$data['medicine_unit_description'],
                            'medicine_unit_creation_time'=>$data['medicine_unit_creation_time'],
                            'medicine_unit_modification_time'=>$data['medicine_unit_modification_time'],

                            'medicine_type_id'=>$data['medicine_type_id'],
                            'medicine_type_user_added_id'=>$data['medicine_type_user_added_id'],
                            'medicine_type_name'=>$data['medicine_type_name'],
                            'medicine_type_description'=>$data['medicine_type_description'],
                            'medicine_type_creation_time'=>$data['medicine_type_creation_time'],
                            'medicine_type_modification_time'=>$data['medicine_type_modification_time'],

                            'medicine_leaf_id'=>$data['medicine_leaf_id'],
                            'medicine_leaf_user_added_id'=>$data['medicine_leaf_user_added_id'],
                            'medicine_leaf_name'=>$data['medicine_leaf_name'],
                            'medicine_leaf_description'=>$data['medicine_leaf_description'],
                            'medicine_leaf_total_per_box'=>$data['medicine_leaf_total_per_box'],
                            'medicine_leaf_creation_time'=>$data['medicine_leaf_creation_time'],
                            'medicine_leaf_modification_time'=>$data['medicine_leaf_modification_time'],

                            'medicine_manufacturer_id'=>$data['medicine_manufacturer_id'],
                            'medicine_manufacturer_user_added_id'=>$data['medicine_manufacturer_user_added_id'],
                            'medicine_manufacturer_name'=>$data['medicine_manufacturer_name'],
                            'medicine_manufacturer_address'=>$data['medicine_manufacturer_address'],
                            'medicine_manufacturer_mobile'=>$data['medicine_manufacturer_mobile'],
                            'medicine_manufacturer_email'=>$data['medicine_manufacturer_email'],
                            'medicine_manufacturer_city'=>$data['medicine_manufacturer_city'],
                            'medicine_manufacturer_state'=>$data['medicine_manufacturer_state'],
                            'medicine_manufacturer_description'=>$data['medicine_manufacturer_description'],
                            'medicine_manufacturer_creation_time'=>$data['medicine_manufacturer_creation_time'],
                            'medicine_manufacturer_modification_time'=>$data['medicine_manufacturer_modification_time']





                        ));
                }
                echo json_encode(array("medicine"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetAllMedicineOfManufacturer(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $manufacturer_id  = $_POST['manufacturer_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine
            left join medicine_category mc on mc.medicine_category_id = medicine.medicine_category
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
            left join medicine_type mt on mt.medicine_type_id = medicine.medicine_type
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            where medicine_manufacturer='$manufacturer_id'";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_id'=>$data['medicine_id'],
                            'medicine_user_added_id'=>$data['medicine_user_added_id'],
                            'medicine_name'=>$data['medicine_name'],
                            'medicine_generic_name'=>$data['medicine_generic_name'],
                            'medicine_description'=>$data['medicine_description'],
                            'medicine_quantity'=>$data['medicine_quantity'],
                            'medicine_purchase_price'=>$data['medicine_purchase_price'],
                            'medicine_selling_price'=>$data['medicine_selling_price'],
                            'medicine_vat'=>$data['medicine_vat'],
                            'medicine_exp_date'=>$data['medicine_exp_date'],
                            'medicine_batch_id'=>$data['medicine_batch_id'],

                            'medicine_status'=>$data['medicine_status'],
                            'medicine_creation_time'=>$data['medicine_creation_time'],
                            'medicine_modification_time'=>$data['medicine_modification_time'],

                            'medicine_category_id'=>$data['medicine_category_id'],
                            'medicine_category_user_added_id'=>$data['medicine_category_user_added_id'],
                            'medicine_category_name'=>$data['medicine_category_name'],
                            'medicine_category_description'=>$data['medicine_category_description'],
                            'medicine_category_creation_time'=>$data['medicine_category_creation_time'],
                            'medicine_category_modification_time'=>$data['medicine_category_modification_time'],

                            'medicine_unit_id'=>$data['medicine_unit_id'],
                            'medicine_unit_user_added_id'=>$data['medicine_unit_user_added_id'],
                            'medicine_unit_name'=>$data['medicine_unit_name'],
                            'medicine_unit_description'=>$data['medicine_unit_description'],
                            'medicine_unit_creation_time'=>$data['medicine_unit_creation_time'],
                            'medicine_unit_modification_time'=>$data['medicine_unit_modification_time'],

                            'medicine_type_id'=>$data['medicine_type_id'],
                            'medicine_type_user_added_id'=>$data['medicine_type_user_added_id'],
                            'medicine_type_name'=>$data['medicine_type_name'],
                            'medicine_type_description'=>$data['medicine_type_description'],
                            'medicine_type_creation_time'=>$data['medicine_type_creation_time'],
                            'medicine_type_modification_time'=>$data['medicine_type_modification_time'],

                            'medicine_leaf_id'=>$data['medicine_leaf_id'],
                            'medicine_leaf_user_added_id'=>$data['medicine_leaf_user_added_id'],
                            'medicine_leaf_name'=>$data['medicine_leaf_name'],
                            'medicine_leaf_description'=>$data['medicine_leaf_description'],
                            'medicine_leaf_total_per_box'=>$data['medicine_leaf_total_per_box'],
                            'medicine_leaf_creation_time'=>$data['medicine_leaf_creation_time'],
                            'medicine_leaf_modification_time'=>$data['medicine_leaf_modification_time'],

                            'medicine_manufacturer_id'=>$data['medicine_manufacturer_id'],
                            'medicine_manufacturer_user_added_id'=>$data['medicine_manufacturer_user_added_id'],
                            'medicine_manufacturer_name'=>$data['medicine_manufacturer_name'],
                            'medicine_manufacturer_address'=>$data['medicine_manufacturer_address'],
                            'medicine_manufacturer_mobile'=>$data['medicine_manufacturer_mobile'],
                            'medicine_manufacturer_email'=>$data['medicine_manufacturer_email'],
                            'medicine_manufacturer_city'=>$data['medicine_manufacturer_city'],
                            'medicine_manufacturer_state'=>$data['medicine_manufacturer_state'],
                            'medicine_manufacturer_description'=>$data['medicine_manufacturer_description'],
                            'medicine_manufacturer_creation_time'=>$data['medicine_manufacturer_creation_time'],
                            'medicine_manufacturer_modification_time'=>$data['medicine_manufacturer_modification_time']





                        ));
                }
                echo json_encode(array("medicine"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }
    function GetSingleMedicine(){
        $connection = new Connection();
        $token_generator = new Token();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status="status";
        $message = "message";
        $request_user_id   = $_POST['request_user_id'];
        $token   = $_POST['token'];

        $medicine_id  = $_POST['medicine_id'];
        $check_token = $token_generator->check_token($request_user_id,$conn,$token);
        if($check_token)
        {
            $get_content = "select * from medicine
            left join medicine_category mc on mc.medicine_category_id = medicine.medicine_category
            left join medicine_leaf ml on ml.medicine_leaf_id = medicine.medicine_leaf
            left join medicine_type mt on mt.medicine_type_id = medicine.medicine_type
            left join medicine_unit mu on mu.medicine_unit_id = medicine.medicine_unit
            left join medicine_manufacturer mm on mm.medicine_manufacturer_id = medicine.medicine_manufacturer
            where medicine_id = '$medicine_id'";
            $getJson = $conn->prepare($get_content);
            $getJson->execute();
            $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
            if(count($result_content) > 0) {
                foreach($result_content as $data)
                {
                    array_push($response,
                        array(
                            'medicine_id'=>$data['medicine_id'],
                            'medicine_user_added_id'=>$data['medicine_user_added_id'],
                            'medicine_name'=>$data['medicine_name'],
                            'medicine_generic_name'=>$data['medicine_generic_name'],
                            'medicine_description'=>$data['medicine_description'],
                            'medicine_quantity'=>$data['medicine_quantity'],
                            'medicine_purchase_price'=>$data['medicine_purchase_price'],
                            'medicine_selling_price'=>$data['medicine_selling_price'],
                            'medicine_vat'=>$data['medicine_vat'],
                            'medicine_exp_date'=>$data['medicine_exp_date'],
                            'medicine_batch_id'=>$data['medicine_batch_id'],

                            'medicine_status'=>$data['medicine_status'],
                            'medicine_creation_time'=>$data['medicine_creation_time'],
                            'medicine_modification_time'=>$data['medicine_modification_time'],

                            'medicine_category_id'=>$data['medicine_category_id'],
                            'medicine_category_user_added_id'=>$data['medicine_category_user_added_id'],
                            'medicine_category_name'=>$data['medicine_category_name'],
                            'medicine_category_description'=>$data['medicine_category_description'],
                            'medicine_category_creation_time'=>$data['medicine_category_creation_time'],
                            'medicine_category_modification_time'=>$data['medicine_category_modification_time'],

                            'medicine_unit_id'=>$data['medicine_unit_id'],
                            'medicine_unit_user_added_id'=>$data['medicine_unit_user_added_id'],
                            'medicine_unit_name'=>$data['medicine_unit_name'],
                            'medicine_unit_description'=>$data['medicine_unit_description'],
                            'medicine_unit_creation_time'=>$data['medicine_unit_creation_time'],
                            'medicine_unit_modification_time'=>$data['medicine_unit_modification_time'],

                            'medicine_type_id'=>$data['medicine_type_id'],
                            'medicine_type_user_added_id'=>$data['medicine_type_user_added_id'],
                            'medicine_type_name'=>$data['medicine_type_name'],
                            'medicine_type_description'=>$data['medicine_type_description'],
                            'medicine_type_creation_time'=>$data['medicine_type_creation_time'],
                            'medicine_type_modification_time'=>$data['medicine_type_modification_time'],

                            'medicine_leaf_id'=>$data['medicine_leaf_id'],
                            'medicine_leaf_user_added_id'=>$data['medicine_leaf_user_added_id'],
                            'medicine_leaf_name'=>$data['medicine_leaf_name'],
                            'medicine_leaf_description'=>$data['medicine_leaf_description'],
                            'medicine_leaf_total_per_box'=>$data['medicine_leaf_total_per_box'],
                            'medicine_leaf_creation_time'=>$data['medicine_leaf_creation_time'],
                            'medicine_leaf_modification_time'=>$data['medicine_leaf_modification_time'],

                            'medicine_manufacturer_id'=>$data['medicine_manufacturer_id'],
                            'medicine_manufacturer_user_added_id'=>$data['medicine_manufacturer_user_added_id'],
                            'medicine_manufacturer_name'=>$data['medicine_manufacturer_name'],
                            'medicine_manufacturer_address'=>$data['medicine_manufacturer_address'],
                            'medicine_manufacturer_mobile'=>$data['medicine_manufacturer_mobile'],
                            'medicine_manufacturer_email'=>$data['medicine_manufacturer_email'],
                            'medicine_manufacturer_city'=>$data['medicine_manufacturer_city'],
                            'medicine_manufacturer_state'=>$data['medicine_manufacturer_state'],
                            'medicine_manufacturer_description'=>$data['medicine_manufacturer_description'],
                            'medicine_manufacturer_creation_time'=>$data['medicine_manufacturer_creation_time'],
                            'medicine_manufacturer_modification_time'=>$data['medicine_manufacturer_modification_time']

                        ));
                }
                echo json_encode(array("medicine"=>$response,"token"=>$token,$status=>1, $message=>"Fetched All Data"));
                die();
            }
            else{
                echo json_encode(array("medicine"=>null,$status=>0, $message=>"No Data"));
                die();
            }
        }
        else{
            echo json_encode(array("medicine"=>null,$status=>0, $message=>"Authentication Error"));
            die();
        }

    }

}
if(isset($_POST['content']) && ($_POST['content'] == "medicine"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicine();
    $authenticate->GetAllMedicine();
}
else if(isset($_POST['content']) && ($_POST['content'] == "medicine_single"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicine();
    $authenticate->GetSingleMedicine();
}
else if(isset($_POST['content']) && ($_POST['content'] == "manufacturer_medicine"))   // it checks whether the user clicked login button or not
{
    $authenticate = new GetMedicine();
    $authenticate->GetAllMedicineOfManufacturer();
}
else
{
    echo json_encode(array("message"=>"Bad Request"));
    die();
}