<?php
require_once __DIR__ . '/Connection.php';
class Token{
    function token_generate($user_id, $conn)
    {

        try {
            $token = bin2hex(random_bytes(20));
        } catch (Exception $e) {
            echo "Error : " . $e->getMessage();
        }

        $get_token = "select * from user_token where user_id ='$user_id'";
        $getJson = $conn->prepare($get_token);
        $getJson->execute();
        $result = $getJson->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0) {
            $sql = "UPDATE user_token SET user_token_no ='$token' WHERE user_id ='$user_id'";
        }
        else{
            $sql = "INSERT INTO user_token (user_id, user_token_no)
            VALUES ('$user_id', '$token')";
        }
        try {
            $getJson = $conn->prepare($sql);
            $response = $getJson->execute();
            //echo $response;
            //die();
        }
        catch (PDOException $e) {
            echo "Error : " . $e->getMessage();

        }
        return $token;

    }
    function check_token($user_id, $conn, $token)
    {
        $get_token = "select * from user_token where user_id ='$user_id' and user_token_no ='$token'";
        //echo $get_token;
        $getJson = $conn->prepare($get_token);
        $getJson->execute();
        $result = $getJson->fetchAll(PDO::FETCH_ASSOC);
        //echo count($result);
        if(count($result) > 0) {
            return true;
        }
        else{
            return false;
        }
    }
    function check_permission($user_id, $conn, $required_permission_level)
    {
      
       
        $get_token = "select * from user left join user_type ut on user.user_type_id = ut.user_type_id
                            where user.user_id='$user_id'";
        //echo $get_token;
        $getJson = $conn->prepare($get_token);
        $getJson->execute();
        $result = $getJson->fetchAll(PDO::FETCH_ASSOC);
        //echo count($result);
        if(count($result) > 0) {
            foreach($result as $data)
            {
                foreach($required_permission_level as $permission_level){
                    if($data['user_type_access_level'] == $permission_level)
                    {
                        return true;
                    }
                }
               
            }
        }
        return false;
    }
}

?>