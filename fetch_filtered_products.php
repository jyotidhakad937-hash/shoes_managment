<?php
include 'config.php';

// 1. Pagination Variables (Limit 5 Products per page)
$limit = 5; 
$page = isset($_POST['page']) && $_POST['page'] > 0 ? intval($_POST['page']) : 1;
$offset = ($page - 1) * $limit;

// 2. Filters Apply Karein
$whereClauses = [];
if (!empty($_POST['cat_id'])) {
    $whereClauses[] = "category_id = " . intval($_POST['cat_id']);
}
if (!empty($_POST['brand'])) {
    $whereClauses[] = "brand_id = " . intval($_POST['brand']);
}
if (!empty($_POST['color'])) {
    $whereClauses[] = "colors_id = " . intval($_POST['color']);
}
if (!empty($_POST['min_price']) && !empty($_POST['max_price'])) {
    $min = floatval($_POST['min_price']);
    $max = floatval($_POST['max_price']);
    $whereClauses[] = "price BETWEEN $min AND $max";
}

$where = !empty($whereClauses) ? " WHERE " . implode(" AND ", $whereClauses) : "";

// 3. Total Count for Pagination
$count_query = "SELECT COUNT(*) as total FROM products $where";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

// 4. Fetch Products
$query = "SELECT * FROM products $where ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        $output .= '
        <div class="col-lg-4 col-md-6">
            <div class="single-product">
                <img src="admin/php/uploads/'.$product['images'].'" class="img-fluid" style="height:220px; width:100%; object-fit:cover;">
                <div class="product-details">
                    <h6>'.$product['name'].'</h6>
                    <div class="price">
                        <h6>₹'.$product['price'].'</h6>
                        <h6 class="l-through">₹'.($product['price'] + 100).'</h6>
                    </div>
                    <div class="prd-bottom">
                        <a href="javascript:void(0);" class="social-info add-to-cart-btn" data-id="'.$product['id'].'">
                            <span class="ti-bag"></span><p class="hover-text">Add to Cart</p>
                        </a>
                        <a href="javascript:void(0);" class="social-info add-to-wishlist-btn" data-id="'.$product['id'].'">
                            <span class="lnr lnr-heart"></span><p class="hover-text">Wishlist</p>
                        </a>
                        <a href="single-product.php?id='.$product['id'].'" class="social-info">
                             <span class="lnr lnr-move"></span><p class="hover-text">View More</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
    }

    // --- 5. Dynamic Pagination HTML (Bottom me add hoga) ---
    if ($total_pages > 1) {
        $output .= '<div class="col-lg-12">
                        <div class="filter-bar d-flex flex-wrap align-items-center justify-content-end" style="margin-top:20px; width:100%;">
                            <div class="pagination">';
        
        if($page > 1){
            $output .= '<a href="javascript:void(0);" class="prev-arrow ajax-page-link" data-page="'.($page - 1).'"><i class="fa fa-long-arrow-left"></i></a>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? 'active' : '';
            $output .= '<a href="javascript:void(0);" class="ajax-page-link '.$active.'" data-page="'.$i.'">'.$i.'</a>';
        }

        if($page < $total_pages){
            $output .= '<a href="javascript:void(0);" class="next-arrow ajax-page-link" data-page="'.($page + 1).'"><i class="fa fa-long-arrow-right"></i></a>';
        }

        $output .= '</div></div></div>';
    }
} else { 
    $output = "<div class='col-12 text-center p-5'><h3>No products found!</h3></div>";
}

echo $output;
?>