<?php include 'VHOD.php';

class Action extends VHOD
{
    private $action = ' ';
    public function __construct($user_email, $user_pass,$action)
    {
        parent::__construct($user_email, $user_pass);
        $this->action = $action;
    }

    public function DoAction($conn) {
        if($this->action == "logout") {
            echo "<script> alert('Logged out Succesfully')</script>";
            session_destroy();
            return TRUE;
        }
        elseif($this->action == "delete") {
            $user_id = parent::getID($conn);
            $sql_delete_orders= "DELETE FROM orders 
            WHERE orders.order_id  IN ( 
            SELECT orders_users.order_id FROM orders_users INNER JOIN users ON orders_users.user_id = users.user_id WHERE users.user_id = ?)";
            $stmt1 = $conn->prepare($sql_delete_orders);
            $stmt1->bind_param("i", $user_id);
            $stmt1->execute();

            $sql_delete_user = "DELETE FROM users WHERE user_id = ? ";
            $stmt2 = $conn->prepare($sql_delete_user);
            $stmt2->bind_param("i", $user_id);

            $result = $stmt2->execute();
            if ($result == TRUE) {
                echo "<script> alert('Deleted Succesfully')</script>";
                session_destroy();
                return  TRUE;
            }
            return FALSE;

        }
    }

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