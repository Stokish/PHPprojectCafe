<?php include $_SERVER['DOCUMENT_ROOT'] . '/classes/Action.php';
      include $_SERVER['DOCUMENT_ROOT'] . '/classes/ConnectDB.php';
      require_once $_SERVER['DOCUMENT_ROOT'] . '/configures/DB_config.php';
session_start();
header('Content-Type: application/json');
if( isset($_POST['action']) && isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) ) {
    try {
        $act = new Action($_SESSION['user_email'], $_SESSION['user_pass'], $_POST['action']);
        $b = $act->DoAction($conn);
        if($b == FALSE){
            throw  new Exception("Can't delete and/or log out");
        }
    } catch (Exception $e){
        echo "<!DOCTYPE html>
                <html lang='en' dir='ltr'>
                <head><script> alert('".$e->getMessage()."')</script></head></html>";
    }
}
header("Location: Menu.php");
exit();