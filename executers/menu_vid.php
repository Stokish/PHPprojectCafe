<?php

function food($food_name, $conn, $admin){
?>

                <h4 class="food"><?php echo  $food_name ?></h4>
                <?php
                $sql = "SELECT * FROM product INNER JOIN category ON product.category_id = category.category_id WHERE category.category_name LIKE ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $food_name);

                $stmt->execute();

                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="card" style="margin-top: 30px">
                                <img src="<?php echo $row['image'] ?>" alt="<?php echo $food_name ?>">
                                <div class="container">
                                    <p id="n<?php echo $row["product_id"]; ?>"><?php echo $row['product_name'] ?></p>
                                    <p>$ <span id="c<?php echo $row["product_id"]; ?>"><?php echo $row['cost'] ?></span></p>
                                </div>

                                <details>
                                    <summary>About<hr></summary>
                                    <p><?php echo $row['description'] ?></p>
                                </details>

                                <!-- SHOWING ADD TO CARD Button if logged in   -->
                                <?php if(isset($_SESSION['user_email']) && isset($_SESSION['user_pass'])){ ?>
                                    <form>
                                        <input type="number" id="q<?php echo $row["product_id"]; ?>" name="quantity"  class="form-control"  min="1" value="1">
                                        <input type="submit" id="f<?php echo $row["product_id"]; ?>" name="addCart"  class="addCart btn btn-info my-2" value="Add to Cart">
                                    </form>

                                <?php }

                                /* DELETE BUTTON IF ADMIN */
                                if(isset($admin) && $admin != null){
                                   echo "<p>&nbsp;</p> ";
                                    $admin->AdminDeleteForm($row['product_id']);
                                }
                                /* EDIT BUTTON IF ADMIN */
                                if(isset($admin) && $admin != null){
                                    ?><details> <summary>Edit product <hr></summary>

                                    <?php $admin->AdminEditForm($conn, $row['product_id']);?>

                                    </details><?php
                                }
                                ?>
                            </div>
                            <?php
                        }

                }

 ?>