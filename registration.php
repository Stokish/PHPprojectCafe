<?php
include 'classes/ConnectDB.php';
require_once "configures/DB_config.php";
session_start();
?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-Up</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/reg.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {


            $('form').validate({
                submitHandler: function(form) {
                    sendAjaxForm();
                }
            });
            function sendAjaxForm() {
                $.ajax('executers/reg_ajax.php', {
                    type: 'POST',
                    data: {
                        name: $("#user_name").val(),
                        password: $("#user_pass").val(),
                        address: $("#user_address").val(),
                        phone: $("#user_phone").val(),
                        email: $("#user_email").val()
                    },
                    accepts: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#err_mess").hide();
                        if(data.message === "available") {
                            $("body").html("<div style='margin: 45vh 40vh; text-align: center'>" +
                                "               <a class='btn btn-success'  href='Menu.php'>You have successfully created an account!</a>" +
                                "           </div>");
                        } else if(data.message === "reserved") {
                            $("#err").html("Account is already reserved!");
                            $("#err").css('color', 'red');
                            $("#err").show();
                        } else {
                            $("#err").html(data.err);
                            $("#err").css('color', 'red');
                            $("#err").show();
                        }
                    }

                });
            }
            });
    </script>
</head>

<body>


<div class="signin">
    <p>Already have an account? <a class="btn btn-outline-success" href="signin.php">Sign in</a></p>
</div>


<form >
    <p id="err" style="display: none"></p>
    <label for="user_name">Full Name:</label>
    <br clear="all">
    <input type="text" name="user_name" id="user_name" required>

    <br clear="all">

    <label for="user_pass">Password:</label>
    <br clear="all">
    <input type="password" name="user_pass" id="user_pass" required>

    <br clear="all">

    <label for="user_address">Address:</label>
    <br clear="all">
    <input type="text" name="user_address" id="user_address" required>

    <br clear="all">

    <label for="user_phone">Phone:</label>
    <br clear="all">
    <input type="text" placeholder="87777777777" title="Enter Valid mobile number ex.9811111111" name="user_phone" id="user_phone" pattern="[8][0-9]{10}" required >

    <br clear="all">

    <label for="user_email">Email:</label>
    <br clear="all">
    <input type="email" name="user_email" id="user_email" required>

    <br clear="all">


    <button class="register" id="reg_btn">Create new account</button>
</form>



</body>

</html>