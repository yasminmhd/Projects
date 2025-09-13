<!DOCTYPE html>
<html lang="en">
<head>
    <title>SERANOVA</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="images/logo.png" type="image/png">
</head>
<body style="margin: 0; background-color: rgb(255, 255, 255); padding-bottom: 50px;">

    <img src="banner.jpg" alt="Concert Background" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 580px; object-fit: cover; z-index: -1;">

	<header style="display: flex; justify-content: flex-start; align-items: center; padding: 20px; gap: 10px;">
		<img src="images/logo.png" alt="icon" style="width: 70px; height: auto;">
		<h1 style="color: white; text-shadow: 2px 2px 4px black; margin: 0;">ERANOVA</h1>
		
		<div style="position: relative; margin-left: auto; display: flex; align-items: center; gap: 10px; margin-right: 20px;">
			<input type="text" id="searchBar" placeholder="Search for concerts..." 
				   style="padding: 10px; border-radius: 4px; border: 1px solid #ccc; width: 250px;" 
				   oninput="showSuggestions(this.value)">
			<button onclick="searchConcert()" 
					style="padding: 10px; border-radius: 4px; border: none; background-color: rgba(7, 87, 129, 0.8); color: white; cursor: pointer;">
				Search
			</button>
			
			<a href="login.php" 
			   style="padding: 10px 16px; border-radius: 4px; background-color: #b94a48; color: white; text-decoration: none; font-weight: bold;">
				Log Out
			</a>

			<div id="dropdownSuggestions" 
				 style="position: absolute; top: 50px; left: 0; width: 250px; background-color: white; border: 1px solid #ccc; border-radius: 4px; display: none; z-index: 10;">
			</div>
		</div>
	</header>

	<script>
		const concertData = [
			{ name: "Blackpink", link: "seat.php", img: "images/blackpink.jpg", artist_id: 1 },
			{ name: "Lana Del Rey", link: "seat.php", img: "images/LDR.jpg", artist_id: 2 },
			{ name: "G-Dragon", link: "seat.php", img: "images/GD.jpeg", artist_id: 3 },
			{ name: "Chase Atlantic", link: "seat.php", img: "images/chase.jpg", artist_id: 4 },
			{ name: "Mitski", link: "seat.php", img: "images/mitski.jpg", artist_id: 5 },
			{ name: "The Weeknd", link: "seat.php", img: "images/theweeknd.jpg", artist_id: 6 },
			{ name: "Zayn", link: "seat.php", img: "images/zayn.jpg", artist_id: 7 },
			{ name: "Arctic Monkeys", link: "seat.php", img: "images/arcticmonkeys.jpg", artist_id: 8 },
			{ name: "The Neighborhood", link: "seat.php", img: "images/theneighborhood.jpg", artist_id: 9 }
		];

		function showSuggestions(inputText) {
			const dropdown = document.getElementById("dropdownSuggestions");
			dropdown.innerHTML = "";
			if (inputText.trim() === "") {
				dropdown.style.display = "none";
				return;
			}

			const filteredConcerts = concertData.filter(concert =>
				concert.name.toLowerCase().includes(inputText.toLowerCase())
			);

			filteredConcerts.forEach(concert => {
				const suggestionItem = document.createElement("div");
				suggestionItem.style.display = "flex";
				suggestionItem.style.alignItems = "center";
				suggestionItem.style.padding = "10px";
				suggestionItem.style.cursor = "pointer";

				const img = document.createElement("img");
				img.src = concert.img;
				img.alt = concert.name;
				img.style.width = "30px";
				img.style.height = "30px";
				img.style.borderRadius = "4px";
				img.style.marginRight = "10px";

				const text = document.createElement("span");
				text.innerText = concert.name;

				suggestionItem.onmouseover = () => {
					suggestionItem.style.backgroundColor = "rgba(7, 87, 129, 0.8)";
					suggestionItem.style.color = "white";
				};
				suggestionItem.onmouseout = () => {
					suggestionItem.style.backgroundColor = "white";
					suggestionItem.style.color = "black";
				};

				suggestionItem.onclick = () => {
					window.location.href = `${concert.link}?artist_id=${concert.artist_id}`;
				};

				suggestionItem.appendChild(img);
				suggestionItem.appendChild(text);

				dropdown.appendChild(suggestionItem);
			});

			dropdown.style.display = filteredConcerts.length ? "block" : "none";
		}

		function searchConcert() {
			const searchText = document.getElementById("searchBar").value.toLowerCase();
			const concert = concertData.find(c => c.name.toLowerCase() === searchText);
			if (concert) {
				window.location.href = `${concert.link}?artist_id=${concert.artist_id}`;
			} else {
				alert("Concert not found!");
			}
		}
	</script>
	
	<main style="text-align: center;">
		<!-- Title inside container -->
		<div style="width: 80%; margin: auto; background-color: rgba(201, 169, 215); padding: 10px; border: 1px solid #ccc;">
			<h2 style="text-align: left; margin: 8px 0 20px 10px; color: black;">Upcoming Events</h2>

			<!-- Scroll container -->
			<div style="overflow-x: scroll; white-space: nowrap; display: flex; gap: 20px;">
			<?php
			// Database connection
			$conn = new mysqli("localhost", "root", "", "concert_ticketing_system");

			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			// Retrieve concerts
			$sql = "SELECT * FROM concert";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$artist_id = $row["artist_id"];
					$artist = htmlspecialchars($row["artistname"]);
					$date = htmlspecialchars($row["date"]);
					$time = htmlspecialchars($row["time"]);
					$venue = htmlspecialchars($row["venue"]);
					$image = htmlspecialchars($row["image"]);

					echo '<div style="display: inline-block;">';
					echo '<img src="' . $image . '" alt="' . $artist . '" style="width: 150px; height: auto;">';
					echo '<h3>' . $artist . '</h3>';
					echo '<p>' . $date . ' | ' . $time . '<br>Venue: ' . $venue . '</p>';
					echo '<a href="seat.php?artist_id=' . urlencode($artist_id) . '" style="display: inline-block; margin-top: 5px; margin-bottom: 15px; padding: 8px 16px; background-color: black; color: #c9a9d7; text-decoration: none; border-radius: 5px; font-weight: bold;">Buy Now</a>';
					echo '</div>';
				}
			} else {
				echo "<p>No concerts found.</p>";
			}
			$conn->close();
			?>
		</div>
	</main>
		<br>
		<br>
		<br>
		<br>
		<br>
		<h2 style="color: black; text-align: center;">Solo Artist</h2>
		<!-- Solo Container -->
		<section style="margin-top: 20px; padding: 20px; width: 90%; background-color: rgba(201, 169, 215, 0.5); border-radius: 8px; margin-left: auto; margin-right: auto; overflow-x: auto; white-space: nowrap;">
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/GD.jpeg" alt="G-Dragon" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">G-Dragon</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Trendsetting icon known for bold fashion<br> and genre-blending beats.</p>
			<a href="https://open.spotify.com/artist/30b9WulBM8sFuBo17nNq9c" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/LDR.jpg" alt="Lana Del Rey" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Lana Del Rey</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Dreamy vocals and poetic lyrics wrapped in <br>vintage glamor.</p>
			<a href="https://open.spotify.com/artist/00FQb4jTyendYWaN8pK0wa" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/theweeknd.jpg" alt="The Weeknd" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">The Weeknd</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Dark R&B anthems with neon-lit emotion<br> and haunting hooks.</p>
			<a href="https://open.spotify.com/artist/1Xyo4u8uXC1ZmMpatF05PJ" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="mitski.jpg" alt="Mitski" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Mitski</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Emotionally raw, soul-searching sound <br>with haunting beauty.</p>
			<a href="https://open.spotify.com/artist/2uYWxilOVlUdk4oV9DvwqK" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="zayn.jpg" alt="Zayn" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Zayn</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Smooth vocals and moody vibes <br>wrapped in stylish mystery.</p>
			<a href="https://open.spotify.com/artist/5ZsFI1h6hIdQRw2ti0hz81" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		</section>
        <h2 style="color: black; text-align: center;">Band</h2>
		<!-- Band Container -->
		<section style="margin-top: 20px; padding: 20px; width: 90%; background-color: rgba(201, 169, 215, 0.5); border-radius: 8px; margin-left: auto; margin-right: auto; overflow-x: auto; white-space: nowrap;">
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/blackpink.jpg" alt="Blackpink" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Blackpink</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>K-pop powerhouses with dazzling visuals<br> and global hits.</p>
			<a href="https://open.spotify.com/artist/41MozSoPIsD1dJM0CLPjZF" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/chase.jpg" alt="Chase Atlantic" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Chase Atlantic</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Genre-blending with hypnotic beats<br> and late-night energy.</p>
			<a href="https://open.spotify.com/artist/7cYEt1pqMgXJdq00hAwVpT" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/theneighborhood.jpg" alt="The Neighborhood" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">The Neighborhood</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Atmospheric alt-rock with moody melodies<br> and indie flair.</p>
			<a href="https://open.spotify.com/artist/77SW9BnxLY8rJ0RciFqkHh" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		  <div style="display: inline-block; text-align: center; margin-right: 20px;">
			<img src="images/arcticmonkeys.jpg" alt="Arctic Monkeys" style="width: 300px; height: auto; border-radius: 8px;">
			<h3 style="color: black;">Arctic Monkeys</h3>
			<p style="font-size: 14px; color: black; margin-top: 5px;">
			<p>Brit indie rock with sharp lyrics<br>and raw, energetic vibes.</p>
			<a href="https://open.spotify.com/artist/7Ln80lUS6He07XvHI8qqHH" target="_blank" title="Listen on Spotify" style="color: black; font-size: 50px;">
			  <i class="fab fa-spotify"></i>
			</a>
		  </div>
		</section>
    </main>
</body>
</html>
	