<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class UpdatePharamacyMedicinePurchase
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
        $pharmacy_purchase_id   = $_POST['medicine_purchase_id'];

        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 6]) || $token_generator->check_permission($request_user_id, $conn, [1, 2, 6]);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if ($check_token && $check_permission) {
            try {
                $pharmacy_purchase_manufacturer_id  = if_empty($_POST['pharmacy_purchase_manufacturer_id']);
                $pharmacy_purchase_invoice_no  = if_empty($_POST['pharmacy_purchase_invoice_no']);
                $pharmacy_purchase_date  = if_empty($_POST['pharmacy_purchase_date']);

                $pharmacy_purchase_sub_total  = if_empty($_POST['pharmacy_purchase_sub_total']);
                $pharmacy_purchase_vat   = if_empty($_POST['pharmacy_purchase_vat']);
                $pharmacy_purchase_discount  = if_empty($_POST['pharmacy_purchase_discount']);
                $pharmacy_purchase_grand_total  = if_empty($_POST['pharmacy_purchase_grand_total']);
                $pharmacy_purchase_paid_amount = if_empty($_POST['pharmacy_purchase_paid_amount']);
                $pharmacy_purchase_due_amount   = if_empty($_POST['pharmacy_purchase_due_amount']);

                $pharmacy_purchase_medicine_medicine_id = $_POST['pharmacy_purchase_medicine_medicine_id'];
                $pharmacy_purchase_medicine_batch_id  = $_POST['pharmacy_purchase_medicine_batch_id'];
                $pharmacy_purchase_medicine_exp_date = $_POST['pharmacy_purchase_medicine_exp_date'];
                $pharmacy_purchase_medicine_stock_qty = $_POST['pharmacy_purchase_medicine_stock_qty'];
                $pharmacy_purchase_medicine_purchase_id=$_POST['pharmacy_purchase_medicine_purchase_id'];
                $pharmacy_purchase_medicine_total_pieces = $_POST['pharmacy_purchase_medicine_total_pieces'];

                $pharmacy_purchase_medicine_manufacture_price = $_POST['pharmacy_purchase_medicine_manufacture_price'];
                $pharmacy_purchase_medicine_box_mrp = $_POST['pharmacy_purchase_medicine_box_mrp'];
                $pharmacy_purchase_medicine_total_purchase_price = $_POST['pharmacy_purchase_medicine_total_purchase_price'];

                $post_content = "UPDATE pharmacy_purchase SET pharmacy_purchase_manufacturer_id = '$pharmacy_purchase_manufacturer_id',
                pharmacy_purchase_date = '$pharmacy_purchase_date', pharmacy_purchase_invoice_no= '$pharmacy_purchase_invoice_no',
                pharmacy_purchase_sub_total = '$pharmacy_purchase_sub_total', pharmacy_purchase_vat = '$pharmacy_purchase_vat',
                pharmacy_purchase_discount = '$pharmacy_purchase_discount', pharmacy_purchase_grand_total='$pharmacy_purchase_grand_total',
                pharmacy_purchase_paid_amount = '$pharmacy_purchase_paid_amount', pharmacy_purchase_due_amount='$pharmacy_purchase_due_amount'
where pharmacy_purchase_id='$pharmacy_purchase_id'";
                //echo $post_content;
                $result = $conn->exec($post_content);

                // $delete_content = "DELETE FROM pharmacy_purchase_medicine WHERE pharmacy_purchase_medicine_purchase_id='$pharmacy_purchase_id'";
                // $result = $conn->exec($delete_content);


                $count_service = 0;


                //echo $post_content;
                $result = $conn->exec($post_content);
                $last_id = $conn->lastInsertId();

               
                foreach ($pharmacy_purchase_medicine_medicine_id as $rowservice) {
                    
                    $medicine_id  = $pharmacy_purchase_medicine_medicine_id[$count_service];
                    $batch_id  = $pharmacy_purchase_medicine_batch_id[$count_service];
                    $exp_date  = $pharmacy_purchase_medicine_exp_date[$count_service];
                    $total_pieces = $pharmacy_purchase_medicine_total_pieces[$count_service];
                    $manufacture_price = $pharmacy_purchase_medicine_manufacture_price[$count_service];
                    $selling_price = $pharmacy_purchase_medicine_box_mrp[$count_service];
                    $total_price = $pharmacy_purchase_medicine_total_purchase_price[$count_service];
                    // var_dump($pharmacy_purchase_medicine_total_pieces);
                    // echo $count_service;
                    // var_dump($pharmacy_purchase_medicine_total_pieces[$count_service]);

                    $get_content = "select * from pharmacy_medicine where pharmacy_medicine_medicine_id='$medicine_id'
                    and pharmacy_medicine_batch_id='$batch_id' ";
                    // echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $pharmacy_medicine_id = $result_content[0]['pharmacy_medicine_id'];

                    

                    $get_content = "select * from pharmacy_purchase_medicine where pharmacy_purchase_medicine_medicine_id='$pharmacy_medicine_id'
                    and pharmacy_purchase_medicine_batch_id='$batch_id'  ";
                    // echo $get_content;
                    $getJson = $conn->prepare($get_content);
                    $getJson->execute();
                    $result_content_purchase = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    // $pharmacy_medicine_id = $result_content[0]['pharmacy_medicine_id'];
                    // echo count($result_content_purchase);
                    if (count($result_content_purchase) > 0) {
                        $post_content = "UPDATE pharmacy_purchase_medicine SET 
                        pharmacy_purchase_medicine_total_pieces = '$total_pieces' ,pharmacy_purchase_medicine_total_purchase_price='$total_price'
                        where pharmacy_purchase_medicine_medicine_id='$pharmacy_medicine_id' and pharmacy_purchase_medicine_batch_id='$batch_id ' and pharmacy_purchase_medicine_purchase_id='$pharmacy_purchase_medicine_purchase_id'
                          ";
                            //  echo $post_content;
                             $result = $conn->exec($post_content);
                             $pharmacy_medicine_id = $result_content[0]['pharmacy_medicine_id'];
                             $count_service = $count_service + 1;
                    }
                    else{
                        $post_content = "INSERT INTO pharmacy_purchase_medicine (pharmacy_purchase_medicine_user_added_id,
                        pharmacy_purchase_medicine_medicine_id, pharmacy_purchase_medicine_purchase_id, 
                        pharmacy_purchase_medicine_batch_id,
                            pharmacy_purchase_medicine_total_pieces,pharmacy_purchase_medicine_manufacture_price,
                            pharmacy_purchase_medicine_box_mrp, pharmacy_purchase_medicine_total_purchase_price) 
                            VALUES ('$request_user_id','$pharmacy_medicine_id','$pharmacy_purchase_id', '$batch_id',
                            '$total_pieces','$manufacture_price', '$selling_price','$total_price')";
                        //echo $post_content;
                        $result = $conn->exec($post_content);
                        $last_id = $conn->lastInsertId();
                        $count_service = $count_service + 1;

                    }



                   
                 

                    $get_sum_content = "select sum(pharmacy_purchase_medicine_total_pieces) as medicine_total_pieces from pharmacy_purchase_medicine where pharmacy_purchase_medicine_medicine_id='$pharmacy_medicine_id'
                    ";
                    //echo $get_content;
                    $getJson = $conn->prepare($get_sum_content);
                    $getJson->execute();
                    $result_sum_content = $getJson->fetchAll(PDO::FETCH_ASSOC);
                    $mtp_pharmacy_purchase_medicine_total_pieces = $result_sum_content[0]['medicine_total_pieces'];
                    // echo $pharmacy_purchase_medicine_total_pieces;
                    if (count($result_content) > 0) {

                        $post_content = "UPDATE pharmacy_medicine SET pharmacy_medicine_quantity = '$mtp_pharmacy_purchase_medicine_total_pieces',pharmacy_medicine_exp_date = '$exp_date'
                   where pharmacy_medicine_medicine_id='$medicine_id' and pharmacy_medicine_batch_id='$batch_id' 
                     ";

                        //echo $post_content;
                        $result = $conn->exec($post_content);
                        $pharmacy_medicine_id = $result_content[0]['pharmacy_medicine_id'];
                    } else {
                        $post_content = "INSERT INTO pharmacy_medicine (pharmacy_medicine_user_added_id,
                               pharmacy_medicine_medicine_id, pharmacy_medicine_quantity,
                               pharmacy_medicine_batch_id, pharmacy_medicine_exp_date) 
                    VALUES ('$request_user_id','$medicine_id',
                            '$total_pieces', '$batch_id', '$exp_date')";
                        //echo $post_content;
                        $result = $conn->exec($post_content);
                        // $pharmacy_medicine_id = $conn->lastInsertId();



                    }
                }

                if ($result) {
                    echo json_encode(array("pharmacy_medicine_purchase" => "Successful", "pharmacy_purchase_id" => $pharmacy_purchase_id, $status => 1, $message => "Update Pharmacy Purchase Successful"));
                } else {
                    echo json_encode(array("pharmacy_medicine_purchase" => "Error", $status => 0, $message => "Update Pharmacy Purchase Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("pharmacy_medicine_purchase" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("pharmacy_medicine_purchase" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "pharmacy_medicine_purchase")) {
    $authenticate = new UpdatePharamacyMedicinePurchase();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
