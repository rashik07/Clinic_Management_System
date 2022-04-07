<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 3/6/19
 * Time: 7:28 PM
 */


if(!isset($_SESSION)) {
    session_start();

}

$_SESSION['loggedIn']=false;
$_SESSION['token']=null;
$_SESSION['user_id']=null;
$_SESSION['user_Full_Name']=null;
$_SESSION['user_type_Name']=null;
$_SESSION['user_type_access_level']=null;
$_SESSION['user_Status']=null;

session_destroy();
