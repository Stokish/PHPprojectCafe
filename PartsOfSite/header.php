<script>
    $(document).ready(
        function () {

            if (<?php echo isset($_SESSION['user_order']) ? 1 : 0;// IF CART HAS ADDED?>) {
                $("#cart_count").html(<?php
                    //COUNTING ITEMS IN CART
                    if(isset($_SESSION['user_order']))
                    echo ( count($_SESSION['user_order']) == 0 )? " ": count($_SESSION['user_order']);
                    ?>
                );
            }
            //FUNCTION WHEN CLICK ON FONT-SIZE RADIO BUTTONS
                $(".font_size").click(
                    function(){
                        //NEEDED FONT-SIZE IN ID OF A BUTTON
                        var font_val = $(this).attr("id");
                        //AJAX
                        $.ajax( "executers/set_cookies.php", {
                            method: "GET",
                            data: { font: font_val },
                            accepts: 'application/json; charset=utf-8',
                            success: function (data) {
                                 $("body *").css("fontSize", data.font);//сhanging font size
                            },
                            error: function (errorData, textStatus, errorMessage) {
                                alert(errorData.responseJSON.err + " (" + errorData.status + ")");
                            }
                        });
                    });
            //сhanging font size
            $("body *").css("fontSize", "<?php echo  (isset($_COOKIE["font"]))? $_COOKIE["font"] : "medium"; ?>");
        });
</script>
<!-- <header> -->
<?php require_once ( $_SERVER['DOCUMENT_ROOT']."/executers/GuestVoydi.php"); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom:2vh;">

    <a class="navbar-brand" href="index.php"><h2><strong>Cafe</strong></h2></a>  <!-- name of the Cafe -->


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <!-- Pages -->
            <li class="nav-item <?php if (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) =="index.php") echo "active";
            //adding class active if it is a current page?>">
                <a class="nav-link" href="index.php" ><h4>Home</h4></a>
            </li>

            <li class="nav-item <?php if (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) =="Menu.php") echo "active";
            //adding class active if it is a current page?>">
                <a class="nav-link" href="Menu.php"><h4>Menu</h4></a>
            </li>


            <li class="nav-item <?php if (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) =="cart.php") echo "active";
            //adding class active if it is a current page?>">

                <a class="nav-link" href="cart.php"><h4>Online order
                            <sup id='cart_count' style='color: red; font-weight: bolder;'>
                            </sup>
                        </h4></a>
            </li>

            <?php //showing my previous orders if user is logged in
               if(isset($_SESSION['user_email'])){
               ?>
            <li class="nav-item ">
                <a class="nav-link <?php if (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) =="Orders.php") echo "active";
                //adding class active if it is a current page?>" href="Orders.php"><h4>My previous orders</h4></a>
            </li>
            <?php } ?>


        </ul>

            <div class="nav-item float-right" style="padding: 0; margin: 0;">
                <form>
                    <label class="radio" >
                        Normal text
                        <input type="radio" class="font_size" name="font_size" id="medium" <?php echo  (!isset($_COOKIE['font']))? "checked": " "; //checked mark if cookies are set  ?>>
                    </label>
                    <label class="radio">
                        Bigger text
                        <input type="radio" class="font_size" name="font_size" id="x-large" <?php echo (isset($_COOKIE['font']) && $_COOKIE['font'] == 'x-large')? "checked": " ";  //checked mark if cookies are set ?>>
                    </label>

                </form>
            </div>
    </div>
</nav>
<p id="err" hidden></p>

