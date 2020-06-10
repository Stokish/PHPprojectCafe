<?php
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php';
require_once $_SERVER['DOCUMENT_ROOT']."/configures/DB_config.php";
session_start();

if(!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['address']) &&
    !empty($_POST['phone']) && !empty($_POST['email'])) {

    $user_name = $_POST['name'];
    $user_pass = $_POST['password'];
    $user_address = $_POST['address'];
    $user_phone = $_POST['phone'];
    $user_email =$_POST['email'];
    $user_type_id = 1;

    $sql_find_email = "SELECT * FROM users WHERE user_email LIKE ?";
    $stmt_email= $conn->prepare($sql_find_email);
    $stmt_email->bind_param("s", $user_email);
    $stmt_email->execute();
    $result = $stmt_email->get_result();

    $row = $result->fetch_assoc();
    if ($row != null) {
        $return = array('message' => 'reserved');
    } else {
        $sql_user_insert = "INSERT INTO users (user_id, user_name, user_phone, user_email, user_address, user_pass, user_type_id) VALUES (DEFAULT, ?, ?, ?, ?, ?, ? )";
        $stmt_2 = $conn->prepare($sql_user_insert);
        $stmt_2->bind_param("sssssi", $user_name, $user_phone, $user_email, $user_address, $user_pass, $user_type_id);
        $results = $stmt_2->execute();

        if ($results == TRUE) {

            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_pass'] = $user_pass;

            $return = array('message' => 'available');

        } else {
            $return = array(
                'err' => "Сan not add your account, please try later"
            );
        }
    }

} else {
    $return = array(
        'err' => "Not all fields are filled in!"
    );
}
echo json_encode($return);
