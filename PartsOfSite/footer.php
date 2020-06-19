
  <!-- footer -->
    <div class="footer">


        <div class="bottom-box mx-auto">
            <hr>


            <?php    if(isset($_SESSION['user_email']) && isset($_SESSION['user_pass'])){
                //SHOWING A LOG OUT AND DELETE ACCOUNT BUTTON IF LOGGED IN?>
                <script>
                    $(document).ready(
                        function() {
                            //FUNCTION ON CLICKING LOG OUT
                            $('#user_out').click(
                                function () {
                                    OUT("logout");
                                }
                            );

                            //FUNCTION ON CLICKING DELETE ACCOUNT
                            $('#user_del').click(
                                function () {
                                    OUT("delete");
                                }
                            );

                            //FUNCTION WITH AJAX
                            function OUT(action) {
                                event.preventDefault();
                                $.ajax( "executers/OUT_ajax.php",{
                                    method: "POST",
                                    data: {
                                        action: action
                                    },
                                    accepts: 'application/json; charset=utf-8',
                                    success: function (data) {
                                        if (data.mess === "success") {
                                            alert("Success!");
                                            window.location.reload();//reload page
                                        } else {
                                            alert(data.err);//alert error
                                        }
                                    }
                                });
                            }
                        }
                    );
                </script>

                <div style="display:flex; flex-wrap: wrap; margin: auto auto auto 6vw; justify-content: center">
                    <form  style="margin-right: 2vw;" >
                        <button  id="user_out" class="btn btn-danger my-1">Log out</button>
                    </form>
                    <form>
                        <button id="user_del" class="btn btn-danger my-1">Delete my account</button>
                    </form>
                </div>
            <?php } ?>

            <!-- DEFAULT FOOTER LINK-->
            <ul class="text-uppercase " style="" >
                <li ><a href="Developers.php" class="mx-auto">Developers</a></li>
            </ul>

        </div>


    </div>