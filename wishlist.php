<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php'); 
include('header.php'); 
?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Wishlist</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="wishlist.php">Wishlist</a>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
<tbody>
    <?php
    if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
        foreach ($_SESSION['wishlist'] as $id) {
            $product_id = mysqli_real_escape_string($conn, $id);
            $query = "SELECT * FROM products WHERE id = '$product_id'";
            $result = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td>
            <div class="media">
                <div class="d-flex">
                    <img src="admin/php/uploads/<?php echo $row['images']; ?>" alt="" style="width:100px; height:auto; object-fit:cover;">
                </div>
                <div class="media-body">
                    <p><?php echo htmlspecialchars($row['name']); ?></p>
                </div>
            </div>
        </td>
        <td style="vertical-align: middle;">
            <h5>₹<?php echo number_format($row['price'], 2); ?></h5>
        </td>
        <td style="vertical-align: middle;">
            <div class="action-container" style="display: flex; align-items: center; gap: 15px;">
               <a href="javascript:void(0);" 
   class="primary-btn add-to-cart-btn" 
   data-id="<?php echo $row['id']; ?>" 
   style="line-height: 35px; padding: 0 20px; border-radius: 5px; text-transform: uppercase; font-size: 12px; display: inline-block; background-color: #ff7e00; color: white; text-decoration: none;">
    Add to Cart
</a>
                <br>
                <a href="admin/php/remove_wishlist.php?id=<?php echo $row['id']; ?>" title="Remove from Wishlist" style="color: #ff0000; font-size: 18px; text-decoration: none;">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </td>
    </tr>
    <?php
            } 
        } 
    } else {
        echo "<tr><td colspan='3' class='text-center'><h4 class='p-5'>Your wishlist is empty!</h4></td></tr>";
    }
    ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        

        var productId = $(this).data('id');

        $.ajax({
            url: 'admin/php/add_cart.php',
            method: 'POST',
            data: { product_id: productId },
            success: function(response) {
                if(response.trim() == "success") {
                    Swal.fire({
                        title: 'Done',
                        text: 'Product cart mein add ho gaya!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: true
                    });
                }
            }
        });
    });
});
</script>

<?php include('footer.php'); ?>