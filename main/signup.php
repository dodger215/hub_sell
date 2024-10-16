<?php 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Olly' doughnut | sign in</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<section class="auth-container d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f8f9fa;">
        <div class="auth-box bg-white p-5 rounded shadow-sm" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Login</h2>
            <form action="./include/php/signup.php" id="login-form" method="POST" autocomplete="off">
            	<div class="mb-3">
                    <label for="fname" class="form-label">Your full name</label>
                    <input type="text" class="form-control" id="name" name="fname" placeholder="Enter your full name" required>
                </div>
            	<div class="mb-3">
                    <label for="phonenumber" class="form-label">Your phone number</label>
                    <input type="number" class="form-control" id="number" name="number" placeholder="Enter your phone number" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Your location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter your location" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="text-center mt-3">Already have an account? <a href="signin.php">Sign in here</a></p>
            </form>
        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>