<!DOCTYPE html>
<html lang="en">
<head>
    <title>SERANOVA</title>
    <link rel="icon" href="images/logo.png" type="image/png">
	
	<style>
		#errorModal {
			animation: fadeIn 0.3s ease;
		}

		@keyframes fadeIn {
			from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
			to   { opacity: 1; transform: translateX(-50%) translateY(0); }
		}
	</style>

</head>

<body>


    <img src="banner.jpg" alt="Concert Background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; object-fit: cover;">
    
    <header style="display: flex; align-items: center; gap: 10px; padding: 20px;">
		<img src="images/logo.png" alt="icon" style="width: 70px; height: auto;">
		<h1 style="color: white; text-shadow: 2px 2px 4px black; margin: 0;">ERANOVA</h1>
	</header>

    <main style="text-align: center;">
		<!-- Login Form Section -->
		<section style="margin-top: 20px; padding: 15px; width: 20%; background-color: rgba(255, 255, 255); border-radius: 8px; margin-left: auto; margin-right: auto;">


			<h2 style="color: black;">Login</h2>
			<form action="login_action.php" method="POST">
				<div style="margin-bottom: 10px;">
					<label for="username" style="display: block; text-align: left;">Username:</label>
					<input type="text" id="username" name="username" style="width: 100%; padding: 2px; border-radius: 4px; border: 1px solid #ccc;" required>
				</div>
				<div style="margin-bottom: 10px;">
					<label for="password" style="display: block; text-align: left;">Password:</label>
					<input type="password" id="password" name="password" style="width: 100%; padding: 2px; border-radius: 4px; border: 1px solid #ccc;" required>
				</div>
						
				<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
				<div style="color: red; font-weight: bold; margin-bottom: 10px;">
						Invalid username or password. Please try again.
					</div>
				<?php endif; ?>

					<button type="submit" style="padding: 8px 15px; background-color: #333; color: white; border: none; border-radius: 4px; cursor: pointer;">
						Login
					</button>

					<div style="margin-top: 10px;">
						<p style="margin: 10px 0;">Don't have an account?</p>
						<a href="signup.php" style="
							display: inline-block;
							padding: 8px 15px;
							background-color: #555;
							color: white;
							text-decoration: none;
							border-radius: 4px;
							font-size: 14px;
						">Sign Up</a>
				</div>
			</form>
		</section>
		<br>
		<!-- Marquee Section -->
		<div style="width: 50%; margin: auto; padding: 10px; background-color: rgba(255, 255, 255); border-radius: 8px; text-align: center;">
			<div style="color: maroon; font-size: 24px; font-weight: bold;">
				Top Selling Artist
			</div>
		</div>

		<!-- Image Section -->
		<div style="width: 50%; margin: auto; padding: 10px; background-color: rgba(255, 255, 255); border-radius: 8px; display: flex; justify-content: center; gap: 20px;">
			<div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
				<img src="blackpink.jpg" alt="Blackpink" style="width: 150px; height: auto;">
				<h3>Blackpink</h3>
			</div>
			<div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
				<img src="Week.jpeg" alt="The Weeknd" style="width: 150px; height: auto;">
				<h3>The Weeknd</h3>
			</div>
			<div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
				<img src="LDR.jpeg" alt="Lana Del Rey" style="width: 150px; height: auto;">
				<h3>Lana Del Rey</h3>
			</div>
		</div>
    </main>
</body>
</html>


