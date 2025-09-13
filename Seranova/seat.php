<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "concert_ticketing_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$artist = "No Concert Selected";
$date = "";
$time = "";
$venue = "";
$image = "";
$artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 0;

if ($artist_id > 0) {
	$sql = "SELECT * FROM concert WHERE artist_id = $artist_id LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $artist = $row['artistname'];
        $date = $row['date'];
        $time = $row['time'];
        $venue = $row['venue'];
        $image = $row['image'];
    } else {
        $artist = "Concert Not Found";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SERANOVA</title>
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        body {
            background-color: #C9A9D7;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .top-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #2D3E49;
            border-bottom: 2px solid #ccc;
        }
        
        .top-panel img {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }

        .top-panel .info {
            flex: 1;
            margin-left: 20px;
        }

        .top-panel .info h2 {
            margin: 0;
            font-size: 1.5em;
            color: #fff;
        }

        .top-panel .info p {
            font-size: 1.1em;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Container for concert info and image -->
    <div class="container">
        <div id="concertInfoPanel" class="top-panel">
            <img id="concertImage" src="<?php echo htmlspecialchars($image); ?>" alt="Concert Image">
            <div class="info">
                <h2 id="concertInfoTitle"><?php echo htmlspecialchars($artist); ?></h2>
                <p id="concertInfo"><?php echo nl2br(htmlspecialchars("$date | $time\n$venue")); ?></p>
            </div>
        </div>
        
        <main style="display: flex; justify-content: center; align-items: center; gap: 40px;">
            <!-- Seating Map -->
            <div style="transform: translate(-20px, 20px);">
                <img src="images/map.png" alt="Stadium Seating Map" width="550">
            </div>

            <!-- Form -->
            <form id="seatForm">
                <table>
                    <tr>
                        <td><label for="numPeople">Number of People:</label></td>
                        <td><input type="number" id="numPeople" name="numPeople" min="1" max="10" required></td>
                    </tr>
                    <tr>
                        <td><label for="seatCategory">Select Seat Category:</label></td>
                        <td>
                            <select id="seatCategory" name="seatCategory" required>
                                <option value="the_star_club">THE "STAR CLUB" PREMIUM VIP PACKAGE</option>
                                <option value="the_early_entry">THE "EARLY ENTRY" FAN PACKAGE</option>
                                <option value="the_blur">THE BLUR</option>
                                <option value="cat_1_standing">CAT 1 (GA/FREE STANDING)</option>
                                <option value="cat_2">CAT 2</option>
                                <option value="cat_3">CAT 3</option>
                                <option value="cat_4">CAT 4</option>
                                <option value="cat_5">CAT 5</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="section">Select Section:</label></td>
                        <td>
                            <select id="section" name="section" required disabled>
                                <option value="">-- Select Category First --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sitTogether">Seated together?</label></td>
                        <td><input type="checkbox" id="sitTogether" name="sitTogether"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button type="submit">Submit</button>
                            <button type="reset">Reset</button>
                        </td>
                    </tr>
                </table>
            </form>
        </main>
    </div>

    <script>
        // Concert data from PHP injected here
        let artist = <?php echo json_encode($artist); ?>;
        let date = <?php echo json_encode($date); ?>;
        let time = <?php echo json_encode($time); ?>;
        let venue = <?php echo json_encode($venue); ?>;
        let image = <?php echo json_encode($image); ?>;
        let artist_id = <?php echo json_encode($artist_id); ?>;

        const categorySections = {
            "cat_2": ["305", "306", "307", "308", "317", "318", "319", "320"],
            "cat_3": ["301", "302", "303", "304","321","322"],
            "cat_4": ["405", "406", "407", "408", "416", "417", "418", "419"],
            "cat_5": ["401", "402", "403", "404", "420"]
        };

        const seatCategorySelect = document.getElementById("seatCategory");
        const sectionDropdown = document.getElementById("section");

        seatCategorySelect.addEventListener("change", function () {
            const selectedCategory = this.value;
            const sections = categorySections[selectedCategory] || [];
            sectionDropdown.innerHTML = "";

            if (sections.length === 0) {
                sectionDropdown.innerHTML = '<option value="">-- No Sections Available --</option>';
                sectionDropdown.disabled = true;
            } else {
                sectionDropdown.innerHTML = '<option value="">-- Select Section --</option>';
                sections.forEach(section => {																					
                    const option = document.createElement("option");
                    option.value = section;
                    option.textContent = `Section ${section}`;
                    sectionDropdown.appendChild(option);
                });
                sectionDropdown.disabled = false;
            }
        });

        seatCategorySelect.dispatchEvent(new Event("change"));

		document.getElementById("seatForm").addEventListener("submit", function (event) {
		  event.preventDefault();

		  const numPeople = parseInt(document.getElementById("numPeople").value);
		  const seatCategory = seatCategorySelect.value;
		  const seatCategoryText = seatCategorySelect.options[seatCategorySelect.selectedIndex].text;
		  const section = sectionDropdown.value;
		  const sitTogether = document.getElementById("sitTogether").checked;
		  const seatChoice = sitTogether ? "Sit Together" : "Separate";

		  const hasSections = categorySections.hasOwnProperty(seatCategory);
		  let url = `check_availability.php?category=${encodeURIComponent(seatCategory)}`;
		  if (hasSections) {
			url += `&section=${encodeURIComponent(section)}`;
		  }

		  fetch(url)
			.then(response => response.json())
			.then(data => {
			  console.log("Availability data:", data);
			  if (data.status !== 'success') {
				alert("Error checking seat availability: " + data.message);
				return;
			  }

			  const seatsLeft = parseInt(data.available);

			  if (seatsLeft <= 0) {
				alert("Sorry, no seats are available in this section. Please choose another section or category.");
				return;
			  }

			  if (numPeople > seatsLeft) {
				alert(`Only ${seatsLeft} seat(s) left in this section! Please choose fewer people or another section.`);
				return;
			  }

			  const seatPrices = {
				"the_star_club": 1588,
				"the_early_entry": 878,
				"the_blur": 788,
				"cat_1_standing": 598,
				"cat_2": 688,
				"cat_3": 498,
				"cat_4": 398,
				"cat_5": 298
			  };
			const seatPrice = seatPrices[seatCategory];
			const totalPrice = numPeople * seatPrice;

			localStorage.setItem("seatPrice", seatPrice);
			  localStorage.setItem("numPeople", numPeople);
			  localStorage.setItem("seatCategory", seatCategoryText);
			  localStorage.setItem("seatChoice", seatChoice);
			  localStorage.setItem("sitTogether", sitTogether ? "yes" : "no");
			  localStorage.setItem("totalPrice", totalPrice);
			  localStorage.setItem("section", section);
			  localStorage.setItem("artistName", artist);
			  localStorage.setItem("eventDate", date);
			  localStorage.setItem("eventTime", time);
			  localStorage.setItem("venue", venue);
			  localStorage.setItem("image", image);
			  localStorage.setItem("artist_id", artist_id);

			  window.location.href = "payment.html?artist_id=" + encodeURIComponent(artist_id);
			})
			.catch(error => {
			  alert("Failed to check seat availability. Please try again later.\nDetails: " + error.message);
			  console.error(error);
			});
		});
    </script>
</body>
</html>
