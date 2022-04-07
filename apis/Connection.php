<?php

/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 3/6/19
 * Time: 5:48 PM
 */

class Connection
{
    function getConnection()
    {
        //server conf
        // user = mtcclini_hms
        // pass = hms@icthub
        // db   = mtcclini_hms

        // $host       = "localhost";
        // $username   = "mtcclini_hms";
        // $password   = "hms@icthub";

        $host       = "localhost";
        $username   = "root";
        $password   = "";


        $dbname     = "mtcclini_hms";

        try {
            $conn    = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "ERROR CONNECTIONF : " . $e->getMessage();
        }
        return null;
    }
}
