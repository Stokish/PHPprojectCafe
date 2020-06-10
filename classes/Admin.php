<?php
class Admin extends VHOD{

    public function __construct($user_email, $user_pass)
    {
        parent::__construct($user_email, $user_pass);
    }

    public function AdminAddForm($conn){
        ?>
        <details open style=" text-align: center; background-color: #5bc0de; margin: auto;">

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




    public function AdminDeleteForm($product_id){
 ?>
    <form method="post"">
    <input type="hidden" name="delete_product_id" value="<?php echo $product_id; ?>">
    <input type="submit" name="admin_delete" style="margin-top: 5px;" class="btn btn-danger" value="Delete">
    </form>
<?php
    }




    public function AdminAddProduct($conn)
    {
        if ($this->check($conn) == TRUE) {


                $sql = "INSERT INTO product (category_id, product_name, cost, image, description) VALUES (?, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isdss",$_POST['category_id'], $_POST['product_name'], $_POST['cost'], $_POST['image'], $_POST['description']);
                $execute_bool = $stmt->execute();
                if ($execute_bool == false){
                    echo "<div><p>" . $stmt->error . "</div>";
                } else {
                    $id = $stmt->insert_id;
                    print "<div style='margin: auto; text-align: center' >
                                <a class='btn' href='Menu.php'>You have successfully added a product!</a>
                           </div>";
                }
        }
    }

    public function AdminDeleteProduct($conn, $product_id)
    {
        if ($this->check($conn) == TRUE) {
            $sql = "DELETE FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i",$product_id);
            $execute_bool = $stmt->execute();
            if ($execute_bool == TRUE) {
                print "<div style=' text-align: center' >
                    <a class='btn' style='color: black' href='Menu.php'>You have successfully deleted a product!</a>
                </div>";

            } else {
                echo "Error: " . $conn->error;

            }
        }
    }



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

    public function AdminEditProduct($conn, $product_id)
    {
        if ($this->check($conn) == TRUE) {
            $sql = "UPDATE product SET category_id = ?, product_name = ?, cost = ?, image = ?, description = ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("isdssi",$_POST['category_id'], $_POST['product_name'], $_POST['cost'], $_POST['image'], $_POST['description'], $product_id);


            if ($stmt->execute()== TRUE) {
                print "<div style='text-align: center' >
                    <a class='btn' href='Menu.php'>You have successfully edited a product!</a>
                </div>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }

    public function showInfo($conn)
    {
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
                    <p style='text-align: center'> Phone: ".$row['user_phone']."</p>
                    <p style='text-align: center'> Email: <a href='mailto:".$row['user_email']."' > ".$row['user_email']." </a></p>
                    <p style='text-align: center'> Address: ".$row['user_address'] ."</p>
                    </div>";
        }
    }

}