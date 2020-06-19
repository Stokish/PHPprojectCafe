<?php //classes and configures
      include 'classes/Action.php';
      include 'classes/Admin.php';
      include 'classes/ConnectDB.php';
      include 'classes/Food.php';
      require_once "configures/DB_config.php";

session_start();
//Creating an object of VHOD (user) class
if( isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) )
$user = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);

if( isset($_POST['action']) && isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) ) {
//Creating an object of Action class to log out
$act = new Action($_SESSION['user_email'], $_SESSION['user_pass'], $_POST['action']);
$b = $act->DoAction($conn);

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Menu</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/menu.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>

    <script>
        $(document).ready(
            function() {
                $('.addCart').click(
                    function () {
                        //preventing default
                        event.preventDefault();
                        //getting an id of food from "id" attribute of a button
                        var foodID = $(this).attr("id");
                        //clearing from other symbols, and only digits save
                        foodID = foodID.replace(/\D/g,'');
                        //Getting a name by id of a food and "id" attribute
                        var foodName = $('#n' + foodID).text();
                        //Same
                        var foodCost = $('#c' + foodID).text();
                        //replacing "," with "."
                        foodCost = foodCost.replace(/,/g,'.');
                        //making a float from text
                        foodCost = parseFloat(foodCost);
                        //getting quantity of a chosen food
                        var foodQuantity = $('#q' + foodID).val();
                        //AJAX
                        $.ajax( "executers/cart_ajax.php",{
                            method: "POST",
                            data: {
                                addCart: true,
                                f_id: foodID,
                                f_name: foodName,
                                f_cost: foodCost,
                                f_quantity: foodQuantity
                            },
                            accepts: 'application/json; charset=utf-8',
                            success: function (data) {
                                if (data.message === "success") {
                                    //alerting about success
                                    alert("Successfully added to cart");
                                    //changing number in header
                                    $("#cart_count").html(data.count + 1);
                                } else {
                                    //alerting that item is already in cart
                                    alert('Item Already Added');
                                }
                            },//errors showing
                            error: function (errorData, textStatus, errorMessage) {
                                alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                            }
                        });
                    });
                });
    </script>
</head>
<?php require_once("PartsOfSite/header.php");?>

<!-- BODY -->
<body>
<div class="menu">
    <?php
    //action for Admin
    if(isset($user) && $user->getTypeID($conn) == "2")
    {
        $admin = new Admin($_SESSION['user_email'], $_SESSION['user_pass']);

        //It is not a form it is performing an action
        if(isset($_POST['admin_add']))
        $admin->AdminAddProduct($conn);

        //It is not a form it is performing an action
        if(isset($_POST['admin_delete']))
        $admin->AdminDeleteProduct($conn, $_POST['delete_product_id']);

        //It is not a form it is performing an action
        if(isset($_POST['admin_edit']))
        $admin->AdminEditProduct($conn, $_POST['edit_product_id']);

        //Show ADD form
        $admin->AdminAddForm($conn);
    }
    ?>
    <h2 class="menu-font">MENU</h2>
    <hr>

    <div class="container">
        <div class="row">

            <div class="col-lg">
                <div class="col-name">
                    <h3>Food</h3>
                    <hr>
                </div>
                <?php
                //making an object of Food Class
                $Menu = new Food(isset($admin)? $admin : null, isset($user)? $user : null);
                echo $Menu->food("Breakfast", $conn);
                ?>
            </div>



            <div class="col-lg">
                <div class="col-name">
                    <h3>Drinks</h3>
                    <hr>
                </div>
                <?php
                //making an object of Food Class
                $Menu = new Food(isset($admin)? $admin : null, isset($user)? $user : null);
                echo $Menu->food("Coffee", $conn);
                ?>
                <?php
                //making an object of Food Class
                $Menu = new Food(isset($admin)? $admin : null, isset($user)? $user : null);
                echo $Menu->food("Tea", $conn);
                ?>

                <?php
                //making an object of Food Class
                $Menu = new Food(isset($admin)? $admin : null, isset($user)? $user : null);
                echo $Menu->food("Lemonade", $conn);
                ?>

            </div>

            <div class="col-lg">
                <div class="col-name">
                    <h3>Deserts</h3>
                    <hr>
                </div>
                <?php
                //making an object of Food Class
                $Menu = new Food(isset($admin)? $admin : null, isset($user)? $user : null);
                echo $Menu->food("Fresh desserts", $conn);
                ?>
            </div>

        </div>
    </div>

</div>

<?php require_once("PartsOfSite/footer.php");//footer?>

</body>
</html>
