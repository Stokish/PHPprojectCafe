<?php
      include $_SERVER['DOCUMENT_ROOT'] . '/classes/Action.php';
      include $_SERVER['DOCUMENT_ROOT'] . '/classes/ConnectDB.php';
      require_once $_SERVER['DOCUMENT_ROOT'] . '/configures/DB_config.php';
      session_start();
      header('Content-Type: application/json');

if( isset($_POST['action']) && isset($_SESSION['user_email']) && isset($_SESSION['user_pass']) ) {
    //trying to log out/delete
    try {
        //Action class for performing actions
        $act = new Action($_SESSION['user_email'], $_SESSION['user_pass'], $_POST['action']);
        $b = $act->DoAction($conn);//returns true if action performed successfully
        if($b == FALSE){
            //throwing exception if something got wrong
            throw  new Exception("Can't delete or log out");
        }else{
            //success message
            $return = array("mess"=> "success");
        }
    } catch (Exception $e){
        //returning  message from exception
       $return = array("err"=>$e->getMessage());
    }
}
//printing json version of $return
echo json_encode($return);