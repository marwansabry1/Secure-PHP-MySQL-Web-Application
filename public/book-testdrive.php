<?php
include '../includes/connect.php';
include '../includes/csrf.php';

// Validate car_id
$car_id = filter_var($_GET['car_id'] ?? '', FILTER_VALIDATE_INT);
if (!$car_id) {
    die("Invalid car selected.");
}

// Get car info using prepared statement
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();
$stmt->close();

if (!$car) {
    die("Car not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Test Drive - MKR Motors</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
  <?php include '../includes/header.php'; ?>


<div class="form-container">
    <h2>Book a Test Drive for <br>
        <strong><?php echo htmlspecialchars($car['year'] . " " . $car['make'] . " " . $car['model']); ?></strong>
    </h2>

    <form action="submit-testdrive.php" method="POST">

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

        <!-- Hidden car_id -->
        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['car_id']); ?>">

        <div class="form-row">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>

        <div class="form-row">
            <label>Email Address</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-row">
            <label>Phone Number</label>
            <input type="text" name="phone">
        </div>

        <div class="form-row">
            <label>Preferred Date</label>
            <input type="date" name="preferred_date" required>
        </div>

        <div class="form-row">
            <label>Preferred Time</label>
            <input type="time" name="preferred_time" required>
        </div>

        <div class="form-row">
            <label>Message (optional)</label>
            <textarea name="message" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>

</body>
</html>
