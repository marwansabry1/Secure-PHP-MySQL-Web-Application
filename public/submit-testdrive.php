<?php
include '../includes/connect.php';
include '../includes/csrf.php';

require_csrf();

// Retrieve and validate form data
$car_id = filter_var($_POST['car_id'] ?? '', FILTER_VALIDATE_INT);
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$preferred_date = trim($_POST['preferred_date'] ?? '');
$preferred_time = trim($_POST['preferred_time'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validate inputs
if (!$car_id || strlen($full_name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($preferred_date) || empty($preferred_time)) {
    die("Invalid form data. Please fill in all required fields correctly.");
}

// Insert into DB using prepared statement
$stmt = $conn->prepare("INSERT INTO test_drives (car_id, full_name, email, phone, preferred_date, preferred_time, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $car_id, $full_name, $email, $phone, $preferred_date, $preferred_time, $message);
$stmt->execute();
$stmt->close();

// Get car info using prepared statement
$carStmt = $conn->prepare("SELECT make, model, year FROM cars WHERE car_id = ?");
$carStmt->bind_param("i", $car_id);
$carStmt->execute();
$car_result = $carStmt->get_result();
$car = $car_result->fetch_assoc();
$carStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Drive Confirmed - MKR Motors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

<?php include '../includes/header.php'; ?>

<!-- CONFIRMATION SECTION -->
<section class="section section-alt">
  <div class="container">

    <h1>Your Test Drive is Booked!</h1>
    <p class="lead">
      Thank you, <strong><?php echo htmlspecialchars($full_name); ?></strong>.
      Your request has been successfully received. A member of our team will contact you soon.
    </p>

    <div class="form" style="margin-top: 2rem;">
      <h2>Booking Details</h2>

      <p><strong>Car:</strong> 
         <?php echo htmlspecialchars($car['year'] . " " . $car['make'] . " " . $car['model']); ?></p>

      <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
      <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone ?: "Not provided"); ?></p>

      <p><strong>Date:</strong> <?php echo htmlspecialchars($preferred_date); ?></p>
      <p><strong>Time:</strong> <?php echo htmlspecialchars($preferred_time); ?></p>

      <?php if (!empty($message)): ?>
        <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($message)); ?></p>
      <?php endif; ?>
    </div>

    <a href="index.php" class="btn btn-primary" style="margin-top: 20px; display:inline-block;">
      Return to Homepage
    </a>

  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container footer-inner">
    <p>&copy; <?php echo date("Y"); ?> MKR Motors. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
