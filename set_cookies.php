<?php
header('Content-Type: application/json');
if(isset($_POST['font'])){
    $font =$_POST['font'];
    setcookie('font', $font, time()+60*60*24);//24 hours
    $return = array(
        "font"=> $_POST['font']);
}else{
    $return = array(
        "err"=> "Some problems with functionality, sorry");
    http_response_code(400);
}
echo json_encode($return);