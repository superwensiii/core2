<?php
// Start session
session_start();




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate login credentials...

    if ($is_valid_user) {
        $_SESSION['user_id'] = $user_id;
        $redirect_to = $_GET['redirect_to'] ?? 'index.php';
        header("Location: " . $redirect_to);
        exit();
    } else {
        echo "Invalid credentials!";
    }
}

?>



<?php include '../db/connect.php'; ?>

<?php

if (isset($_POST['login'])) {
    
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

       
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            
            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email']; 
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['surname']; 

                
                header("Location: ../index.php");
                exit; 
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            display: flex;
            background: #fff;
            border-radius: 10px;
            padding: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            overflow: hidden;
        }
        .login-container .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #007bff;
        }
        .login-container .image-container img {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .login-container .login-form {
            flex: 1;
            padding: 40px;
        }
        .login-form h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Image Section -->
        <div class="image-container">
            <img src="../images/Great Wall Arts.png" alt="Login Illustration">
        </div>
        <!-- Form Section -->
        <div class="login-form">
            <h1 class="text-center">Login</h1>
            <form action="user_login.php" method="POST">
                <input type="email" class="form-control mb-3" name="username" placeholder="Email" required>
                <div class="position-relative mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <a href="#" class="d-block mb-3 text-dark">Forgot password?</a>
                <button type="submit" name="login" class="btn btn-warning w-100">Login</button>
            </form>
            <p class="mt-3 text-dark text-center">Don’t have an account? <a href="../gmailreg.php" class="text-dark"> Signup</a></p>
            <div class="my-3">
                <span class=" text-center">Or</span>
            </div>
            <div class="social-buttons">
                <button class="btn btn-primary d-flex align-items-center justify-content-center mb-2">
                    <i class="bi bi-facebook me-2"></i> Login with Facebook
                </button>
                <button class="btn btn-light d-flex align-items-center justify-content-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" alt="Google Logo" style="width: 20px; height: 20px; margin-right: 10px;">
                    Login with Google
                </button>
            </div>
            <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>
</html>
