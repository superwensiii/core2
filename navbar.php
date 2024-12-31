<?php
session_start(); // Start session to manage user login status
?>



<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <!-- Logo and Title -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="images/logo-removebg-preview.png" alt="Logo" class="me-2" style="height: 40px;">
            <span class="fw-bold" style="color: #333; font-size: 22px;">
                Great Wall <span style="color: #ffb100;">Arts</span>
            </span>
        </a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="nav-item me-4">
                    <a class="nav-link fw-bold text-dark" href="index.php">Home</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link fw-bold text-dark" href="main/products.php">Products</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link fw-bold text-dark" href="main/contact.php">Contact</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link fw-bold text-dark" href="main/about.php">About Us</a>
                </li>

                <!-- Icons -->
                <li class="nav-item me-3">
                    <a class="nav-link text-dark" href="#" aria-label="Notifications">
                        <i class="fas fa-bell fs-5"></i>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-dark" href="#" aria-label="Orders">
                        <i class="fas fa-shopping-bag fs-5"></i>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-dark position-relative" href="#" id="cartIcon" aria-label="Cart">
                        <i class="fas fa-cart-shopping fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-warning text-dark">
                            3 <!-- Replace with PHP cart count -->
                        </span>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-dark" href="#" aria-label="Wishlist">
                        <i class="fas fa-heart fs-5"></i>
                    </a>
                </li>

                <!-- User Section -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link fw-bold text-dark">
                            Welcome, <?= htmlspecialchars($_SESSION['full_name']); ?>!
                        </span>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-warning text-darkfw-bold" href="user_account/user_account.php">
                            <i class="fas fa-user-circle me-2"></i>My Account
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-3">
                        <a class="btn btn-outline-warning fw-bold" href="main/user_login.php">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-outline-secondary fw-bold" href="main/register.php">
                            <i class="fas fa-user-plus me-2"></i>Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark">Your Cart</h5>
        <button class="btn-close" id="closeCartSidebar"></button>
    </div>
    <div class="cart-body py-3">
        <?php if (!empty($_SESSION['cart'])): ?>
            <ul class="list-group">
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold"><?= htmlspecialchars($item['name']); ?></h6>
                            <small class="text-muted">Quantity: <?= $item['quantity']; ?></small>
                        </div>
                        <span class="text-success fw-bold">$<?= number_format($item['price'], 2); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <div class="cart-footer d-flex justify-content-between align-items-center border-top pt-3">
        <a href="checkout.php" class="btn btn-warning fw-bold text-white px-4">Checkout</a>
        <button class="btn btn-outline-danger fw-bold" id="clearCart">Clear Cart</button>
    </div>
</div>

<!-- Sidebar CSS -->
<style>
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -350px;
        width: 350px;
        height: 100%;
        background-color: #fff;
        box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
        transition: right 0.4s ease;
        z-index: 9999;
        padding: 20px;
    }

    .cart-sidebar.open {
        right: 0;
    }

    .cart-header {
        border-bottom: 2px solid #f5f5f5;
        padding-bottom: 10px;
    }

    .btn-warning {
        background-color: #ffb100;
        border-color: #ffb100;
    }

    .btn-outline-warning:hover {
        background-color: #ffb100;
        color: #fff;
    }

    .nav-link:hover {
        color: #ffb100 !important;
    }

    .badge {
        font-size: 12px;
        padding: 5px 8px;
        border-radius: 50%;
    }
</style>



<!-- FontAwesome and Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/your-fontawesome-key.js" crossorigin="anonymous"></script>

  <style>
    body {
      font-family: 'Arial', sans-serif;
    }

    /* Main Banner Section */
    .banner {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
    }

    .banner .btn-primary {
      background-color: #28a745;
      border: none;
      padding: 10px 20px;
    }

    .banner img {
      width: 100%;
      border-radius: 10px;
    }

    /* Cards Section */
    .info-card {
      background-color: #f0f8ff;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
    }

    .info-card h5 {
      font-size: 16px;
    }

    .info-card .btn {
      background-color: #004085;
      color: #fff;
    }

    .info-card.yellow {
      background-color: #fff4e1;
    }

    /* Categories Section */
    .category-item {
      text-align: center;
    }

    .category-item img {
      width: 60px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .category-item p {
      font-size: 14px;
      color: gray;
    }

    .search-box-container {
    margin-top: -8px; /* Adjust to seamlessly align with the navbar */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better separation */
    z-index: 1000;
}

.search-box-container .form-control {
    border-radius: 0;
    border-width: 2px;
}

.search-box-container .btn {
    border-width: 2px;
}

  </style>
  <div class="search-box-container bg-light py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form method="GET" action="search_results.php" class="d-flex w-100">
                    <input 
                        type="text" 
                        name="search_box" 
                        class="form-control border-warning" 
                        placeholder="What do you want huh?" 
                        aria-label="Search products"
                        required
                    >
                    <button class="btn btn-outline-warning text-dark" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/cart.js"></script>


<?php
include 'db/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_box'])) {
  $search_box = trim($_POST['search_box']);

  try {
      // Prepare and execute the query
      $stmt = $conn->prepare("SELECT * FROM `products` WHERE `product_name` LIKE ?");
      $search_term = '%' . $search_box . '%';
      $stmt->bind_param('s', $search_term);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $products = $result->fetch_all(MYSQLI_ASSOC);
      } else {
          $products = [];
      }

      $stmt->close(); // Close the statement
  } catch (mysqli_sql_exception $e) {
      echo "Error: " . $e->getMessage();
      $products = [];
  }
}

// Avoid closing the connection prematurely; move `$conn->close()` to the end of the script if needed.
?>

            
            









            
          




