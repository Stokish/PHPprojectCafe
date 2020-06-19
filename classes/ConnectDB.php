<?php
//Class for connecting to Database


class ConnectDB {
    //private attributes
private $db_host = " ";
private $db_name = " ";
private $db_user = " ";
private $db_pass = " ";

    //Constructor
    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }

    //Setting Connection to DataBase
    public function setConn(){
        $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (mysqli_connect_error()) {
            return null;
        } else
            return $conn;
    }

    //GETTERS & SETTERS
    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * @param string $db_host
     */
    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * @param string $db_name
     */
    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
    }

    /**
     * @return string
     */
    public function getDbUser()
    {
        return $this->db_user;
    }

    /**
     * @param string $db_user
     */
    public function setDbUser($db_user)
    {
        $this->db_user = $db_user;
    }

    /**
     * @return string
     */
    public function getDbPass()
    {
        return $this->db_pass;
    }

    /**
     * @param string $db_pass
     */
    public function setDbPass($db_pass)
    {
        $this->db_pass = $db_pass;
    }


}
