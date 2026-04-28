<?php include 'config.php';?>
<?php include 'header.php';?>

	<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
					<div class="active-banner-slider owl-carousel">
						<div class="row single-slide align-items-center d-flex">
							<div class="col-lg-5 col-md-6">
								<div class="banner-content">
									<h1>Nike New <br>Collection!</h1>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
									<div class="add-bag d-flex align-items-center">
										<a class="add-btn" href=""><span class="lnr lnr-cross"></span></a>
										<span class="add-text text-uppercase">Add to Bag</span>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="banner-img">
									<img class="img-fluid" src="img/banner/banner-img.png" alt="">
								</div>
							</div>
                            
						</div>
					
						<div class="row single-slide">
							<div class="col-lg-5">
								<div class="banner-content">
									<h1>Nike New <br>Collection!</h1>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
									<div class="add-bag d-flex align-items-center">
										<a class="add-btn" href=""><span class="lnr lnr-cross"></span></a>
										<span class="add-text text-uppercase">Add to Bag</span>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="banner-img">
									<img class="img-fluid" src="img/banner/banner-img.png" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="features-area section_gap">
		<div class="container">
			<div class="row features-inner">
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="img/features/f-icon1.png" alt="">
						</div>
						<h6>Free Delivery</h6>
						<p>Free Shipping on all order</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="img/features/f-icon2.png" alt="">
						</div>
						<h6>Return Policy</h6>
						<p>Free Shipping on all order</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="img/features/f-icon3.png" alt="">
						</div>
						<h6>24/7 Support</h6>
						<p>Free Shipping on all order</p>
					</div>
				</div>
				<!-- single features -->
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-features">
						<div class="f-icon">
							<img src="img/features/f-icon4.png" alt="">
						</div>
						<h6>Secure Payment</h6>
						<p>Free Shipping on all order</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="lattest-product-area pb-40 category-list">
    <div class="container">
        <div class="row" id="update-product-area">
            <?php
            $query = "SELECT * FROM products";

            if (isset($_GET['cat_id'])) {
                $cat_id = intval($_GET['cat_id']);
                $query .= " WHERE category_id = $cat_id"; 
            }

            $result = mysqli_query($conn, $query . " ORDER BY id DESC LIMIT 8");

            if(mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) { 
            ?>
                <div class="col-lg-3 col-md-6"> <div class="single-product">
                        <img src="admin/php/uploads/<?php echo $product['images']; ?>" 
                             class="img-fluid" 
                             style="height:220px; width:100%; object-fit:cover;" 
                             alt="<?php echo $product['name']; ?>">
                        
                        <div class="product-details">
                            <h6><?php echo $product['name']; ?></h6>
                            <div class="price">
                                <h6>₹<?php echo $product['price']; ?></h6>
                                <h6 class="l-through">₹<?php echo ($product['price'] + 100); ?></h6>
                            </div>
                            
                            <div class="prd-bottom">
                                <a href="javascript:void(0);" class="social-info add-to-cart-btn" data-id="<?php echo $product['id']; ?>">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Add to Cart</p>
                                </a>

                                <a href="javascript:void(0);" class="social-info add-to-wishlist-btn" data-id="<?php echo $product['id']; ?>">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
                                </a>

                                <a href="single-product.php?id=<?php echo $product['id']; ?>" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">View More</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "<div class='col-12 text-center p-5'><h3>No products found!</h3></div>";
            }
            ?>
        </div>
    </div>
</section>

	<section class="exclusive-deal-area">
		<div class="container-fluid">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-6 no-padding exclusive-left">
					<div class="row clock_sec clockdiv" id="clockdiv">
						<div class="col-lg-12">
							<h1>Exclusive Hot Deal Ends Soon!</h1>
							<p>Who are in extremely love with eco friendly system.</p>
						</div>
						<div class="col-lg-12">
							<div class="row clock-wrap">
								<div class="col clockinner1 clockinner">
									<h1 class="days">150</h1>
									<span class="smalltext">Days</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="hours">23</h1>
									<span class="smalltext">Hours</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="minutes">47</h1>
									<span class="smalltext">Mins</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="seconds">59</h1>
									<span class="smalltext">Secs</span>
								</div>
							</div>
						</div>
					</div>
					<a href="category.php" class="primary-btn">Shop Now</a>
				</div>
				<div class="col-lg-6 no-padding exclusive-right">
    
</div>		
</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	

	<section class="brand-area section_gap">
		<div class="container">
			<div class="row">
				<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="img/brand/1.png" alt="">
				</a>
				<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="img/brand/2.png" alt="">
				</a>
				<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="img/brand/3.png" alt="">
				</a>
				<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="img/brand/4.png" alt="">
				</a>
				<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="img/brand/5.png" alt="">
				</a>
			</div>
		</div>
	</section>
 <section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Deals of the Week</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    $deals_query = mysqli_query($conn, "SELECT * FROM products ORDER BY RAND() LIMIT 9");
                    while($deal = mysqli_fetch_assoc($deals_query)) {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="single-product.php?id=<?php echo $deal['id']; ?>">
                                <img src="admin/php/uploads/<?php echo $deal['images']; ?>" alt="" style="width:70px; height:70px; object-fit:cover;">
                            </a>
                            <div class="desc">
                                <a href="single-product.php?id=<?php echo $deal['id']; ?>" class="title"><?php echo $deal['name']; ?></a>
                                <div class="price">
                                    <h6>₹<?php echo $deal['price']; ?></h6>
                                    <h6 class="l-through">₹<?php echo $deal['price'] + 200; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="img/category/c5.jpg" alt="">
                    </a>
                </div>
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
<script>
$(document).ready(function() {
    $('.add-to-wishlist-btn').click(function(e) {
        e.preventDefault();
        
        var productId = $(this).data('id');
        var button = $(this);

                

        if(!productId) {
            alert("Error: Product ID not found on button!");
            return;
        }

        $.ajax({
            url: 'admin/php/add_wishlist.php', 
            method: 'POST',
            data: { id: productId },
            success: function(response) {
                                var msg = response.trim();
                
                if(msg == "Product added to wishlist successfully!") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: 'Product aapki wishlist mein add ho gaya hai.',
                        showConfirmButton: true,
                        timer: 2000
                    });
                    button.find('span').css('color', '#ff0000');                 } 
                else if(msg == "Product is already in your wishlist!") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Exist',
                        text: 'Yeh product pehle se wishlist mein hai.',
                    });
                }
                else {
                                      Swal.fire({
                        icon: 'warning',
                        title: 'Notice',
                        text: msg, 
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                Swal.fire({
                    icon: 'error',
                          title: 'Oops...',
                    text: 'Server se connect nahi ho paaye!',
                });
            }
        });
    });
});
</script>
	<?php include 'footer.php';?>



	
