<?php

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class CreatePharmacyMedicineSell
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

        // echo "testing";
        $check_token = $token_generator->check_token($request_user_id, $conn, $token);
        $check_permission = $token_generator->check_permission($request_user_id, $conn, [1, 2, 6]);
        //echo "Check Token: ".$check_token." Check Permission: ".$check_permission;
        if ($check_token && $check_permission) {
            try {
                $pharmacy_sell_patient_id  = if_empty_return_null($_POST['pharmacy_sell_patient_id']);
                // $pharmacy_sell_invoice_id = if_empty($_POST['pharmacy_sell_invoice_id']);
                $pharmacy_sell_date = if_empty($_POST['pharmacy_sell_date']);
                $pharmacy_sell_indoor_treatment_id = if_empty_return_null($_POST['pharmacy_sell_indoor_treatment_id']);
                $pharmacy_sell_invoice_id = if_empty($_POST['pharmacy_sell_invoice_id']);

                $pharmacy_selling_sub_total  = if_empty_return_zero($_POST['pharmacy_selling_sub_total']);
                $pharmacy_selling_vat   = if_empty_return_zero($_POST['pharmacy_selling_vat']);
                $pharmacy_selling_discount  = if_empty_return_zero($_POST['pharmacy_selling_discount']);
                $pharmacy_selling_exemption = if_empty_return_zero($_POST['pharmacy_selling_exemption']);
                $pharmacy_selling_grand_total  = if_empty_return_zero($_POST['pharmacy_selling_grand_total']);
                $pharmacy_selling_paid_amount = if_empty_return_zero($_POST['pharmacy_selling_paid_amount']);
                $pharmacy_selling_due_amount   = if_empty_return_zero($_POST['pharmacy_selling_due_amount']);

                $pharmacy_selling_medicine_medicine_id = $_POST['pharmacy_selling_medicine_medicine_id'];
                $pharmacy_selling_medicine_batch_id  = $_POST['pharmacy_selling_medicine_batch_id'];
                $pharmacy_selling_medicine_exp_date = $_POST['pharmacy_selling_medicine_exp_date'];
                $pharmacy_selling_medicine_stock_qty = $_POST['pharmacy_selling_medicine_stock_qty'];
                $pharmacy_selling_medicine_per_pc_price = $_POST['pharmacy_selling_medicine_per_pc_price'];
                $pharmacy_selling_medicine_selling_pieces = $_POST['pharmacy_selling_medicine_selling_pieces'];
                $pharmacy_purchase_medicine_total_selling_price = $_POST['pharmacy_purchase_medicine_total_selling_price'];

                $is_indoor = 0;
                $is_increase = 1;
                $is_due = 0;
                if ((int)$pharmacy_sell_indoor_treatment_id > 0) {
                    $is_indoor = 1;
                }



                $post_content = "INSERT INTO pharmacy_sell (pharmacy_sell_invoice_id,pharmacy_sell_user_added_id,
                           pharmacy_sell_patient_id, pharmacy_sell_indoor_treatment_id, pharmacy_sell_date, pharmacy_sell_sub_total,
                           pharmacy_sell_vat, pharmacy_sell_discount,pharmacy_selling_exemption, pharmacy_sell_grand_total,
                           pharmacy_sell_paid_amount, pharmacy_sell_due_amount) 
                    VALUES ('$pharmacy_sell_invoice_id','$request_user_id',$pharmacy_sell_patient_id,$pharmacy_sell_indoor_treatment_id,
                            '$pharmacy_sell_date', '$pharmacy_selling_sub_total',
                            '$pharmacy_selling_vat','$pharmacy_selling_discount', '$pharmacy_selling_exemption',
                            '$pharmacy_selling_grand_total', '$pharmacy_selling_paid_amount',
                            '$pharmacy_selling_due_amount')";
                //echo $post_content;
                $result = $conn->exec($post_content);
                $pharmacy_sell_id = $conn->lastInsertId();


                if ($is_indoor == 0) {
                    // Outdoor payment
                    $post_content = "INSERT INTO pharmacy_payment(pharmacy_payment_user_added_id, pharmacy_payment_pharmacy_sell_id,pharmacy_payment_details,
                    pharmacy_payment_amount,pharmacy_payment_due,pharmacy_payment_increase) 
                    VALUES ('$request_user_id', '$pharmacy_sell_id','$is_indoor','$pharmacy_selling_paid_amount','$is_due','$is_increase')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                } else {
                    // Indoor 
                    $post_content = "INSERT INTO pharmacy_payment(pharmacy_payment_user_added_id, pharmacy_payment_pharmacy_sell_id,pharmacy_payment_details,
                    pharmacy_payment_amount,pharmacy_payment_due,pharmacy_payment_increase) 
                    VALUES ('$request_user_id', '$pharmacy_sell_id','$is_indoor','$pharmacy_selling_paid_amount','$is_due','$is_increase')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                }


                $count_service = 0;
                foreach ($pharmacy_selling_medicine_medicine_id as $rowservice) {

                    $pharmacy_medicine_id  = $pharmacy_selling_medicine_medicine_id[$count_service];
                    $batch_id  = $pharmacy_selling_medicine_batch_id[$count_service];
                    $exp_date  = $pharmacy_selling_medicine_exp_date[$count_service];
                    $per_pc_price = $pharmacy_selling_medicine_per_pc_price[$count_service];
                    $selling_pieces = $pharmacy_selling_medicine_selling_pieces[$count_service];
                    $total_price = $pharmacy_purchase_medicine_total_selling_price[$count_service];


                    $post_content = "INSERT INTO pharmacy_sell_medicine (pharmacy_sell_medicine_user_added_id,
                                    pharmacy_sell_medicine_medicine_id, pharmacy_sell_medicine_sell_id,
                                    pharmacy_sell_medicine_batch_id, pharmacy_sell_medicine_exp_date,
                                    pharmacy_sell_medicine_per_piece_price, pharmacy_sell_medicine_selling_piece,
                                    pharmacy_sell_medicine_total_selling_price) 
                    VALUES ('$request_user_id','$pharmacy_medicine_id','$pharmacy_sell_id', '$batch_id',
                            '$exp_date','$per_pc_price', '$selling_pieces','$total_price')";
                    //echo $post_content;
                    $result = $conn->exec($post_content);
                    $last_id = $conn->lastInsertId();
                    $count_service = $count_service + 1;
                }


                if ($result) {
                    echo json_encode(array("pharmacy_medicine_sell" => "Successful", "pharmacy_sell_id" => $pharmacy_sell_id, $status => 1, $message => "Create Pharmacy Selling Successful"));
                } else {
                    echo json_encode(array("pharmacy_medicine_sell" => "Error", $status => 0, $message => "Create Pharmacy Selling Failed"));
                }
                die();
            } catch (Exception $e) {
                echo json_encode(array("pharmacy_medicine_sell" => null, $status => 0, $message => $e));
                die();
            }
        } else {
            echo json_encode(array("pharmacy_medicine_sell" => null, $status => 0, $message => "Authentication Error"));
            die();
        }
    }
}
if (isset($_POST['content']) && ($_POST['content'] == "pharmacy_medicine_sell")) {
    $authenticate = new CreatePharmacyMedicineSell();
    $authenticate->post();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
