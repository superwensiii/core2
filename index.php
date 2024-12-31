<?php
session_start(); // Start session to manage user login status
?>

<?php include "db/connect.php"; ?>

<?php
// Fetch all products initially
$sql = "SELECT * FROM products"; 
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No products found.";
}

//search
if (isset($_POST['search_box'])) {
    $search_box = trim($_POST['search_box']);
    $stmt = $conn->prepare("SELECT * FROM `products` WHERE `product_name` LIKE ?");
    $search_term = '%' . $search_box . '%';
    $stmt->bind_param('s', $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['product_name'] . '<br>';
        }
    } else {
        echo "No products match your search."; 
    }

    $stmt->close();
}

// Close the connection at the very end
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Great Wall Arts</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/footer.css">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .hero-section {
      background-color: #e8f5e9;
      padding: 50px 0;
      text-align: center;
    }
    .hero-section img {
      max-width: 100px;
    }
    .categories, .new-arrivals {
      padding: 20px 0;
    }
    .btn-green {
      background-color: #4caf50;
      color: white;
    }
    .btn-green:hover {
      background-color: #45a049;
    }
    .navbar-brand img {
      max-height: 40px;
      margin-right: 10px;
    }
  </style>
</head>
<body>
<!-- Navbar -->
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
    margin-top: -8px; 
    z-index: 1000;
    
    
}

.search-box-container .form-control {
    
    border-radius: 5%;
    border-width: 2px;
}

.search-box-container .btn {
    border-width: 2px;
}

  </style>
  <div class="search-box-container bg-white py-3">
    <div class="container bg-white">
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
                    <button class="btn btn-outline-warning text-dark ms-2" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


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

            
            









            
          




<div class="container my-5">
  <div class="row align-items-start">
    <!-- Main Banner Section with Slide -->
    <div class="col-md-8 position-relative">
      <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
          <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="2"></button>
        </div>
        <!-- Slides -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="banner text-dark" style="background-image: url('images/hehe.png');">
              <span class="badge bg-danger">Exclusive Offer 15%</span>
              <h1>Trade in Offer</h1>
              <p>Super Value Deals</p>
              <h3>Save more <span class="text-success">Coupons</span></h3>
              <button class="btn btn-outline-dark">Shop Now</button>
            </div>
          </div>
          <div class="carousel-item">
            <div class="banner text-dark" style="background-image: url('images/inangyna.png');">
              <span class="badge bg-warning text-dark">New Collection</span>
              <h1>Sustainable Deals</h1>
              <p>Celebrate Eco-Friendly Choices</p>
              <h3>Starting at <span class="text-success">$9.99</span></h3>
              <button class="btn btn-outline-success">Explore Now</button>
            </div>
          </div>
          <div class="carousel-item">
            <div class="banner text-dark" style="background-image: url('images/sigeba.png');">
              <span class="badge bg-primary">Hot Deals</span>
              <h1>Summer Sales</h1>
              <p>Hot Discounts, Cool Prices</p>
              <h3>Up to <span class="text-danger">50% Off</span></h3>
              <button class="btn btn-outline-primary">Grab Deals</button>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>

    <!-- Info Cards Section -->
    <div class="col-md-4 align-items-start">
  <!-- Info Card 1 with Background Image -->
  <div class="info-card mb-3" style="background-image: url('images/hehe.png'); background-size: cover; background-position: center; color: white;">
    <h5 class="text-dark">10% cashback on personal care</h5>
    <p class="text-dark">Max cashback: $12 <br> Code: <strong class="text-dark">CARE12</strong></p>
    <button class="btn  btn-sm btn-outline-warning">Shop Now</button>
  </div>

  <!-- Info Card 2 with Background Image -->
  <div class="info-card yellow mt-4" style="background-image: url('images/hehe.png'); background-size: cover; background-position: center; color: black;">
    <h5>Say yes to season's fresh</h5>
    <p>Refresh your day the fruity way</p>
    <button class="btn btn-sm btn-outline-dark">Shop Now</button>
  </div>
</div>

<!-- Additional Styling -->
<style>
  .banner {
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    padding: 50px;
    color: white;
    position: relative;
  }

  .info-card {
    background-color: #f0f8ff;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
  }

  .info-card.yellow {
    background-color: #fff4e1;
  }

  .btn {
    z-index: 2; /* Ensures the button is clickable */
    position: relative;
    background: transparent;
  }
  
</style>
<style>
  .category-item img {
    width: 75px; /* Adjust the width */
    height: auto; /* Maintains aspect ratio */
    object-fit: cover; /* Ensures the image fits nicely */
    border-radius: 0;
    margin-bottom: 10px;
    
  }

  
  
  .category-item a:hover img {
    transform: scale(1.1);
    transition: transform 0.3s ease;
  
  }

  .category-item a:hover p {
    color: green; /* Highlight the text on hover */
  }
</style>



    <!-- Categories Section -->
    <h3 class="mt-5 text-center" style="font-family: fantasy;">Shop Popular Categories</h3>
<div class="d-flex justify-content-center flex-wrap mt-5">
  <!-- Category 1 -->
  <div class="category-item mx-4">
    <a href="category-dairy.html" class="text-decoration-none text-center">
      <img src="images/tumbler (1).png" alt="Tumbler">
      <p>Tumbler</p>
    </a>
  </div>
  <!-- Category 2 -->
  <div class="category-item mx-4">
    <a href="category-fruits.html" class="text-decoration-none text-center">
      <img src="images/powerbank (1).png" alt="Powerbank">
      <p>Powerbank</p>
    </a>
  </div>
  <!-- Category 3 -->
  <div class="category-item mx-4">
    <a href="category-snacks.html" class="text-decoration-none text-center">
      <img src="images/air.png" alt="Mini Fan">
      <p>Mini Fan</p>
    </a>
  </div>
  <!-- Category 4 -->
  <div class="category-item mx-4">
    <a href="category-bakery.html" class="text-decoration-none text-center">
      <img src="images/gift.png" alt="Gif Set">
      <p>Gift Set</p>
    </a>
  </div>
  <!-- Category 5 -->
  <div class="category-item mx-4">
    <a href="category-instant.html" class="text-decoration-none text-center">
      <img src="images/table (1).png" alt="Table">
      <p>Table</p>
    </a>
  </div>
  <!-- Category 6 -->
  <div class="category-item mx-4">
    <a href="category-drinks.html" class="text-decoration-none text-center">
      <img src="images/cutlery.png" alt="Wooden Utensils">
      <p>Utensils</p>
    </a>
  </div>
</div>
<style>
    /* Custom styles */
    .card {
      border: 1px solid #ddd;
      border-radius: 10px;
    }
    .card-img-top {
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .modal-content {
  padding: 10px;
  border-radius: 8px;
}

.modal-body {
  padding: 10px;
}

.modal-header {
  border-bottom: none;
}

#reviews1 div {
  border-bottom: 1px solid #ddd;
  padding-bottom: 5px;
  margin-bottom: 5px;
}

  </style>



 <!-- product section -->
 <!-- Product Cards Section -->
 <div class="container my-5">
  <h2 class="text-center mb-4" style="font-family: fantasy; color: #343a40;">Featured Products</h2>
  <p class="text-center" style="font-family: 'Courier New', Courier, monospace; font-size: 20px; color: gray;">
    Summer Collection - New Modern Design
  </p>
  <div class="row">
    <?php foreach ($products as $product): ?>
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card shadow-sm h-100">
          <a href="quick_view.php?id=<?php echo $product['id']; ?>">
            <img 
              src="<?php echo $product['image_url']; ?>" 
              class="card-img-top img-fluid" 
              alt="<?php echo $product['product_name']; ?>"
              style="height: 250px; object-fit: cover;"
            >
          </a>
          <div class="card-body d-flex flex-column justify-content-between text-center">
            <h5 class="card-title text-truncate"> <?php echo $product['product_name']; ?> </h5>
            <p class="small text-muted text-truncate"> <?php echo $product['product_description']; ?> </p>
            <p class="mb-2">
              <del class="text-muted">₱<?php echo number_format($product['original_price'], 2); ?></del>
              <span class="text-dark fw-bold">₱<?php echo number_format($product['discounted_price'], 2); ?></span>
              <span class="badge bg-success ms-1"> <?php echo $product['discount_percentage']; ?>% OFF</span>
            </p>
            <div class="d-flex justify-content-center align-items-center gap-4 mb-2">
              <button class="btn btn-outline-warning btn-sm">
                <i class="fas fa-shopping-cart"></i>
              </button>
              <button class="btn btn-outline-danger btn-sm">
                <i class="fas fa-heart"></i>
              </button>
              <button 
                class="btn btn-outline-dark btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#productModal<?php echo $product['id']; ?>">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div>
              <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
              <span class="text-muted">(<?php echo rand(100, 500); ?>)</span>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
    <!-- End of Product Card Example -->
  </div>
</div> 

    <!-- Compact Product Modal -->
    
    <!-- End of Compact Product Modal -->









<div class="container py-5">
    <div class="feature-section">
      <div>
        <h1 >We are HIRING!</h1>
        <h2> Graphic Designer </h2>
        <h5>QUALITIES:</h5>
        <p> 2 - 3 YEARS EXPERIENCE
BACHELOR'S DEGREE IN GRAPHIC </p>
<p>DESIGN STRONG TECHNICAL DESIGN SKILLS
</p>
        <a href="#" class="btn btn-outline-warning text-dark">Apply Now</a>
      </div>
      <video  class="video" src="images/graphic.mp4" autoplay muted loop></video>
    </div>
  </div>

  <style>
  
  .feature-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 100px;
    background-color: transparent;
    border-radius: 10px;
    overflow: hidden;
    transform: translateY(50px);
    opacity: 0;
    transition: all 0.6s ease;
    
  }
  .feature-section.visible {
    transform: translateY(0);
    opacity: 1;
  }
  .feature-section h1 {
    font-size: 4rem;
    margin-bottom: 20px;
    
    
  }
  .feature-section h2 {
    margin-bottom: 20px;
    font-size: 3rem;
    text-align: center;
  }
  .feature-section video {
    max-width: 50%;
    border-radius: 10px;
  }
  .btn-primary {
    border: none;
  }
  .video {
    height: 200%;
    width: 200%;
  }
  </style>

  

  <script>
     document.addEventListener('DOMContentLoaded', () => {
      const featureSection = document.querySelector('.feature-section');

      const revealFeature = () => {
        const triggerBottom = window.innerHeight * 0.8;
        const sectionTop = featureSection.getBoundingClientRect().top;

        if (sectionTop < triggerBottom) {
          featureSection.classList.add('visible');
        } else {
          featureSection.classList.remove('visible');
        }
      };

      window.addEventListener('scroll', revealFeature);
      revealFeature(); // Initial check
    });
  </script>

<div class="container py-5">
    <h1 class="section-title text-center">Principaux outils IA</h1>
    <p class="text-center mb-5">Trouve l'inspiration grâce aux outils simples d'utilisation de CapCut.</p>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card">
          <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Dreamina">
          <div class="card-body">
            <h5 class="card-title">Dreamina</h5>
            <p class="card-text">Crée des images de qualité à partir d'invites de texte et d'images.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Générateur de voix IA">
          <div class="card-body">
            <h5 class="card-title">Générateur de voix IA</h5>
            <p class="card-text">Génère un discours réaliste à partir de texte, ou modifie des voix avec l'IA.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Vidéo longue en vidéos courtes">
          <div class="card-body">
            <h5 class="card-title">Vidéo longue en vidéos courtes</h5>
            <p class="card-text">Transforme en 1 clic tes vidéos longues en vidéos courtes partageables.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
 
  .card {
    background-color: transparent;
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transform: translateY(50px);
    opacity: 0;
    transition: all 0.6s ease;
  }
  .card img {
    object-fit: cover;
  }
  .card.visible {
    transform: translateY(0);
    opacity: 1;
  }
  .section-title {
    text-align: center;
    margin-bottom: 40px;
  }
  </style>

  <script>
    // Animation on scroll
    document.addEventListener('DOMContentLoaded', () => {
      const cards = document.querySelectorAll('.card');

      const revealCards = () => {
        const triggerBottom = window.innerHeight * 0.7;

        cards.forEach(card => {
          const cardTop = card.getBoundingClientRect().top;

          if (cardTop < triggerBottom) {
            card.classList.add('visible');
          } else {
            card.classList.remove('visible');
          }
        });
      };

      window.addEventListener('scroll', revealCards);
      revealCards(); // Initial check
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  


  <div class="form">
    <input type="text" placeholder="Your email address">
    <button class="normal1">Sign Up</button>
  </div>
</section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php require ('footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/cart.js"></script>
</body>
