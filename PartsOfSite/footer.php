
  <!-- footer -->
    <div class="footer" >


        <div class="bottom-box">
            <hr>
            <?php    if(isset($_SESSION['user_email']) && isset($_SESSION['user_pass'])){?>
                <div style="display:flex; flex-wrap: wrap; margin: auto auto; justify-content: center">
                    <form  style="margin-right: 2vw;" method="post" action="UserAction.php">
                        <input type="hidden" name="action" value="logout">
                        <button  class="btn btn-danger my-1" >Log out</button>
                    </form>
                    <form  method="post" action="UserAction.php">
                        <input type="hidden" name="action" value="delete">
                        <button  class="btn btn-danger my-1" >Delete my account</button>
                    </form>
                </div>
            <?php } ?>
            <ul>
                <li><a href="company.html">About Us</a></li>
                <li><a href="Developers.php">Developers</a></li>
                <li><a href="#">Contacts</a></li>
                <li><a href="#">&copy;Cafe    2020</a></li>
            </ul>
        </div>



    </div>