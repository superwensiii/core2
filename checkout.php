

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="http://www.paypal.com/sdk/js?client-id=AfWWgIuFSgyu8PBCPZaSblbJ4tuRBURmBDp3lGvNAqcyJmX5zn84vfiPbbEgTviDvsI7kkHQqMSaxYcY"></script>

    
</head>
<body>
<?php 

    

// Include database connection
include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
    $cart = array_map(function($item) {
        return json_decode($item, true);
    }, $_POST['cart']);
} else {
    // Redirect back to cart if no cart data is available
    header("Location: cart.php");
    exit;
}
include 'navbar.php'; 


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT first_name, surname, email, phone, address FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <!-- Delivery Address Section -->
    <div class="card mb-4" style="position: relative;">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fas fa-map-marker-alt"></i> Delivery Address
        </h5>
        <p class="card-text">
            <strong><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['surname']); ?> 
            (<?php echo htmlspecialchars($user['phone']); ?>)</strong><br>
            <?php echo nl2br(htmlspecialchars($user['address'])); ?>
        </p>
        <a href="edit_account.php" class="btn btn-dark btn-sm" style="position: absolute; top: 10px; right: 10px;">Edit</a>
    </div>
</div>


    <!-- Products Ordered Section -->
    <div class="container">
        <h1>Checkout</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($item['image_url']); ?>" style="width: 80px;"></td>
                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>

    <!-- Shop Voucher Section -->
    <div class="row mb-4">
    <!-- Shop Voucher -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Shop Voucher</h5>
                <!-- Button to trigger modal -->
                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#shopVoucherModal">Change Voucher</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shopVoucherModal" tabindex="-1" aria-labelledby="shopVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shopVoucherModalLabel">Choose Your Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <button class="list-group-item list-group-item-action">10% Off</button>
                    <button class="list-group-item list-group-item-action">Free Shipping</button>
                    <button class="list-group-item list-group-item-action">Buy 1 Get 1 Free</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Payment Method -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-start">
                <h5 class="card-title">Payment Method</h5>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#paymentMethodModal">Select Payment Method</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Payment Options -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentMethodModalLabel">Choose Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <button class="list-group-item list-group-item-action">GCash</button>
                    <div class="col-12">
                <div id="paypal-button-container" class="my-4"></div>
                <script>
                    paypal.Buttons().render('#paypal-button-container');
                </script>
            </div>
                    <button class="list-group-item list-group-item-action">Cash on Delivery (COD)</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Message for Sellers -->
<div class="mb-4">
    <label for="message" class="form-label">Message us!</label>
    <input type="text" class="form-control" id="message" placeholder="Please leave a message...">
</div>


    <!-- Payment Summary -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Payment Method</h5>
            <div class="d-flex justify-content-between align-items-center">
                <span>Merchandise Subtotal:</span>
                <span>P259</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span>Shipping Subtotal:</span>
                <span>P26</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span>Voucher Discount:</span>
                <span>-P15</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <strong>Total Payment:</strong>
                <strong>P280</strong>
            </div>
        </div>
    </div>
    <a href="cart.php" class="btn btn-dark">Back to Cart</a>

    <!-- Place Order Button -->
    <div class="text-end">
    <a href="process_checkout.php" class="btn btn-warning">Place Order</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
