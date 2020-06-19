<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST["addCart"])) {
    //if quantity is bigger than 0 then add to cart
    if($_POST['f_quantity'] > 0) {
        //if $_SESSION["user_order"] is already initiated
        if (isset($_SESSION["user_order"])) {
            //returns the values from a single column in the input array
            $food = array_column($_SESSION["user_order"], "food_id");
            //search if food is already in cart
            if (!in_array($_POST["f_id"], $food)) {
                //COUNTING ITEMS IN CART
                $count = count($_SESSION["user_order"]);
                //creating an associative array
                $food_array = array(
                    'food_id' => $_POST['f_id'],
                    'food_name' => $_POST['f_name'],
                    'food_quantity' => $_POST['f_quantity'],
                    'food_cost' => $_POST['f_cost']
                );
                //adding  $food_array as an item to session array
                $_SESSION["user_order"][$count] = $food_array;

                //returning success message and counted items
                $return = array(
                    "message" => "success",
                    "count" => $count
                );
            } else {
                //returning this message if food is already in cart
                $return = array("message" => "already");
            }
        } else {
            //if $_SESSION["user_order"] is not initiated
            $food_array = array(
                'food_id' => $_POST['f_id'],
                'food_name' => $_POST['f_name'],
                'food_quantity' => $_POST['f_quantity'],
                'food_cost' => $_POST['f_cost']
            );
            //adding this array as first element of $_SESSION["user_order"]
            $_SESSION["user_order"][0] = $food_array;
            $return = array(
                "message" => "success",
                "count" => 0);
        }
    } else{
        //error message if quantity is less than or equal to 0
        $return = array(
            "err" => "Quantity must be bigger than 0");
        //set the HTTP response code
        http_response_code(400);
    }
} else{
    //error message if didn't receive anything
    $return = array(
        "err" => "Couldn't add to cart, try again later.");
    //set the HTTP response code
    http_response_code(400);
}
//printing json version of $return
echo json_encode($return);