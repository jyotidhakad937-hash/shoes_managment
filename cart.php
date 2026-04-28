<?php 
// 1. Session start sabse upar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. DATABASE CONNECTION
include 'config.php'; 

// 3. Header include karein
include 'header.php'; 
?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="cart.php">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
    <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col">Action</th> </tr>
    </thead>
    <tbody>
        <?php
        $subtotal = 0;

        // Database Connection Check
        if (!$conn) {
            echo "<tr><td colspan='5' class='text-center text-danger'>Database Connection Error!</td></tr>";
        } 
        elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $quantity) {
                
                $safe_id = mysqli_real_escape_string($conn, $id);
                $query = "SELECT * FROM products WHERE id = '$safe_id'";
                $result = mysqli_query($conn, $query);

                if ($result && $row = mysqli_fetch_assoc($result)) {
                    $price = $row['price'];
                    $total_item_price = $price * $quantity;
                    $subtotal += $total_item_price;
        ?>
        <tr>
            <td>
                <div class="media">
                    <div class="d-flex">
                        <img src="admin/php/uploads/<?php echo $row['images']; ?>" alt="" style="width:100px;">
                    </div>
                    <div class="media-body">
                        <p><?php echo $row['name']; ?></p>
                    </div>
                </div>
            </td>
            <td><h5>₹<?php echo number_format($price, 2); ?></h5></td>
            <td>
                <div class="product_count">
                    <input type="text" name="qty" id="sst<?php echo $id; ?>" value="<?php echo $quantity; ?>" class="input-text qty" readonly>
                    <button onclick="var result = document.getElementById('sst<?php echo $id; ?>'); var sst = result.value; if(!isNaN(sst)) result.value++; return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                    <button onclick="var result = document.getElementById('sst<?php echo $id; ?>'); var sst = result.value; if(!isNaN(sst) && sst > 1) result.value--; return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                </div>
            </td>
            <td><h5>₹<?php echo number_format($total_item_price, 2); ?></h5></td>
            <td>
                <a href="admin/php/remove_cart.php?id=<?php echo $id; ?>" 
                   onclick="return confirm('Kya aap ise cart se hatana chahte hain?');" 
                   style="color: red; font-size: 20px;">
                    <i class="lnr lnr-trash"></i>
                </a>
            </td>
        </tr>
        <?php 
                }
            }
        ?>

       
        <tr>
            <td></td><td></td><td></td>
            <td><h5>Subtotal</h5></td>
            <td><h5>₹<?php echo number_format($subtotal, 2); ?></h5></td>
        </tr>

        <tr class="shipping_area">
            <td class="d-none d-md-table-cell"></td>
            <td class="d-none d-md-table-cell"></td>
            <td></td>
           
            <td>
                
            </td>
        </tr>

        <tr class="out_button_area">
            <td colspan="5"> <div class="checkout_btn_inner d-flex align-items-center justify-content-end">
                    <a class="gray_btn" href="index.php">Continue Shopping</a>
                    <a class="primary-btn" href="payment.php">Proceed to Payment</a>

                </div>
            </td>
        </tr>

        <?php 
        } else { 
            echo "<tr><td colspan='5' class='text-center'><h4 class='p-5'>Your cart is empty!</h4><a href='index.php' class='primary-btn'>Shop Now</a></td></tr>";
        } 
        ?>
    </tbody>
</table>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>