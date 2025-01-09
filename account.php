
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
<?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user"></i> My Account
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart"></i> My Purchase
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-tag"></i> My Vouchers
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-coins"></i> My Coins
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h4>All Purchases</h4>

                <!-- Purchase Item -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Product Image">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">Bonnet Beanies</h5>
                                <p class="card-text">Variation: Black<br>Seller: <strong>umichoi.ph</strong></p>
                                <p class="card-text text-muted">Parcel has been delivered</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-danger mb-0">₱159</p>
                                    <div>
                                        <button class="btn btn-primary btn-sm">Order Received</button>
                                        <button class="btn btn-secondary btn-sm">Request Refund</button>
                                        <button class="btn btn-outline-secondary btn-sm">Contact Seller</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Another Purchase Item -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Product Image">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">Plant Dried Flower Scented Candle</h5>
                                <p class="card-text">Variation: French Cade & Lavender<br>Seller: <strong>Love life and home</strong></p>
                                <p class="card-text text-muted">Parcel has been delivered</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-danger mb-0">₱75</p>
                                    <div>
                                        <button class="btn btn-primary btn-sm">Order Received</button>
                                        <button class="btn btn-secondary btn-sm">Request Refund</button>
                                        <button class="btn btn-outline-secondary btn-sm">Contact Seller</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
