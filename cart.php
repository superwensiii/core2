<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .cart-container {
            margin: 30px auto;
        }
        .cart-header {
            background-color: #ff5e14;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
include "db/connect.php";

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if not already
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sync session cart with database if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch cart items from the database
    $stmt = $conn->prepare("SELECT product_id, name AS product_name, price, quantity, image AS image_url FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION['cart'] = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $name = $_POST['product_name'] ?? 'Unknown Product'; // Fallback for product name
        $quantity = $_POST['quantity'] ?? 1;
        $price = $_POST['price'] ?? 0;
        $image = $_POST['image_url'] ?? 'path/to/default-image.jpg';

        // Insert the cart item into the database
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, name, quantity, price, image, created_at, updated_at) 
                                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("iisids", $user_id, $product_id, $name, $quantity, $price, $image);

        if ($stmt->execute()) {
            // Redirect to the cart page after successful insertion
            header("Location: cart.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // Redirect to login if the user is not logged in
        header("Location: main/user_login.php");
        exit;
    }
}

// Handle deleting an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
    $index = (int)$_GET['index'];
    if (isset($_SESSION['cart'][$index])) {
        $product_id = $_SESSION['cart'][$index]['product_id'];

        // Remove the item from the session cart
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array

        // Delete the item from the database
        if (isset($_SESSION['user_id'])) {
            $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
            if (!$stmt->execute()) {
                echo "Error deleting from database: " . $stmt->error;
            }
        }
    }
}




// Handle updating quantities
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $index => $quantity) {
            if (isset($_SESSION['cart'][$index])) {
                $product_id = $_SESSION['cart'][$index]['product_id'];
                $_SESSION['cart'][$index]['quantity'] = (int)$quantity;

                // Update quantity in the database
                if (isset($_SESSION['user_id'])) {
                    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $stmt->bind_param("iii", $quantity, $_SESSION['user_id'], $product_id);
                    if (!$stmt->execute()) {
                        echo "Error updating database: " . $stmt->error;
                    }
                }
            }
        }
        
        
    } else {
        // Handle case where 'quantities' is not set or invalid
        echo '<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                <div style="background: transparent; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <p style="font-size: 20px; color: white; margin-bottom: 20px;">Your cart is empty! Please continue shopping!</p>
                    <button onclick="window.history.back();" style="padding: 10px 20px; font-size: 16px; color: black;  border: none; border-radius: 5px; cursor: pointer;" class="btn btn-warning">Okay</button>
                </div>
              </div>';
    }
}
    


// Fetch updated cart
$cart = $_SESSION['cart'];
?>

<?php include "navbar.php"; ?>

<div class="container cart-container">
    <div class="row">
        <div class="col-md-8">
            <h3>Your Cart</h3>
            <form method="POST" action="">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $index => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name'] ?? 'Unknown Product'); ?></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'path/to/default-image.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($item['product_name'] ?? 'Image not available'); ?>" 
                                         style="width: 80px; height: auto; border-radius: 5px;">
                                </td>
                                <td>₱<?php echo number_format($item['price'] ?? 0, 2); ?></td>
                                <td>
                                    <input type="number" name="quantities[<?php echo $index; ?>]" 
                                           value="<?php echo $item['quantity'] ?? 1; ?>" 
                                           min="1" class="form-control" style="width: 80px;">
                                </td>
                                <td>₱<?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2); ?></td>
                                <td>
                                    <a href="?action=delete&index=<?php echo $index; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="update_cart" class="btn btn-outline-warning text-dark">Update Cart</button>
            </form>
        </div>
        <div class="col-md-4">
    <h4>Cart Totals</h4>
    <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between">
            <span>Total</span>
            <strong>
                ₱<?php echo number_format(array_sum(array_map(function($item) {
                    return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                }, $cart)), 2); ?>
            </strong>
        </li>
    </ul>

    <div class="justify-content-between align-items-center mt-4 me-3">
        <a href="products.php" class="btn btn-secondary btn-dark">Continue Shopping</a>
        <?php if (!empty($cart)): ?>
            <form method="POST" action="checkout.php" class="d-inline">
                <?php foreach ($cart as $item): ?>
                    <input type="hidden" name="cart[]" value='<?php echo json_encode($item); ?>'>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-warning">Proceed to Checkout</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger text-center mt-3" role="alert">
                No products in Cart
            </div>
        <?php endif; ?>
    </div>
</div>





<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to update cart totals
    document.addEventListener("DOMContentLoaded", function() {
        const quantityInputs = document.querySelectorAll(".quantity-input");
        const cartSubtotal = document.getElementById("cart-subtotal");
        const cartTotal = document.getElementById("cart-total");

        function updateCart() {
            let subtotal = 0;

            quantityInputs.forEach(input => {
                const price = parseFloat(input.getAttribute("data-price"));
                const quantity = parseInt(input.value);
                const rowSubtotal = price * quantity;
                subtotal += rowSubtotal;

                // Update subtotal per row
                input.closest("tr").querySelector(".subtotal").textContent = `$${rowSubtotal.toFixed(2)}`;
            });

            // Update Cart Summary
            cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
            cartTotal.textContent = `$${subtotal.toFixed(2)}`;
        }

        // Event Listener for Quantity Change
        quantityInputs.forEach(input => {
            input.addEventListener("input", updateCart);
        });
    });
</script>
</body>
</html>
