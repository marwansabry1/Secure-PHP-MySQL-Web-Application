<?php include '../includes/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MKR Motors – New Cars</title>
  <link rel="stylesheet" href="../assets/css/styles.css">

</head>
<body>
  <?php include '../includes/header.php'; ?>
  <div class="hero hero-banner">
    <div class="hero-content">
      <h1>Ready for your next new car?</h1>
      <p>Browse the latest new arrivals with modern features, top safety ratings, and competitive pricing.</p>
    </div>
  </div>

 <main class="container-list">
  <aside class="sidebar">
    <h3>Filter / Sort</h3>

    <form method="GET" action="new-cars.php" class="filter-form">

      <div class="form-group">
        <label for="brand">Brand</label>
        <select name="brand" id="brand">
  <option value="" <?= empty($_GET['brand']) ? 'selected' : '' ?>>Any</option>
  <option value="Toyota" <?= (isset($_GET['brand']) && $_GET['brand'] == 'Toyota') ? 'selected' : '' ?>>Toyota</option>
  <option value="BMW" <?= (isset($_GET['brand']) && $_GET['brand'] == 'BMW') ? 'selected' : '' ?>>BMW</option>
  <option value="Tesla" <?= (isset($_GET['brand']) && $_GET['brand'] == 'Tesla') ? 'selected' : '' ?>>Tesla</option>
</select>

      </div>

      <div class="form-group">
        <label for="price">Price Range</label>
        <select name="price" id="price">
  <option value="" <?= empty($_GET['price']) ? 'selected' : '' ?>>Any</option>
  <option value="1" <?= (isset($_GET['price']) && $_GET['price'] == '1') ? 'selected' : '' ?>>Below €20,000</option>
  <option value="2" <?= (isset($_GET['price']) && $_GET['price'] == '2') ? 'selected' : '' ?>>€20,000 - €40,000</option>
  <option value="3" <?= (isset($_GET['price']) && $_GET['price'] == '3') ? 'selected' : '' ?>>Above €40,000</option>
</select>
      </div>

      <div class="form-group">
        <label for="fuel">Fuel Type</label>
        <select name="fuel" id="fuel">
  <option value="" <?= empty($_GET['fuel']) ? 'selected' : '' ?>>Any</option>
  <option value="Petrol" <?= (isset($_GET['fuel']) && $_GET['fuel'] == 'Petrol') ? 'selected' : '' ?>>Petrol</option>
  <option value="Diesel" <?= (isset($_GET['fuel']) && $_GET['fuel'] == 'Diesel') ? 'selected' : '' ?>>Diesel</option>
  <option value="Hybrid" <?= (isset($_GET['fuel']) && $_GET['fuel'] == 'Hybrid') ? 'selected' : '' ?>>Hybrid</option>
  <option value="Electric" <?= (isset($_GET['fuel']) && $_GET['fuel'] == 'Electric') ? 'selected' : '' ?>>Electric</option>
</select>

      </div>

      <button class="apply-btn">Apply Filter</button> <br/>
	  <br/>
	  <a href="new-cars.php" class="reset-btn">Reset</a>

	  

    </form>
  </aside>


    <section class="car-list">

      <?php
        // Build query with prepared statement
        $sql = "SELECT * FROM cars WHERE status = 'new'";
        $types = "";
        $params = array();
        
        // Validate and prepare brand filter
        $brand = trim($_GET['brand'] ?? '');
        if (!empty($brand) && strlen($brand) <= 50) {
          $sql .= " AND make = ?";
          $types .= "s";
          $params[] = &$brand;
        }
        
        // Validate and prepare price filter
        $price = trim($_GET['price'] ?? '');
        if (!empty($price) && in_array($price, ['1', '2', '3'])) {
          if ($price == 1) { $sql .= " AND price < 20000"; }
          elseif ($price == 2) { $sql .= " AND price BETWEEN 20000 AND 40000"; }
          elseif ($price == 3) { $sql .= " AND price > 40000"; }
        }
        
        // Validate and prepare fuel filter
        $fuel = trim($_GET['fuel'] ?? '');
        $validFuels = ['Petrol', 'Diesel', 'Hybrid', 'Electric'];
        if (!empty($fuel) && in_array($fuel, $validFuels)) {
          $sql .= " AND fuel_type = ?";
          $types .= "s";
          $params[] = &$fuel;
        }
        
        // Execute query with prepared statement
        $stmt = $conn->prepare($sql);
        if ($stmt) {
          if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
          }
          $stmt->execute();
          $result = $stmt->get_result();
          
          if ($result && $result->num_rows > 0) {
            while ($car = $result->fetch_assoc()) {
              $fuelDisplay = $car['fuel_type'] === 'Electric' 
                ? "<span style='color:green; font-weight:bold'>⚡" . htmlspecialchars($car['fuel_type']) . "</span>" 
                : htmlspecialchars($car['fuel_type']);
              
              echo "
                <article class='car-card'>
                  <div class='car-img'>
                    <img src='../assets/images/cars/" . htmlspecialchars($car['image']) . "' 
                         alt='" . htmlspecialchars($car['make'] . ' ' . $car['model']) . "'
                         style='max-width:100%; max-height:100%; border-radius:6px;'>
                  </div>

                  <div class='car-info'>
                    <h4>" . htmlspecialchars($car['make'] . ' ' . $car['model']) . "</h4>
                    <p>Year: " . htmlspecialchars($car['year']) . "</p>
                    <p>Licence Plate: " . htmlspecialchars($car['licence_plate']) . "</p>
                    <p>Fuel Type: {$fuelDisplay}</p>
                    <p>Price: €" . htmlspecialchars(number_format($car['price'])) . "</p>
                    <p>" . htmlspecialchars($car['description']) . "</p>
                  </div>

                  <a class='view' href='book-testdrive.php?car_id=" . htmlspecialchars($car['car_id']) . "'>
                    Book Test Drive
                  </a>
                </article>
              ";
            }
          } else {
            echo "<p>No new cars match your filters. Try adjusting your search.</p>";
          }
          $stmt->close();
        } else {
          echo "<p>Error retrieving cars. Please try again later.</p>";
        }
      ?>

    </section>
  </main>

  <footer class="footer">
    <div class="container footer-inner">
      <p>&copy; <span id="year"></span> MKR Motors. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.getElementById("year").textContent = new Date().getFullYear();
    });
  </script>
</body>
</html>
