<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart with Voucher</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        

        .voucher-btn {
            background-color: #28a745;
            color: white;
        }
        .update-btn {
            background-color: #ff5e14;
            color: white;
        }
        .checkout-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>



<!-- Header Banner -->
<?php include "navbar.php";
?>


<!-- Cart Container -->
<div class="container cart-container ">
    <div class="row">
        <!-- Cart Items -->
        <div class="col-md-8">
            <h3>Your Cart</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Product 1 -->
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/60" alt="shoe" class="me-2">
                                <div>
                                    <strong>Women's Legacy Oxford Sneaker</strong><br>
                                    <small>Color: WHITE/GOLD/GUM | Size: 6.0</small>
                                </div>
                            </div>
                        </td>
                        <td>$54.99</td>
                        <td>
                            <input type="number" class="form-control text-center quantity-input" value="1" min="1" data-price="54.99" style="width: 60px;">
                        </td>
                        <td class="subtotal">$54.99</td>
                    </tr>
                    <!-- Product 2 -->
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/60" alt="boot" class="me-2">
                                <div>
                                    <strong>Women's Grotto II Boot</strong><br>
                                    <small>Color: PURPLE/WHITE | Size: 6.0</small>
                                </div>
                            </div>
                        </td>
                        <td>$84.99</td>
                        <td>
                            <input type="number" class="form-control text-center quantity-input" value="1" min="1" data-price="84.99" style="width: 60px;">
                        </td>
                        <td class="subtotal">$84.99</td>
                    </tr>
                </tbody>
            </table>

            <!-- Coupon and Voucher Buttons -->
            <div class="d-flex justify-content-between">
                <button class="btn voucher-btn" data-bs-toggle="modal" data-bs-target="#voucherModal">Apply Voucher</button>
                <div>
                    <input type="text" class="form-control d-inline-block" placeholder="Coupon code" style="width: 150px;">
                    <button class="btn btn-outline-dark">Apply</button>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-md-4">
            <h4>Cart Totals</h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong id="cart-subtotal">$139.98</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Shipping</span>
                    <strong>Free</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <strong id="cart-total">$139.98</strong>
                </li>
            </ul>
            <!-- Checkout Buttons -->
            <button class="btn checkout-btn w-100 mb-2"><i class="fas fa-credit-card"></i> Checkout</button>
        </div>
    </div>
</div>

<!-- Voucher Modal -->
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherModalLabel">Available Vouchers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Voucher Code:</strong> SAVE10</p>
                <p>Get 10% off your order. Apply this voucher at checkout.</p>
                <p><strong>Voucher Code:</strong> FREESHIP</p>
                <p>Enjoy free shipping on orders over $50.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Apply Voucher</button>
            </div>
        </div>
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
