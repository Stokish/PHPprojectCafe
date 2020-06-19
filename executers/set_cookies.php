<?php
header('Content-Type: application/json');
if(isset($_GET['font'])){
    //saving font size
    $font =$_GET["font"];

    if($_GET["font"] == "x-large")
        setcookie("font", $font, time()+60*60*24, '/');//setting cookie 24 hours "/" - is to make cookie externally, not only in current folder
    else
        setcookie("font", $font, time()-60, '/');//deleting cookies
    //message with font data
    $return = array("font" => $_GET['font']);
}else{
    //error message
    $return = array("err"=> "Some problems with functionality, sorry");
    http_response_code(400);
}
//printing json version of $return
echo json_encode($return);

