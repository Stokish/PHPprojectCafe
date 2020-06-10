<?php
    include 'classes/Action.php';
      include 'classes/Admin.php';
      include 'classes/ConnectDB.php';
      require_once "configures/DB_config.php";
      require_once "executers/menu_vid.php";
session_start();


require_once ("executers/GuestVoydi.php");

if( isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) )
$user = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);

if( isset($_POST['action']) && isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) ) {

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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>

    <script>
        $(document).ready(
            function() {
                $('.addCart').click(
                    function () {
                        event.preventDefault();
                        var foodID = $(this).attr("id");
                        foodID = foodID.replace(/\D/g,'');

                        var foodName = $('#n' + foodID).text();


                        var foodCost = $('#c' + foodID).text();
                        foodCost = foodCost.replace(/,/g,'.');
                        foodCost = parseFloat(foodCost);

                        var foodQuantity = $('#q' + foodID).val();
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
                                    alert("Successfully added to cart");
                                    $("#cart_count").html(data.count + 1);
                                } else {
                                    alert('Item Already Added');
                                }
                            },
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
    if(isset($user) && $user->getTypeID($conn) == "2")
    {
        $admin = new Admin($_SESSION['user_email'], $_SESSION['user_pass']);

        if(isset($_POST['admin_add']))
        $admin->AdminAddProduct($conn);

        if(isset($_POST['admin_delete']))
        $admin->AdminDeleteProduct($conn, $_POST['delete_product_id']);

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
                echo food("Breakfast", $conn, isset($admin)? $admin : null);
                ?>
            </div>



            <div class="col-lg">
                <div class="col-name">
                    <h3>Drinks</h3>
                    <hr>
                </div>
                <?php
                echo food("Coffee", $conn, isset($admin)? $admin : null);
                ?>
                <?php
                echo food("Tea", $conn,isset($admin)? $admin : null);
                ?>

                <?php
                echo food("Lemonade", $conn, isset($admin)? $admin : null);
                ?>

            </div>

            <div class="col-lg">
                <div class="col-name">
                    <h3>Deserts</h3>
                    <hr>
                </div>
                <?php
                echo food("Fresh desserts", $conn, isset($admin)? $admin : null);
                ?>
            </div>

        </div>
    </div>

</div>

<?php require_once("PartsOfSite/footer.php");?>

</body>
</html>
