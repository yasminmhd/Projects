<!DOCTYPE html>
<html lang="en">
<head>
    <title>SERANOVA Sign Up</title>
    <link rel="icon" href="images/logo.png" type="image/png">
</head>
<body>
    <img src="banner.jpg" alt="Concert Background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; object-fit: cover;">
    
    <header style="display: flex; align-items: center; gap: 10px; padding: 20px;">
		<img src="images/logo.png" alt="icon" style="width: 70px; height: auto;">
		<h1 style="color: white; text-shadow: 2px 2px 4px black; margin: 0;">ERANOVA</h1>
	</header>


<section style="margin: 40px auto; padding: 20px; max-width: 400px; width: 100%; background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
        Signup successful! You can now log in.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
    <div style="color: red; font-weight: bold; margin-bottom: 10px;">
        Username already taken. Please choose a different one.
    </div>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 'other'): ?>
    <div style="color: red; font-weight: bold; margin-bottom: 10px;">
        An error occurred. Please try again.
    </div>
<?php endif; ?>

        <form action="signup_action.php" method="POST">
            <h2>Create Account</h2>
            <input type="text" name="firstname" placeholder="First Name" required style="width: 96%; margin: 8px 0; padding: 8px;"><br>
            <input type="text" name="lastname" placeholder="Last Name" required style="width: 96%; margin: 8px 0; padding: 8px;"><br>
            <input type="text" name="username" placeholder="Username" required style="width: 96%; margin: 8px 0; padding: 8px;"><br>
            <input type="password" name="password" placeholder="Password" required style="width: 96%; margin: 8px 0; padding: 8px;"><br>
            <button type="submit" style="padding: 10px 20px; background-color: #333; color: white; border: none; border-radius: 4px;">Sign Up</button>
        </form>
        <p style="margin-top: 10px;">Already have an account? <a href="login.php">Login</a></p>
    </section>
</body>
</html>
