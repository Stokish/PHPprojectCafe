<?php include 'VHOD.php';

class Action extends VHOD
{
    private $action = ' ';
    //Constructor
    public function __construct($user_email, $user_pass, $action)
    {
        parent::__construct($user_email, $user_pass);
        $this->action = $action;
    }

    //LOGGING OUT OR DELETING ACCOUNT
    public function DoAction($conn) {
        //destroying action on logout
        if($this->action == "logout") {
            session_destroy();
            return TRUE;
        }
        elseif($this->action == "delete") {
            //deleting order performed by an account from DataBase
            $user_id = parent::getID($conn);
            $sql_delete_orders= "DELETE FROM orders 
            WHERE orders.order_id  IN ( 
            SELECT orders_users.order_id FROM orders_users INNER JOIN users ON orders_users.user_id = users.user_id WHERE users.user_id = ?)";
            $stmt1 = $conn->prepare($sql_delete_orders);
            $stmt1->bind_param("i", $user_id);
            $stmt1->execute();

            //Deleting an account itself
            $sql_delete_user = "DELETE FROM users WHERE user_id = ? ";
            $stmt2 = $conn->prepare($sql_delete_user);
            $stmt2->bind_param("i", $user_id);
            $result = $stmt2->execute();

            if ($result == TRUE) {
                session_destroy();
                return  TRUE;
            }
            return FALSE;

        }
    }

    //GETTERS & SETTERS

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


}