<?php 
include 'config.php'; 


$id = isset($_GET['id']) ? $_GET['id'] : (isset($_GET['pid']) ? $_GET['pid'] : null);

$product = null;

if($id) {
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    if(mysqli_num_rows($query) > 0) {
        $product = mysqli_fetch_assoc($query);
    }
}
if($id) {
  
    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = '$id'";
            
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0) {
        $product = mysqli_fetch_assoc($query);
    }
}


if(!$product) {
    header("Location: index.php");
    exit();
}

include 'header.php'; 
?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1><?php echo $product['name']; ?></h1> 
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Details</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="single_product_img_box" style="text-align:center; border: 1px solid #f2f2f2; padding: 10px;">
                    <img src="admin/php/uploads/<?php echo $product['images']; ?>" 
                         class="img-fluid" 
                         style="max-height:500px; width:auto; object-fit:contain;" 
                         alt="<?php echo $product['name']; ?>">
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo $product['name']; ?></h3> 
                    <h2>$<?php echo number_format($product['price'], 2); ?></h2>
                    <ul class="list">
                        <li>
                            <a class="active" href="category.php?cat_id=<?php echo $product['category_id']; ?>">
                                <span>Category</span> : <?php echo htmlspecialchars($product['category_name']); ?>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Availability</span> : 
                                <?php 
                                    $current_stock = $product['stock_quantity'] ?? 0; 
                                    echo ($current_stock > 0) ? 'In Stock' : 'Out of Stock'; 
                                ?>
                            </a>
                        </li>
                    </ul>
                    <p style="margin-top:20px;">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </p>
                    <div class="card_area d-flex align-items-center" style="margin-top:30px;">
                        <a class="primary-btn" href="cart.php?pid=<?php echo $product['id']; ?>">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab">Specification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab">Comments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab">Reviews</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel">
                <p>Beryl Cook is one of Britain’s most talented...</p>
                <p>It is often frustrating to attempt to plan meals...</p>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr><td><h5>Width</h5></td><td><h5>128mm</h5></td></tr>
                            <tr><td><h5>Height</h5></td><td><h5>508mm</h5></td></tr>
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel">
                <div class="row" style="padding-top: 30px;"> 
                    <div class="col-lg-6">
                        <div class="comment_list" id="commentList" style="max-height: 500px; overflow-y: auto;">
                            <?php
                            $pid = intval($_GET['id']);
                            $res = mysqli_query($conn, "SELECT * FROM comments WHERE product_id = $pid AND status = 1 ORDER BY id DESC");
                            if(mysqli_num_rows($res) > 0) {
                                while($row = mysqli_fetch_assoc($res)) {
                                    $date = date("jS M, Y", strtotime($row['created_at']));
                                    ?>
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                                <h5><?php echo $date; ?></h5>
                                            </div>
                                        </div>
                                        <p><?php echo htmlspecialchars($row['message']); ?></p>
                                    </div>
                                    <?php
                                }
                            } else { echo "<p>No comments yet.</p>"; }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Post a comment</h4>
                            <form class="row contact_form" id="commentForm">
                                <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="message" placeholder="Message" rows="3" required></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show active" id="review" role="tabpanel">
                <div class="row" style="padding-top: 30px;">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Overall</h5>
                                    <?php
                                    $res_avg = mysqli_query($conn, "SELECT AVG(rating) as avg, COUNT(id) as total FROM reviews WHERE product_id = $pid");
                                    $stat = mysqli_fetch_assoc($res_avg);
                                    ?>
                                    <h4><?php echo round($stat['avg'], 1) ?: "0"; ?></h4>
                                    <h6>(<?php echo $stat['total']; ?> Reviews)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="review_list" id="dynamicReviewList">
                            <?php
                            $reviews = mysqli_query($conn, "SELECT * FROM reviews WHERE product_id = $pid ORDER BY id DESC");
                            while($rev = mysqli_fetch_assoc($reviews)): ?>
                            <div class="review_item">
                                <h4><?php echo htmlspecialchars($rev['name']); ?></h4>
                                <div class="stars" style="color:#fbd600;">
                                    <?php for($j=1; $j<=5; $j++) echo ($j <= $rev['rating']) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>'; ?>
                                </div>
                                <p><?php echo htmlspecialchars($rev['message']); ?></p>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Add Review</h4>
                            <p>Your Rating:</p>
                            <ul class="list" id="starRating" style="cursor:pointer; display:flex; list-style:none; padding:0; color:#fbd600; font-size:20px;">
                                <li data-val="1"><i class="fa fa-star"></i></li>
                                <li data-val="2"><i class="fa fa-star"></i></li>
                                <li data-val="3"><i class="fa fa-star"></i></li>
                                <li data-val="4"><i class="fa fa-star"></i></li>
                                <li data-val="5"><i class="fa fa-star"></i></li>
                            </ul>
                            <form class="row contact_form" id="ajaxReviewForm">
                                <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                                <input type="hidden" name="rating" id="selectedRating" value="5">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Review" required></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> </div> </section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="section-title">
						<h1>Deals of the Week</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore
							magna aliqua.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r1.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r2.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r3.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r5.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r6.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r7.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r9.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r10.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6">
							<div class="single-related-product d-flex">
								<a href="#"><img src="img/r11.jpg" alt=""></a>
								<div class="desc">
									<a href="#" class="title">Black lace Heels</a>
									<div class="price">
										<h6>$189.00</h6>
										<h6 class="l-through">$210.00</h6>
									</div>
								</div>
							</div>
						</div>
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
$("#commentForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "php/comment-save.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            $("#commentList").prepend(res);
            $("#commentForm")[0].reset();
            
            // SweetAlert Success Message
            Swal.fire({
                icon: 'success',
                title: 'Comment Posted!',
                text: 'Aapka comment successfully add ho gaya hai.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    // Star Rating Click logic
    $('#starRating li').click(function(){
        let val = $(this).data('val');
        $('#selectedRating').val(val); // Hidden input update
        $('#starRating li i').removeClass('fa-star').addClass('fa-star-o');
        $('#starRating li').each(function(i){
            if(i < val) $(this).find('i').removeClass('fa-star-o').addClass('fa-star');
        });
    });

    // AJAX Form Submit
    $('#ajaxReviewForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'php/review.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res){
                $('#dynamicReviewList').prepend(res);
                $('#ajaxReviewForm')[0].reset();
                Swal.fire({ icon: 'success', title: 'Review Saved!', timer: 2000, showConfirmButton: false });
            }
        });
    });
});
</script>
<?php include 'footer.php'; ?>