<?php
session_start();

if (!isset($_SESSION['cart_total'])) {
    $_SESSION['cart_total'] = 1500; // ₹1500 demo
}

define('RAZOR_KEY_ID', 'rzp_test_wNRznW3pfPWGYZ');
define('RAZOR_KEY_SECRET', 'nuY9acfKYQR1TPkLc0xms8oO');

$paymentStatus = null;
$cartTotal = $_SESSION['cart_total'];
$amountInPaise = $cartTotal * 100;

if (
    isset($_POST['razorpay_payment_id']) &&
    isset($_POST['razorpay_order_id']) &&
    isset($_POST['razorpay_signature'])
) {
    $orderId   = $_POST['razorpay_order_id'];
    $paymentId = $_POST['razorpay_payment_id'];
    $signature = $_POST['razorpay_signature'];

    $generatedSignature = hash_hmac(
        'sha256',
        $orderId . "|" . $paymentId,
        RAZOR_KEY_SECRET
    );

    if ($generatedSignature === $signature) {
        $paymentStatus = "✅ Payment Successful<br>Payment ID: " . $paymentId;
        unset($_SESSION['cart_total']); // clear cart
    } else {
        $paymentStatus = "❌ Payment Failed: Invalid Signature";
    }
} else {
    
    $ch = curl_init();

    $orderData = [
        'receipt'         => 'rcpt_' . time(),
        'amount'          => $amountInPaise,
        'currency'        => 'INR',
        'payment_capture' => 1
    ];

    curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, RAZOR_KEY_ID . ":" . RAZOR_KEY_SECRET);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($orderData));

    $result = curl_exec($ch);
    curl_close($ch);

    $order = json_decode($result, true);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Payment</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eef2f3, #d9e4ec);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            width: 380px;
            padding: 35px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        h2 {
            margin-bottom: 8px;
            font-size: 26px;
            color: #222;
        }

        .sub {
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }

        .razorpay-payment-button {
            background: linear-gradient(135deg, #0f9d58, #34a853) !important;
            color: #fff !important;
            padding: 14px 28px !important;
            font-size: 16px !important;
            font-weight: 600;
            border-radius: 10px !important;
            border: none !important;
            cursor: pointer;
            transition: 0.3s;
        }

        .razorpay-payment-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.2);
        }

        .success {
            color: #0f9d58;
            font-weight: 600;
        }

        .fail {
            color: #d93025;
            font-weight: 600;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #0f9d58;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="card">
<?php if ($paymentStatus): ?>
    <h2 class="<?php echo strpos($paymentStatus, 'Successful') !== false ? 'success' : 'fail'; ?>">
        <?php echo $paymentStatus; ?>
    </h2>
    <a href="index.php">Go Back</a>

<?php elseif (isset($order['id'])): ?>
    <h2>Pay ₹<?php echo number_format($cartTotal); ?></h2>
    <p class="sub">Secure checkout • 100% safe payment</p>

    <form action="index.php" method="POST">
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="<?php echo RAZOR_KEY_ID; ?>"
            data-amount="<?php echo $order['amount']; ?>"
            data-currency="INR"
            data-order_id="<?php echo $order['id']; ?>"
            data-buttontext="Pay Securely"
            data-name="My Store"
            data-description="Cart Payment"
            data-prefill.name="Customer"
            data-prefill.email="customer@test.com"
            data-theme.color="#0f9d58">
        </script>
    </form>

<?php else: ?>
    <h2>Error</h2>
    <p>Unable to create order</p>
<?php endif; ?>
</div>

</body>
</html>
