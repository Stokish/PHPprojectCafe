<?php //main Class


class VHOD
{
    private $user_email = " ";
    private $user_pass = " ";

    //constructor
    public function __construct($user_email, $user_pass)
    {
        $this->user_email = $user_email;
        $this->user_pass = $user_pass;
    }

    //check function searches for an account in DataBase
    public function check($conn){
        $query_check = "SELECT * FROM users WHERE user_email LIKE ? AND user_pass LIKE ?";
        $stmt = $conn->prepare($query_check);
        $stmt->bind_param("ss",$this->user_email, $this->user_pass);

        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row != null){
           return TRUE;
        }else{
            return FALSE;
        }
    }

    //gets Id of a user from database
    public function getID($conn)
    {
            $query_id = "SELECT user_id FROM users WHERE user_email LIKE ? AND user_pass LIKE ?";
            $statement = $conn->prepare($query_id);
            $statement->bind_param("ss",$this->user_email, $this->user_pass);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();

            if ($row['user_id'] != null){
                return $row['user_id'];
            }
            return null;
    }

    //gets type of a user from database
    public function getTypeID($conn)
    {
        if ($this->check($conn) == TRUE) {
            $query_type = "SELECT user_type_id FROM users WHERE user_email LIKE ? AND user_pass LIKE ?";
            $stmt = $conn->prepare($query_type);
            $stmt->bind_param("ss",$this->user_email, $this->user_pass);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row['user_type_id'] != null){
                return $row['user_type_id'];
            }
        }
    }


    //THIS METHOD IS ALSO OVERRIDED IN CLASS ADMIN
    public function showInfo($conn){
            //getting user id
             $user = $this->getID($conn);
            $user_info = "SELECT * FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($user_info);
            $stmt->bind_param("s",$user);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row != null){
                    print "<div style='justify-content: center; font-weight: bold;'>
                    <p style='text-align: center'> Name: ".$row['user_name']."</p>
                    <p style='text-align: center'> Email: <a href='mailto:".$row['user_email']."' > ".$row['user_email']." </a></p>
                    <p style='text-align: center'> Address: ".$row['user_address'] ."</p>
                    </div>";
                }
    }

    //GETTERS & SETTERS
    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * @param string $user_email
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * @return string
     */
    public function getUserPass()
    {
        return $this->user_pass;
    }

    /**
     * @param string $user_pass
     */
    public function setUserPass($user_pass)
    {
        $this->user_pass = $user_pass;
    }



}