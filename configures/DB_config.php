<?php
define('db_host', "localhost");
define('db_user', "root");
define('db_password', "123456");
define('db_name', "shop");
try{
$Conn = new ConnectDB(db_host, db_user, db_password, db_name);
$conn = $Conn->setConn();
if($conn == null)
    throw new Exception('DB connection problems! Error 404');
}catch (Exception $e){
    echo "<script>alert('".$e->getMessage()."');</script>
            <h1>".$e->getMessage()."</h1>";
}