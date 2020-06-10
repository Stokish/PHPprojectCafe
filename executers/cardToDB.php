<?php
session_start();
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/classes/VHOD.php';
include $_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php';
require_once $_SERVER['DOCUMENT_ROOT']."/configures/DB_config.php";

if (isset($_POST["action"])) {
    if ($_POST["action"] == "delete") {
        foreach ($_SESSION['user_order'] as $keys => $values) {
            if ($values["food_id"] == $_POST["id"]) {
                // to check if a food with such id in cart
                $k = $_POST["id"];
                unset($_SESSION['user_order'][$keys]);

                $return = array("message" => "success");

                break;
            }
        }
        // to check if a food with such id in cart
        if(!isset($k)){
            $return = array("err" => "Can not delete not existing item ");
            http_response_code(400);
        }


    } elseif ($_POST["action"] =="change") {
        foreach ($_SESSION['user_order'] as $keys => $values) {
            if ($values["food_id"] == $_POST["id"]) {
                if($_POST["quantity"] > 0) {
                    // to check if a food with such id in cart
                    $p = $_POST["quantity"];
                    $_SESSION['user_order'][$keys]["food_quantity"] = $_POST["quantity"];

                    $quant =  $_POST["quantity"];

                    $return = array("message" => "success", "quant" => $quant);

                }else{
                    $p = $_POST["quantity"];
                    $return = array("err" => "Value must be bigger than 0! ");
                    http_response_code(400);
                }
                break;
            }
        }
        // to check if a food with such id in cart
        if(!isset($p)){
            $return = array("err" => "Can not change not existing item ");
            http_response_code(400);
        }
    } elseif ($_POST['action'] == "buy") {
        if (isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) && isset($_SESSION["user_order"]) && isset($_POST['total'])) {

                $total = doubleval($_POST['total']);

                $sql_insert_order = "INSERT INTO orders (order_id, date, cost ) VALUES (DEFAULT , DEFAULT, ?);";
                $stmt1 = $conn->prepare($sql_insert_order);
                $total_double = floatval($total);

                $stmt1->bind_param("d", $total_double);
                $bool_sql1 = $stmt1->execute();

                if ($bool_sql1 == TRUE) {
                    $sql_order = "SELECT MAX(order_id) as max_id FROM orders ";
                    $stmt2 = $conn->prepare($sql_order);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $row1 = $result2->fetch_assoc();
                    $order_id = $row1['max_id'];

                    $user = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);
                    $user_id = $user->getID($conn);

                    $sql_users = "INSERT INTO orders_users(order_id, user_id) VALUES (?,?);";
                    $stmt2 = $conn->prepare($sql_users);
                    $stmt2->bind_param("ii", $order_id, $user_id);
                    $bool_res = $stmt2->execute();
                    if ($bool_res == TRUE) {
                        foreach ($_SESSION['user_order'] as $keys => $values) {
                            $sql_product = "INSERT INTO orders_product(order_id, product_id) VALUES (?, ?);";
                            $stmt3 = $conn->prepare($sql_product);
                            $f_id = $values['food_id'];
                            $stmt3->bind_param("ii", $order_id, $f_id);

                            $inserted_product = $stmt3->execute();

                        }
                        unset($_SESSION["user_order"]);
                        $return = array("message"=> "success");

                    }
                }

        } else{
            $return = array("err" => "Can not buy, please try again later ");
            http_response_code(400);
        }
    }
}
echo json_encode($return);