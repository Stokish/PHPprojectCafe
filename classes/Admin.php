<?php //Admin class for forms and actions for admins
class Admin extends VHOD{

    //Constructor
    public function __construct($user_email, $user_pass)
    {
        parent::__construct($user_email, $user_pass);
    }

    //Add New Food to DataBase Form
    public function AdminAddForm($conn){
        ?>
        <details open class="my-4" style=" text-align: center; background-color: #5bc0de; margin: auto;">

        <summary style="color: azure">Add product</summary>

            <div class="card" style="margin:auto">
            <form class="container" style="margin:auto; " method='post'>

            <label for='product_name'>Product Name:</label>
            <br clear="all">
            <input name='product_name' id='product_name' placeholder='Article product_name'>

            <p>&nbsp;</p>

            <label for='category_id'>Category</label>
            <br clear="all">
            <?php
            $sql = "SELECT * FROM category";
            $stmt = $conn->prepare($sql);
            $bool = $stmt->execute();
            if ($bool != FALSE) {
            $result = $stmt->get_result();
                echo "<select name='category_id'>";
                while($row = $result->fetch_assoc()) {
                    echo "<option  value='" .$row["category_id"]. "'>" . $row["category_name"] . "</option>";
                }}
            echo "</select>";
            ?>


            <p>&nbsp;</p>

            <div>
                <label for='cost'>Cost:</label>
                <br clear="all">
                <input type='number' step="any" name='cost'>
            </div>

            <div>
                <label for='image'>Write path to the image</label>
                <br clear="all">
                <textarea type='text'  name='image' required></textarea>
            </div>

            <div>
                <label for='description'>Write description</label>
                <br clear="all">
                <textarea type='text' rows='4' name='description' required></textarea>
            </div>

            <input type="hidden" name="admin_add">
            <button class="btn btn-info" >Add</button>
            </form>
            </div>

        </details><?php
    }



    //Deleting  food from DataBase form
        public function AdminDeleteForm($product_id){
     ?>
        <form method="post"">
        <input type="hidden" name="delete_product_id" value="<?php echo $product_id; ?>">
        <input type="submit" name="admin_delete" style="margin-top: 5px;" class="btn btn-danger" value="Delete">
        </form>
    <?php
        }



    //Performs Action to Add a product
    public function AdminAddProduct($conn)
    {
        if ($this->check($conn) == TRUE) {
            //Inserting values from AdminAddForm to database
                $sql = "INSERT INTO product (product_id, category_id, product_name, cost, image, description) VALUES (DEFAULT, ?, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isdss",$_POST['category_id'], $_POST['product_name'], $_POST['cost'], $_POST['image'], $_POST['description']);
                $execute_bool = $stmt->execute();
                //Showing an error if execution problems have appeared
                if ($execute_bool == false){
                    echo "<div><p>" . $stmt->error . "</div>";
                } else {
                    //returning success message if statement was executed successfully
                    print "<div style='margin: auto; text-align: center' >
                                <a class='btn' href='Menu.php'>You have successfully added a product!</a>
                           </div>";
                }
        }
    }

    //Performs Action to Delete a product
    public function AdminDeleteProduct($conn, $product_id)
    {
        if ($this->check($conn) == TRUE) {
            //Deleting value received from AdminDeleteForm
            $sql = "DELETE FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i",$product_id);
            $execute_bool = $stmt->execute();
            //returning success message if statement was executed successfully
            if ($execute_bool == TRUE) {
                print "<div style=' text-align: center' >
                    <a class='btn' style='color: black' href='Menu.php'>You have successfully deleted a product!</a>
                </div>";
            } else {
                //Showing an error if execution problems have appeared
                echo "<div><p>" . $stmt->error . "</div>";
            }
        }
    }


    //Edit Food in DataBase Form
    public function AdminEditForm($conn, $edit_id){?>

        <form method='post' style="width: 100%; margin-left: 3%">
            <input name='edit_product_id' type="hidden" value="<?php echo $edit_id?>">
        <label for='product_name'>Product Name:</label>
        <br clear="all">
        <input name='product_name' id='product_name' placeholder='Article product' required>

            <br clear="all">

        <label for='category_id'>Category</label>
        <br clear="all">
        <?php
        //Showing options for categories
        $sql = "SELECT * FROM category";
        $stmt = $conn->prepare($sql);
        $bool = $stmt->execute();
        if ($bool != FALSE) {
            $result = $stmt->get_result();
            echo "<select name='category_id' required>";
            while($row = $result->fetch_assoc()) {
                echo "<option  value='" .$row["category_id"]. "' >" . $row["category_name"] . "</option>";
            }}
        echo "</select>";
        ?>
            <br clear="all">

            <label for='cost'>Cost:</label>
            <br clear="all">
            <input type='number' step="any" name='cost' required>


            <br clear="all">

            <label for='image'>Write path to the image</label>
            <br clear="all">
            <textarea type='text' name='image' required></textarea>

            <br clear="all">

            <label for='description'>Write description</label>
            <br clear="all">
            <textarea type='text' rows='4' name='description' required></textarea>

            <br clear="all">

        <input type="hidden" name="admin_edit">

        <button class="btn btn-info" style="margin-top: 5px; " >EDIT</button>
        </form>

        <?php
    }

    //Performs Action to Edit a product
    public function AdminEditProduct($conn, $product_id)
    {
        if ($this->check($conn) == TRUE) {
            //finding product id and inserting new values
            $sql = "UPDATE product SET category_id = ?, product_name = ?, cost = ?, image = ?, description = ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("isdssi",$_POST['category_id'], $_POST['product_name'], $_POST['cost'], $_POST['image'], $_POST['description'], $product_id);

            //returning success message if statement was executed successfully
            if ($stmt->execute()== TRUE) {
                print "<div style='text-align: center' >
                    <a class='btn' href='Menu.php'>You have successfully edited a product!</a>
                </div>";
            } else {
                //Showing an error if execution problems have appeared
                echo "<div><p>" . $stmt->error . "</div>";
            }
        }
    }

    //OVERRIDE METHOD FROM VHOD
    public function showInfo($conn)
    {
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
                    <p style='text-align: center; color: red; font-size: xx-large; font-weight: bolder;'> ADMIN </p>
                    <p style='text-align: center'> Name: ".$row['user_name']."</p>
                    <p style='text-align: center'> Email: <a href='mailto:".$row['user_email']."' > ".$row['user_email']." </a></p>
                    <p style='text-align: center'> Address: ".$row['user_address'] ."</p>
                    </div>";
        }
    }

}