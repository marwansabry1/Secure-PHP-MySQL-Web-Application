<?php
include '../includes/connect.php';
include '../includes/csrf.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_csrf();

    // Input validation
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate inputs
    if (strlen($name) < 2) {
        $error = "Name must be at least 2 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
        $error = "Invalid phone number.";
    } else {
        // Check if email already exists using prepared statement
        $checkStmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $check = $checkStmt->get_result();

        if ($check->num_rows > 0) {
            // Existing customer → update phone/message
            $customer = $check->fetch_assoc();
            $id = $customer['customer_id'];

            $updateStmt = $conn->prepare("UPDATE customers SET name = ?, phone = ? WHERE customer_id = ?");
            $updateStmt->bind_param("ssi", $name, $phone, $id);
            $updateStmt->execute();
            $updateStmt->close();

            $success = "Your message was updated! Welcome back, " . htmlspecialchars($name) . ".";

        } else {
            // New customer → insert
            $insertStmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $name, $email, $phone);
            $insertStmt->execute();
            $insertStmt->close();

            $success = "Thank you! Your message has been submitted.";
        }
        $checkStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact MKR Motors</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body id="top">

<?php include '../includes/header.php'; ?>

<section class="section section-alt" id="contact">
  <div class="container">
    <h1>Contact MKR Motors</h1>
    <p class="lead">
      Get in touch with MKR Motors about any of our cars, finance options or opening hours.
    </p>

    <?php if ($success): ?>
      <p style="padding:10px; background:#d4edda; color:#155724; border-radius:5px;">
        <?= htmlspecialchars($success) ?>
      </p>
    <?php endif; ?>

    <?php if ($error): ?>
      <p style="padding:10px; background:#f8d7da; color:#721c24; border-radius:5px;">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <h2>Contact details</h2>
    <ul class="contact-list">
      <li><strong>Phone:</strong> +353 61 123 456</li>
      <li><strong>Email:</strong> info@mkrmotors.ie</li>
      <li><strong>Address:</strong> MKR Motors, Ireland</li>
    </ul>

    <h2>Become a customer!</h2>
    <p>Register here to hear about all the latest car deals and offers!</p>

    <form class="contact-form" action="contact.php" method="POST">

      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

      <div class="form-row">
        <label for="name">Your name</label>
        <input type="text" id="name" name="name" placeholder="John Smith" required>
      </div>

      <div class="form-row">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required>
      </div>

      <div class="form-row">
        <label for="phone">Contact number</label>
        <input type="tel" id="phone" name="phone" placeholder="+353 8X XXX XXXX">
      </div>

      <div class="form-row">
        <label for="message">Comment</label>
        <textarea id="message" name="message" rows="4" placeholder="Write your comment here..." required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Send message</button>
    </form>
  </div>
</section>

<footer class="footer">
  <div class="container footer-inner">
    <p>&copy; <span id="year"></span> MKR Motors. All rights reserved.</p>
  </div>
</footer>
<script src="../assets/js/form-validation.js"></script>

</body>
</html>
