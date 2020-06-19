<?php
include 'classes/Action.php';
include 'classes/Admin.php';
include 'classes/ConnectDB.php';
require_once "configures/DB_config.php";
session_start();
if(!isset($_SESSION['user_email'])){
    header("Location: Menu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>My previous orders</title>
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
</head>
<?php require_once("PartsOfSite/header.php");?>


<!-- BODY -->

<body>
<div class="container">
    <div class="d-flex align-content-center flex-wrap">
<?php
//if logged in show order of a user
if( isset($_SESSION['user_email']) && isset($_SESSION['user_pass'])  ){
    //getting user id by creating an object of Class VHOD and using getID method
    $user = new VHOD($_SESSION['user_email'], $_SESSION['user_pass']);
    $user_id = $user->getID($conn);

    // Showing differen orders made by user
    $sql = "SELECT DISTINCT * FROM orders 
            WHERE orders.order_id  IN ( 
            SELECT orders_users.order_id FROM orders_users INNER JOIN users ON orders_users.user_id = users.user_id WHERE users.user_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    //getting number of rows
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($row = $result->fetch_assoc()){
?>
        <div class="card mx-2 w-25" style="margin-top: 30px">
            <h4 class="food"> Your Order #<?php
                $order_id1 = $row['order_id'];
                echo   $order_id1 ?></h4>

            <div class="container">
                <h5><?php echo $row['date'] ?></h5>
                <p>$<?php echo $row['cost'] ?></p>
            </div>

            <details>
                <summary>About<hr></summary>
                <ul>
                    <?php
                    //new Sql statement to get info about gained product in order
                    $sql_new = "SELECT product.product_name
                                FROM product 
                                WHERE product_id 
                                IN ( SELECT orders_product.product_id 
                                    FROM orders_product 
                                    INNER JOIN product ON orders_product.product_id = product.product_id 
                                    WHERE orders_product.order_id = ?);";
                    $stmt_a = $conn->prepare($sql_new);
                    $stmt_a->bind_param("i", $order_id1);
                    $stmt_a->execute();
                    $result1 = $stmt_a->get_result();
                    while($row1 = $result1->fetch_assoc()) {
                        echo "<li>".$row1['product_name']."</li>";
                    }?>
                </ul>
            </details>
        </div>
    <?php
        }
        //Showing these if num_rows == 0
    } else {
        ?>
        <p><h3>0 Result.</h3></p>
        <p>&nbsp;</p>
        <p><h4>It seems tha you haven't ordered anything yet </h4> </p>
        <?php
    }

}
?>
</div>
</div>
<?php require_once ("PartsOfSite/footer.php");?>
</body>
</html>