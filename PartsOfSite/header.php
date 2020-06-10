<script>
    $(document).ready(
        function () {
            if (<?php echo isset($_SESSION['user_order']) ? 1 : 0; ?>) {

                $("#cart_count").html(<?php
                    if(isset($_SESSION['user_order']))
                    echo ( count($_SESSION['user_order']) == 0 )? " ": count($_SESSION['user_order']) ;
                    ?>);
            }
                $(".font_size").click(
                    function(){
                        var font_val = $(this).attr("id");
                        $.ajax( "set_cookies.php", {
                            method: "POST",
                                data: { font: font_val },
                            accepts: 'application/json; charset=utf-8',
                            success: function (data) {
                                    $("body *").css("fontSize", data.font);
                            },
                            error: function (errorData, textStatus, errorMessage) {
                                alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                            }
                        });
                    });

            $("body *").css("fontSize", "<?php echo  (isset($_COOKIE["font"]))? $_COOKIE["font"] : "medium"; ?>");
        });
</script>
<!-- <header> -->

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom:2vh;">

    <a class="navbar-brand" href="index.php"><h2><strong>Cafe</strong></h2></a>  <!-- name of the Cafe -->


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <!-- Pages -->
            <li class="nav-item ">
                <a class="nav-link" href="index.php"><h4>Home</h4></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Menu.php"><h4>Menu</h4></a>
            </li>


            <li class="nav-item ">
                <a class="nav-link" href="cart.php"><h4>Online order
                            <sup id='cart_count' style=' color: red; font-weight: bolder; border-radius: 2vh; width: max-content'>
                            </sup>
                        </h4></a>
            </li>

            <?php
               if(isset($_SESSION['user_email'])){
               ?>
            <li class="nav-item ">
                <a class="nav-link" href="Orders.php"><h4>My previous orders</h4></a>
            </li>
            <?php } ?>


        </ul>

            <div class="nav-item float-right" style="padding: 0; margin: 0;">
                <form>
                    <label class="radio" >
                        Normal text
                        <input type="radio" class="font_size" name="font_size" id="medium" <?php echo  (isset($_COOKIE['font'])&& $_COOKIE['font'] == 'medium')? "checked": " ";  ?>>
                    </label>
                    <label class="radio">
                        Bigger text
                        <input type="radio" class="font_size" name="font_size" id="x-large" <?php echo (isset($_COOKIE['font']) && $_COOKIE['font'] == 'x-large')? "checked": " ";  ?>>
                    </label>
                </form>
            </div>
    </div>
</nav>
<p id="err" hidden></p>

