<?php
include '../includes/connect.php';

$make = trim($_GET['make'] ?? '');
$model = trim($_GET['model'] ?? '');
$condition = trim($_GET['condition'] ?? '');

// Build query with prepared statement
$sql = "SELECT * FROM cars WHERE 1=1";
$types = "";
$params = array();

if ($make !== '') {
    $sql .= " AND make = ?";
    $types .= "s";
    $params[] = &$make;
}

if ($model !== '') {
    $sql .= " AND model = ?";
    $types .= "s";
    $params[] = &$model;
}

if ($condition !== '') {
    $sql .= " AND status = ?";
    $types .= "s";
    $params[] = &$condition;
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Results - MKR Motors</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

  <?php include '../includes/header.php'; ?>
<section class="section">
  <div class="container">
    <h1>Search Results</h1>

    <?php if (mysqli_num_rows($result) === 0): ?>
      <p>No cars match your search.</p>

    <?php else: ?>
      <div class="car-grid">

        <?php while ($car = mysqli_fetch_assoc($result)): ?>

        <?php 
            // Fuel color highlight
           $fuelDisplay = $car['fuel_type'] === 'Electric' 
			? "<span style='color:green; font-weight:bold'>⚡" . htmlspecialchars($car['fuel_type']) . "</span>" 
			: htmlspecialchars($car['fuel_type']);
        ?>

        <div class="featured-card">

          <div class="car-img">
            <img src="../assets/images/cars/<?php echo htmlspecialchars($car['image']); ?>" 
                 alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>">
          </div>

          <div class="car-info">
            <h4><?php echo htmlspecialchars($car['make'] . " " . $car['model']); ?></h4>
            <p>Year: <?php echo htmlspecialchars($car['year']); ?></p>
            <p>Licence Plate: <?php echo htmlspecialchars($car['licence_plate']); ?></p>
            <p>Fuel Type: <?php echo $fuelDisplay; ?></p>
            <p>Price: €<?php echo htmlspecialchars($car['price']); ?></p>
            <p><?php echo htmlspecialchars($car['description']); ?></p>
          </div>

          <a href="book-testdrive.php?car_id=<?php echo htmlspecialchars($car['car_id']); ?>" class="btn btn-primary">
            Book Test Drive
          </a>

        </div>

        <?php endwhile; ?>

      </div>
    <?php endif; ?>

  </div>
</section>

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
