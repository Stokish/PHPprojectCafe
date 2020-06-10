


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Italissimo</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/reg.css">


    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $("#sign_in_btn").click(function () {
                event.preventDefault();
                $.ajax('executers/signin_ajax.php', {
                    type: 'POST',
                    data: {
                        email: $("#user_email").val(),
                        password: $("#user_pass").val()
                    },
                    accepts: 'application/json; charset=utf-8',
                    beforeSend:function() {
                        $("#err").css('color', 'white');
                        $('#err').html('Loading...');
                        $("#err").show();
                    },
                    success: function (data) {
                        if (data.message === "success") {
                            window.location.href = "Menu.php";
                        } else{
                            $("#err").html(data.err);
                            $("#err").css('color', 'red');
                            $("#err").show();
                        }
                    }
                });
            });
        });
    </script>
</head>


<body>

<form  method="post" style="margin: 41vh 0;text-align: center;">
    <p id="err" style="color: red"></p>
    <label for="user_email">Email:</label>
    <br clear="all">
    <input type="Email" name="user_email" id="user_email" required>

    <br clear="all">

    <label for="user_pass">Password:</label>
    <br clear="all">
    <input type="password" name="user_pass" id="user_pass" reaquired>

    <br clear="all">
    <button class="submit" id="sign_in_btn">Log In</button>
</form>


</body>
</html>

