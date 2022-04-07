<?php

/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 3/6/19
 * Time: 5:50 PM
 */

// include db connect class
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/related_func.php';

class Authentication
{

    function authenticate()
    {
        $connection = new Connection();
        $conn = $connection->getConnection();
        //array for json response
        $response = array();
        $status = "status";
        $message = "message";
        $Email   = if_empty($_POST['email']);
        // $phone   = if_empty($_POST['user_PhoneNo']);
        $Password   = $_POST['password'];
        $token = "token";

        if ((!empty($Email) || !empty($phone)) && !empty($Password)) {
            $get_user = "select * from user NATURAL JOIN user_type";

            $getJson = $conn->prepare($get_user);
            $getJson->execute();
            $result = $getJson->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {

                foreach ($result as $data) {
                    $secure_password = $data['user_Password'];
                    $user_password = MD5($Password);
                    $login_with = 0;
                    if (isset($Email) && !empty($Email) && $Email != "") {
                        if ($data['user_Email'] == $Email && $secure_password == $user_password) {
                            $login_with = 1;
                        } else {
                            $login_with = 0;
                        }
                    } else if (isset($phone) && !empty($phone) && $phone != "") {
                        if ($data['user_PhoneNo'] == $phone && $secure_password == $user_password) {
                            $login_with = 1;
                        } else {
                            $login_with = 0;
                        }
                    } else {
                        echo json_encode(array("user_authenticate" => null, $status => 0, $message => "Email/Phone/Password missing"));
                        die();
                    }
                    if ($login_with) {

                        array_push(
                            $response,
                            array(
                                'user_id' => $data['user_id'],
                                'user_Full_Name' => $data['user_Full_Name'],
                                'user_PhoneNo' => $data['user_PhoneNo'],
                                'user_Email' => $data['user_Email'],
                                'user_Status' => $data['user_Status'],
                                'user_type_Name' => $data['user_type_Name'],
                                'user_type_access_level' => $data['user_type_access_level']

                            )
                        );

                        $authenticate = new Token();
                        $token = $authenticate->token_generate($data['user_id'], $conn);

                        break;
                    }
                }

                if (count($response) > 0) {
                    echo json_encode(array("user_authenticate" => $response, "token" => $token, $status => 1, $message => "User Authentication Successful"));            //  On Successful Login redirects to home.php
                } else {
                    echo json_encode(array("user_authenticate" => null, $status => 0, $message => "Authentication Error"));
                }
                die();
            } else {
                echo json_encode(array("user_authenticate" => null, $status => 0, $message => "Authentication Error"));
                die();
            }
        } else {
            echo json_encode(array("user_authenticate" => null, $status => 0, $message => "Email/Password missing"));
            die();
        }
    }
}
if (isset($_POST['login']) && ($_POST['login'] == "authenticate"))   // it checks whether the user clicked login button or not
{
    $authenticate = new Authentication();
    $authenticate->authenticate();
} else {
    echo json_encode(array("message" => "Bad Request"));
    die();
}
