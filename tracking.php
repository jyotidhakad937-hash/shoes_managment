<?php
include 'config.php';
include 'header.php';

$statusMsg = '';
$errorMsg  = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = trim($_POST['order']);
    $email    = trim($_POST['email']);

    if (empty($order_id) || empty($email)) {
        $errorMsg = "⚠️ Please fill all fields";
    } else {
        $query = "SELECT status FROM orders WHERE order_id=? AND email=? LIMIT 1";
        $stmt  = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $order_id, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $statusMsg = "✅ Your Order Status: <b>".$data['status']."</b>";
        } else {
            $errorMsg = "❌ Order not found. Please check Order ID or Email.";
        }
    }
}
?>

<!-- Banner -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex align-items-center justify-content-end">
            <div class="col-first">
                <h1>Order Tracking</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Order Tracking</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Tracking Area -->
<section class="tracking_box_area section_gap">
    <div class="container">
        <div class="tracking_box_inner">

            <p>Enter your Order ID and Billing Email to track your order.</p>

            <!-- Messages -->
            <?php if($statusMsg){ ?>
                <div class="alert alert-success"><?= $statusMsg; ?></div>
            <?php } ?>

            <?php if($errorMsg){ ?>
                <div class="alert alert-danger"><?= $errorMsg; ?></div>
            <?php } ?>

            <form class="row tracking_form" method="post">
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="order" placeholder="Order ID">
                </div>

                <div class="col-md-12 form-group">
                    <input type="email" class="form-control" name="email" placeholder="Billing Email Address">
                </div>

                <div class="col-md-12 form-group">
                    <button type="submit" class="primary-btn">Track Order</button>
                </div>
            </form>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
