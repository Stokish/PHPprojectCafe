<?php
include "classes/VHOD.php";
include 'classes/Admin.php';
include 'classes/ConnectDB.php';
require_once "configures/DB_config.php";
session_start();


require_once ("executers/GuestVoydi.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>My Cart</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/css.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(
            function() {
                //on click Change button
                $(".ChangeCart").click(function () {
                    //preventing default
                    event.preventDefault()
                    //getting an id of food from "id" attribute of a button
                    var prod_id = $(this).attr("id");
                    //clearing from other symbols, and only digits save
                    prod_id = prod_id.replace(/\D/g,'');
                    //getting quantity of a chosen food
                    var quant = $("#quant" + prod_id).val();
                    //AJAX
                    $.ajax("executers/cardToDB.php", {
                        method: "POST",
                        data: {
                            action: "change",
                            id: prod_id,
                            quantity: quant
                        },
                        accepts: 'application/json; charset=utf-8',
                        success: function (data) {
                                $("#quant" + prod_id).val(data.quant);
                                alert('Item Changed');
                                window.location.reload();//reload page
                        },
                        error: function (errorData, textStatus, errorMessage) {
                            alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                        }
                    });
                });

                //on click Delete button
                $(".DeleteCart").click(function () {
                    //preventing default
                    event.preventDefault()
                    //getting an id of food from "id" attribute of a button
                    var prod_id = $(this).attr("id");
                    //clearing from other symbols, and only digits save
                    prod_id = prod_id.replace(/\D/g,'');
                    //making integer from text
                    prod_id = parseInt(prod_id);
                    $.ajax("executers/cardToDB.php", {
                        method: "POST",
                        data: {
                            action: "delete",
                            id: prod_id
                        },
                        accepts: 'application/json; charset=utf-8',
                        success: function (data) {
                            alert('Item Removed');
                            window.location.reload();//reload page
                        },
                        error: function (errorData, textStatus, errorMessage) {
                            alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                        }
                    });
                });

                //on click Buy button
                $("#BUY_BTN").click(function () {
                    //preventing default
                    event.preventDefault()
                    //getting float from text
                    var tot = parseFloat($("#total_order").text());
                    //AJAX
                    $.ajax("executers/cardToDB.php", {
                        method: "POST",
                        data: {
                            action: "buy",
                            total: tot
                        },
                        accepts: 'application/json; charset=utf-8',
                        success: function (data) {
                                alert('Your order will arrive soon!');
                                window.location.replace('Orders.php');//redirect to Order.php
                        },
                        error: function (errorData, textStatus, errorMessage) {
                            alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                        }
                    });
                });

            });
    </script>
<body>
<?php require_once("PartsOfSite/header.php");?>

<?php
//show info of a user or admin
if( isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) ){
    $info = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);
    if($info->getTypeID($conn)  == 2){
        $admin_info = new Admin($info->getUserEmail(), $info->getUserPass());
        $admin_info->showInfo($conn);
    }else {
        $info->showInfo($conn);
    }
}
?>

    <h3 align="center">Order details</h3>
    <form>

    <table class="table table-bordered table-hover">
            <tr>
                <th width="25%">Item name</th>
                <th width="25%">Quantity</th>
                <th width="15%">Total</th>
                <th width="15%">Action</th>
            </tr>
            <?php
            $total = 0;
            if(!empty($_SESSION["user_order"])) {

                foreach ($_SESSION["user_order"] as $keys => $values) {
                    ?>
                    <tr>
                        <!-- Show name of a food -->
                        <td><?php echo $values["food_name"]; ?></td>
                        <!-- Change quantity of a food -->
                        <td>
                            <form>
                                <input type="number" id='quant<?php echo $values['food_id']?>' name="quantity" class="form-control"  min="1" value="<?php echo $values['food_quantity']; ?>">
                                <input id='ch<?php echo $values['food_id']?>' type="submit" name="action"  class="btn btn-success ChangeCart" value="Change">
                            </form>
                        </td>

                        <!-- Show quantity of a food and overall cost -->
                        <td>$ <?php echo $values["food_cost"] . " * " . $values['food_quantity'] . " = $ " . number_format($values['food_quantity'] * $values['food_cost'], 2); ?></td>

                        <!-- Remove from cart -->
                        <td>
                            <button id='del<?php echo $values['food_id']?>' class="DeleteCart btn btn-danger">Remove</button>
                        </td>
                    </tr>
                    <?php
                    //calculating total cost  of a cart
                    $total = $total + ($values['food_quantity'] * $values['food_cost']);
                }
            }
                ?>
                <tr>
                    <td colspan="2" align="right">Total</td>
                    <td>$ <span id="total_order"><?php
                            //show total
                            doubleval(number_format($total, 2));
                        echo number_format($total, 2);
                        ?></span></td>
                </tr>
                <?php

            ?>
        </table>
        <div style="display: flex; justify-content: center" >
            <input id="BUY_BTN" type="submit" name="action" class="btn btn-info mx-auto" value="buy" <?php
            //disable button if cart is empty
            $total = doubleval(number_format($total, 2));
            if($total == 0.00){
                echo "disabled";
            } ?>>
        </div>
    </form>

<?php require_once("PartsOfSite/footer.php");?>
</body>
</html>