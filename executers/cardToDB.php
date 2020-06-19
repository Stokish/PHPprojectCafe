<?php
session_start();
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/classes/VHOD.php';
include $_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php';
require_once $_SERVER['DOCUMENT_ROOT']."/configures/DB_config.php";

if (isset($_POST["action"])) {
    //On Delete
    if ($_POST["action"] == "delete") {
        //finding food by id in session array
        foreach ($_SESSION['user_order'] as $keys => $values) {
            if ($values["food_id"] == $_POST["id"]) {
                // variable $k here is to check if a food with such id in cart
                $k = $_POST["id"];
                //deleting food from cart
                unset($_SESSION['user_order'][$keys]);

                //returning success message
                $return = array("message" => "success");
                //breaking loop after finding
                break;
            }
        }
        // if $k was not set, then food wasn't found in session array
        if(!isset($k)){
            //error message
            $return = array("err" => "Can not delete not existing item ");
            //set the HTTP response code
            http_response_code(400);
        }

        //On Change
    } elseif ($_POST["action"] =="change") {
        foreach ($_SESSION['user_order'] as $keys => $values) {
            if ($values["food_id"] == $_POST["id"]) {
                if($_POST["quantity"] > 0) {
                    //variable $p here is to check if a food with such id in cart
                    $p = $_POST["quantity"];
                    $_SESSION['user_order'][$keys]["food_quantity"] = $_POST["quantity"];

                    $quant =  $_POST["quantity"];

                    $return = array("message" => "success", "quant" => $quant);

                }else{
                    //variable $p here is to check if a food with such id in cart
                    $p = $_POST["quantity"];
                    //error message
                    $return = array("err" => "Value must be bigger than 0! ");
                    //set the HTTP response code
                    http_response_code(400);
                }
                break;
            }
        }
        // if $p was not set, then food wasn't found in session array
        if(!isset($p)){
            //error message
            $return = array("err" => "Can not change not existing item ");
            //set the HTTP response code
            http_response_code(400);
        }

        //On Buy
    } elseif ($_POST['action'] == "buy") {
        //checking if all necessary thing are set
        if (isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) && isset($_SESSION["user_order"]) && isset($_POST['total'])) {
                //saving total as a double
                $total = doubleval($_POST['total']);
                //SQL Insert to 'orders' table
                $sql_insert_order = "INSERT INTO orders (order_id, date, cost ) VALUES (DEFAULT , DEFAULT, ?);";
                $stmt1 = $conn->prepare($sql_insert_order);

                $stmt1->bind_param("d", $total);
                $bool_sql1 = $stmt1->execute();
                //if statement is successfully executed
                if ($bool_sql1 == TRUE) {
                    //finding tha last added order_id
                    $sql_order = "SELECT MAX(order_id) as max_id FROM orders ";
                    $stmt2 = $conn->prepare($sql_order);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $row1 = $result2->fetch_assoc();
                    //saving it
                    $order_id = $row1['max_id'];

                    //getting user id by creating an object of Class VHOD and using getID method
                    $user = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);
                    $user_id = $user->getID($conn);
                    //Inserting values to connect new order and user
                    $sql_users = "INSERT INTO orders_users(order_id, user_id) VALUES (?,?);";
                    $stmt2 = $conn->prepare($sql_users);
                    $stmt2->bind_param("ii", $order_id, $user_id);
                    $bool_res = $stmt2->execute();
                    //if statement is successfully executed
                    if ($bool_res == TRUE) {
                        //adding all items from cart to DataBase
                        foreach ($_SESSION['user_order'] as $keys => $values) {
                            $sql_product = "INSERT INTO orders_product(order_id, product_id) VALUES (?, ?);";
                            $stmt3 = $conn->prepare($sql_product);
                            $f_id = $values['food_id'];
                            $stmt3->bind_param("ii", $order_id, $f_id);
                            $inserted_product = $stmt3->execute();
                        }
                        //deleting cart session
                        unset($_SESSION["user_order"]);
                        //returning success message
                        $return = array("message"=> "success");
                    }
                }

        } else{
            //error message
            $return = array("err" => "Can not buy, please try again later ");
            //set the HTTP response code
            http_response_code(400);
        }
    }
}
//printing json version of $return
echo json_encode($return);