<?php
include $_SERVER['DOCUMENT_ROOT'].'/classes/VHOD.php';
include $_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php';
require_once $_SERVER['DOCUMENT_ROOT']."/configures/DB_config.php";
session_start();
header('Content-Type: application/json');

//if we got all fields
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //creating an object of VHOD class
    //check method searches for an account in DataBase
    $sign = new VHOD($email, $pass);
    $isSigned = $sign->check($conn);

    //if account was found
    if ($isSigned == TRUE) {
        //saving in session
        $_SESSION['user_email'] = $sign->getUserEmail();
        $_SESSION['user_pass'] = $sign->getUserPass();
        //success message
        $return = array('message' => 'success');
    } else {
        //printing error message if such account was not found
        $return = array('err' => 'Invalid email/password!');
    }

//if we didn't get any required field
} else {
    $return = array('err' => 'Not all fields are filled in!');
}
//printing json version of $return
echo json_encode($return);

