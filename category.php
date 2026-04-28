<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop Category page</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.php">Fashion Category</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="container mt-50 mb-50">
    <div class="row">
        
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Categories</div>
                <ul class="main-categories">
                    <?php
                    $main_cats = mysqli_query($conn, "SELECT DISTINCT category_name FROM categories");
                    while ($row = mysqli_fetch_assoc($main_cats)) {
                        $name = $row['category_name'];
                        $clean_id = str_replace(' ', '', $name); 
                    ?>
                    <li class="main-nav-list">
                        <a data-toggle="collapse" href="#<?php echo $clean_id; ?>" aria-expanded="false">
                            <span class="lnr lnr-arrow-right"></span><?php echo ucwords($name); ?>
                        </a>
                        <ul class="collapse" id="<?php echo $clean_id; ?>">
                            <?php
                            $subs = mysqli_query($conn, "SELECT * FROM categories WHERE category_name = '$name'");
                            while ($sub = mysqli_fetch_assoc($subs)) {
                            ?>
                            <li class="main-nav-list child">
                                <a href="javascript:void(0);" class="ajax-cat-filter" data-id="<?php echo $sub['id']; ?>">
                                    <?php echo $sub['sub_category']; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Product Filters</div>
                
                <div class="common-filter">
                    <div class="head">Brands</div>
                    <form action="#" id="brandFilterForm">
                        <ul>
                            <?php
                            $brand_query = "SELECT b.*, COUNT(p.id) as total_products FROM brands b LEFT JOIN products p ON b.id = p.brand_id GROUP BY b.id";
                            $brand_result = mysqli_query($conn, $brand_query);
                            while($brand = mysqli_fetch_assoc($brand_result)):
                            ?>
                            <li class="filter-list">
                                <input class="pixel-radio filter-check" type="radio" id="brand_<?php echo $brand['id']; ?>" name="brand" value="<?php echo $brand['id']; ?>">
                                <label for="brand_<?php echo $brand['id']; ?>"><?php echo $brand['brand_name']; ?> <span>(<?php echo $brand['total_products']; ?>)</span></label>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </form>
                </div>

                <div class="common-filter">
                    <div class="head">Color</div>
                    <form action="#" id="colorFilterForm">
                        <ul>
                            <?php
                            $color_query = "SELECT c.*, COUNT(p.id) as total_products FROM colors c LEFT JOIN products p ON c.id = p.colors_id GROUP BY c.id";
                            $color_result = mysqli_query($conn, $color_query);
                            while($color = mysqli_fetch_assoc($color_result)):
                            ?>
                            <li class="filter-list">
                                <input class="pixel-radio filter-check" type="radio" id="color_<?php echo $color['id']; ?>" name="color" value="<?php echo $color['id']; ?>">
                                <label for="color_<?php echo $color['id']; ?>"><?php echo $color['color_name']; ?> <span>(<?php echo $color['total_products']; ?>)</span></label>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </form>
                </div>

                <div class="common-filter">
                    <div class="head">Price</div>
                    <div class="price-range-area">
                        <div id="price-range"></div>
                        <div class="value-wrapper d-flex">
                            <div class="price">Price:</div>
                            <span>Rs</span><div id="lower-value"></div>
                            <div class="to">to</div>
                            <span>Rs</span><div id="upper-value"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <select><option value="1">Default sorting</option></select>
                </div>
                <div class="sorting mr-auto">
                    <select><option value="1">Show 10</option></select>
                </div>
                <div class="pagination">
                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
            
            <section class="lattest-product-area pb-40 category-list">
                <div class="row" id="update-product-area">
                    <?php 
                    $query = "SELECT * FROM products ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while ($product = mysqli_fetch_assoc($result)) { ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <img src="admin/php/uploads/<?php echo $product['images']; ?>" class="img-fluid" style="height:220px; width:100%; object-fit:cover;">
                                    <div class="product-details">
                                        <h6><?php echo $product['name']; ?></h6>
                                        <div class="price">
                                            <h6>₹<?php echo $product['price']; ?></h6>
                                            <h6 class="l-through">₹<?php echo ($product['price'] + 100); ?></h6>
                                        </div>
                                        <div class="prd-bottom">
                                            <a href="javascript:void(0);" class="social-info add-to-cart-btn" data-id="<?php echo $product['id']; ?>">
                                                <span class="ti-bag"></span><p class="hover-text">Add to Cart</p>
                                            </a>
                                            <a href="javascript:void(0);" class="social-info add-to-wishlist-btn" data-id="<?php echo $product['id']; ?>">
                                                <span class="lnr lnr-heart"></span><p class="hover-text">Wishlist</p>
                                            </a>
                                            <a href="single-product.php?id=<?php echo $product['id']; ?>" class="social-info">
                                                <span class="lnr lnr-move"></span><p class="hover-text">View More</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                    } else {
                        echo "<div class='col-12 text-center p-5'><h3>No products found!</h3></div>";
                    }
                    ?>
                </div>
            </section>

            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting mr-auto">
                    <select>
                        <option value="1">Show 5</option>
                    </select>
                </div>
                <div class="pagination" id="pagination-area">
                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                    <a href="#">6</a>
                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        </div> </div> 
        
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

<script>
$(document).ready(function() {
    
    // --- PRICE SLIDER LOGIC ---
    // Note: Slider initialization usually happens in main.js
    // This listener waits for user to stop dragging to trigger filter
    if (document.getElementById('price-range')) {
        var sliderElement = document.getElementById('price-range');
        if(sliderElement.noUiSlider){
            sliderElement.noUiSlider.on('change', function (values, handle) {
                applyFilters(1); 
            });
        }
    }

    // --- MAIN FILTER FUNCTION ---
    function applyFilters(pageNumber = 1) {
        // Collect all filter data
        var catId = $('.ajax-cat-filter.active-link').data('id') || "";
        var brand = $("input[name='brand']:checked").val() || "";
        var color = $("input[name='color']:checked").val() || "";
        
        // Price values
        var minPrice = "";
        var maxPrice = "";
        if($('#lower-value').length && $('#upper-value').length){
             minPrice = $('#lower-value').text().replace(/[^0-9.]/g, '');
             maxPrice = $('#upper-value').text().replace(/[^0-9.]/g, '');
        }

        // Show loading effect
        var productArea = $('#update-product-area');
        productArea.css('opacity', '0.5');

        // Send AJAX Request
        $.ajax({
            url: 'fetch_filtered_products.php',
            method: 'POST',
            data: { 
                cat_id: catId, 
                brand: brand, 
                color: color,
                min_price: minPrice, 
                max_price: maxPrice,
                page: pageNumber
            },
            success: function(response) {
                productArea.html(response);
                productArea.css('opacity', '1');
            },
            error: function() {
                productArea.css('opacity', '1');
                console.log('Filter failed');
            }
        });
    }

    // --- CLICK EVENTS ---

    // Add to Cart
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

    // Wishlist
    $('.add-to-wishlist-btn').click(function(e) {
        e.preventDefault();
        var productId = $(this).data('id');
        var button = $(this);
        if(!productId) { return; }

        $.ajax({
            url: 'admin/php/add_wishlist.php', 
            method: 'POST',
            data: { id: productId },
            success: function(response) {
                var msg = response.trim();
                if(msg == "Product added to wishlist successfully!") {
                    Swal.fire({ icon: 'success', title: 'Added!', text: 'Wishlist mein add ho gaya.', timer: 2000 });
                    button.find('span').css('color', '#ff0000'); 
                } else if(msg == "Product is already in your wishlist!") {
                    Swal.fire({ icon: 'info', title: 'Already Exist', text: 'Pehle se wishlist mein hai.' });
                } else {
                    Swal.fire({ icon: 'warning', title: 'Notice', text: msg });
                }
            }
        });
    });

    // Category Click (Highlights selected category)
    $('.ajax-cat-filter').click(function(e) {
        e.preventDefault();
        $('.ajax-cat-filter').removeClass('active-link').css('color', '');
        $(this).addClass('active-link').css('color', '#ffba00');
        applyFilters(1);
    });

    $(".filter-check").on("change", function() {
        applyFilters(1);
    });
});
</script>


<?php include 'footer.php'; ?>