<?php //Class to display food for Menu page


class Food
{
    private $admin = null;
    private $user = null;

    //Food constructor
    /**
     * @param Admin $admin
     * @param VHOD $user
     */
    public function __construct($admin, $user)
    {
        $this->admin = $admin;
        $this->user = $user;
    }
     //GETTERS
    /**
     * @return Admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return VHOD
     */
    public function getUser()
    {
        return $this->user;
    }


    //SETTERS
    /**
     * @param Admin $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @param VHOD $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    //Function to display food cart
     public  function food($food_name, $conn){
        ?>
                        <h4 class="food"><?php echo  $food_name ?></h4>
                        <?php
                        //Searching for a food in Database
                        $sql = "SELECT * FROM product INNER JOIN category ON product.category_id = category.category_id WHERE category.category_name LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $food_name);

                        $stmt->execute();

                        $result = $stmt->get_result();
                        //displaying all rows
                        while ($row = $result->fetch_assoc()) {
                            ?>
                                    <div class="card" style="margin-top: 30px">
                                        <!-- Image -->
                                        <img src="<?php echo $row['image'] ?>" alt="<?php echo $food_name ?>">
                                        <!-- Name & Cost -->
                                        <div class="container">
                                            <p id="n<?php echo $row["product_id"]; ?>"><?php echo $row['product_name'] ?></p>
                                            <p>$ <span id="c<?php echo $row["product_id"]; ?>"><?php echo $row['cost'] ?></span></p>
                                        </div>

                                        <!-- Description of food -->
                                        <details>
                                            <summary>About<hr></summary>
                                            <p><?php echo $row['description'] ?></p>
                                        </details>

                                        <!-- SHOWING ADD TO CARD Button if logged in   -->
                                        <?php if($this->user != null || $this->admin != null){ ?>
                                            <form>
                                                <input type="number" id="q<?php echo $row["product_id"]; ?>" name="quantity"  class="form-control"  min="1" value="1">
                                                <input type="submit" id="f<?php echo $row["product_id"]; ?>" name="addCart"  class="addCart btn btn-info my-2" value="Add to Cart">
                                            </form>

                                        <?php }

                                        /* 'DELETE' BUTTON IF ADMIN */
                                        if( $this->admin != null){
                                           echo "<p>&nbsp;</p> ";
                                            $this->admin->AdminDeleteForm($row['product_id']);
                                        }
                                        /* 'EDIT' BUTTON IF ADMIN */
                                        if( $this->admin != null){
                                            ?><details> <summary>Edit product <hr></summary>

                                            <?php $this->admin->AdminEditForm($conn, $row['product_id']);?>

                                            </details><?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }

                        }
        }
        ?>






