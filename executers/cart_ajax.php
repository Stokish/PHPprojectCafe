<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST["addCart"])) {
    if($_POST['f_quantity'] > 0) {
        if (isset($_SESSION["user_order"])) {

            $food = array_column($_SESSION["user_order"], "food_id");
            if (!in_array($_POST["f_id"], $food)) {
                $count = count($_SESSION["user_order"]);
                $food_array = array(
                    'food_id' => $_POST['f_id'],
                    'food_name' => $_POST['f_name'],
                    'food_quantity' => $_POST['f_quantity'],
                    'food_cost' => $_POST['f_cost']
                );
                $_SESSION["user_order"][$count] = $food_array;


                $return = array(
                    "message" => "success",
                    "count" => $count
                );
            } else {
                $return = array("message" => "already");
            }
        } else {
            $food_array = array(
                'food_id' => $_POST['f_id'],
                'food_name' => $_POST['f_name'],
                'food_quantity' => $_POST['f_quantity'],
                'food_cost' => $_POST['f_cost']
            );
            $_SESSION["user_order"][0] = $food_array;
            $return = array(
                "message" => "success",
                "count" => 0);
        }
    } else{
        $return = array(
            "err" => "Quantity must be bigger than 0");
        http_response_code(400);
    }
} else{
    $return = array(
        "err" => "Couldn't add to cart, try again.");
    http_response_code(400);
}


echo json_encode($return);
?>