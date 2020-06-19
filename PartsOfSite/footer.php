
  <!-- footer -->
    <div class="footer" >


        <div class="bottom-box">
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

                <div style="display:flex; flex-wrap: wrap; margin: auto auto; justify-content: center">
                    <form  style="margin-right: 2vw;" >
                        <input type="hidden" name="action" value="logout">
                        <button  id="user_out" class="btn btn-danger my-1">Log out</button>
                    </form>
                    <form>
                        <input type="hidden" name="action" value="delete">
                        <button id="user_del" class="btn btn-danger my-1">Delete my account</button>
                    </form>
                </div>
            <?php } ?>

            <!-- DEFAULT FOOTER LINKS-->
            <ul>
                <li><a href="company.html">About Us</a></li>
                <li><a href="Developers.php">Developers</a></li>
                <li><a href="#">Contacts</a></li>
                <li><a href="#">&copy;Cafe    2020</a></li>
            </ul>
        </div>



    </div>