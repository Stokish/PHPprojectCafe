<?php
include $_SERVER['DOCUMENT_ROOT'].'/classes/VHOD.php';
include $_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php';
require_once $_SERVER['DOCUMENT_ROOT']."/configures/DB_config.php";
session_start();
header('Content-Type: application/json');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];


    $sign = new VHOD($email, $pass);
    $isSigned = $sign->check($conn);

    if ($isSigned == TRUE) {
        $_SESSION['user_email'] = $sign->getUserEmail();
        $_SESSION['user_pass'] = $sign->getUserPass();
        $return = array('message' => 'success');
    } else {
        $return = array('err' => 'Invalid username/password!');
    }
} else {
    $return = array('err' => 'Failed to load and check input');
}
echo json_encode($return);

