<?php
//showing this div if user is not logged in
if(!isset($_SESSION['user_email'])) {

    print "<div class='bg-danger' style='text-align: center; color: azure; '>
                        <p class='py-2' > You can't do online shopping as soon as you are not logged in!
                         <a class='btn btn-outline-light' href='signin.php'>Sign in</a>
                         <a class='btn btn-outline-light' href='registration.php'>Sign up</a> 
                         </p>
                 </div>";
}