<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/reg.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <!--JQuery's module for validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            //On validation do sendAjaxForm function
            $('form').validate({
                submitHandler: function(form){
                    sendAjaxForm();
                }});


            function sendAjaxForm() {
                //Ajax to register a new account
                $.ajax('executers/reg_ajax.php', {
                    type: 'POST',
                    data: {
                        name: $("#user_name").val(),
                        password: $("#user_pass").val(),
                        address: $("#user_address").val(),
                        email: $("#user_email").val()
                    },
                    accepts: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#err_mess").hide();
                        if(data.message === "available") {
                            //showing button that will relocate to Menu.php
                            $("body").html("<div style='margin: 45vh 40vh; text-align: center'>" +
                                "               <a class='btn btn-success'  href='Menu.php'>You have successfully created an account!</a>" +
                                "           </div>");
                        } else if(data.message === "reserved") {
                            //show message that account is reserved
                            $("#err").html("Account is already reserved! Change email address");
                            $("#err").css('color', 'red');
                            $("#err").show();
                        } else {
                            //show other errors
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

<!-- To relocate to signin.php if user has account -->
<div class="signin">
    <p>Already have an account? <a class="btn btn-outline-success" href="signin.php">Sign in</a></p>
</div>


<form>
    <!-- For showing errors -->
    <p id="err" style="display: none"></p>
    <!-- Full Name  -->
    <label for="user_name">Full Name:</label>
    <br clear="all">
    <input type="text" name="user_name" id="user_name" required>

    <br clear="all">

    <!-- Password -->
    <label for="user_pass">Password:</label>
    <br clear="all">
    <input type="password" name="user_pass" id="user_pass" required>

    <br clear="all">

    <!-- Address -->
    <label for="user_address">Address:</label>
    <br clear="all">
    <input type="text" name="user_address" id="user_address" required>


    <br clear="all">

    <!-- Email -->
    <label for="user_email">Email:</label>
    <br clear="all">
    <input type="email" name="user_email" id="user_email" required>

    <br clear="all">

    <!--Button to submit -->
    <input type="submit" class="register" id="reg_btn" value="Create new account">
</form>



</body>

</html>