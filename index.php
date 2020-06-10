<?php
include 'classes/ConnectDB.php';
require_once "configures/DB_config.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Italissimo</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/css.css">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"
              integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
              crossorigin="anonymous"></script>


      <?php require_once("PartsOfSite/header.php");?>




      <!-- BODY -->

    <body>

      <div class="flex">

            <div class="f-text">
              <h2>Welcome</h2>
              <p>We are new company that want to be one of the best in Kazakhstan. Hope you will find what you want in our cafe! :)</p>
            </div>

            <div class="f-img">
                <img class="img-img" src="photo/index/wel.jpg" alt="">
            </div>

      </div>

      <div class="flex">

            <div class="f-img">
                <img class="img-img" src="photo/index/price.jpg" alt="">
            </div>

            <div class="f-text">
              <h2>Accessible and cheap prices</h2>
              <p>We made our food from best and fresh products only to make our clients happy.</p>
            </div>

      </div>


            <div class="flex">

                  <div class="f-text">
                    <h2>Soon...</h2>
                    <p>We want to make easier to get our products for people. For this we are going to make program "Online Order" that you can use in our site. </p>
                  </div>

                  <div class="f-img">
                      <img class="img-img" src="photo/index/order.jpg" alt="">
                  </div>

            </div>

            <div class="flex">

                  <div class="f-img">
                      <img class="img-img" src="photo/index/coffee.jpg" alt="">
                  </div>

                  <div class="f-text">
                    <h2>Coffee</h2>
                    <p>Recently we added coffee in our menu. So now you can come and get a really good and hot cup of coffee. Also, you can take it out. </p>
                  </div>

            </div>


    </body>



<!-- footer -->
  <div class="footer" >


        <div class="bottom-box">
            <hr>
            <ul>
                <li><a href="company.html">About Us</a></li>
                <li><a href="Developers.php">Developers</a></li>
                <li><a href="#">Contacts</a></li>
                <li><a href="#">&copy;Cafe    2020</a></li>
            </ul>
        </div>



  </div>

</html>
