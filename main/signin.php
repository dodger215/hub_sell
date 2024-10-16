<?php 


require 'include/node/function.php';

if(!isset($_SESSION['status'])){
    $_SESSION['status'] = "Log into your account";
}

$sta = $_SESSION['status'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olly' doughnut | sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <section class="auth-container d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f8f9fa; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="padding: 5px; background-color: rgba(2, 159, 12, 0.5); border-radius: 5px; font-size: 600; color: #ffffff;"><?= $sta ?></div>
        <div class="auth-box bg-white p-5 rounded shadow-sm" style="max-width: 400px; width: 100%; margin: 10px 0;">
            <h2 class="text-center mb-4">Login</h2>
            <form action="./include/php/signin.php" method="POST" id="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a></p>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

   
</body>
</html>