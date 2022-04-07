<?php
date_default_timezone_set("Asia/Dhaka");
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['loggedIn']))   // Checking whether the session is already there or not if
// true then header redirect it to the home page directly
{
    echo '<script type="text/javascript"> alert("Session lost");</script>';
    echo '<script type="text/javascript"> window.open("login.php","_self");</script>';            //  On Successful Login redirects to home.php
    exit();
    /* Redirect browser */
} else {
    if ($_SESSION['loggedIn'] == false || $_SESSION['user_Status'] == "Not Active" || ($_SESSION['user_type_access_level'] > 2 && $_SESSION['user_type_access_level'] != 4)) {
        echo '<script type="text/javascript"> window.open("login.php","_self");</script>';            //  On Successful Login redirects to home.php
        exit();
    }
}
?>