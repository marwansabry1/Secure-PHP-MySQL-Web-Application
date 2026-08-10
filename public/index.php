<?php include '../includes/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MKR Motors - Car Dealership</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body id="top">

  <?php include '../includes/header.php'; ?>

  <!-- HERO -->
  <section class="hero" id="home">
    <div class="hero-overlay"></div>

    <!-- Image slides -->
    <div class="hero-slide hero-1 active"></div>
    <div class="hero-slide hero-2"></div>
    <div class="hero-slide hero-3"></div>

    <div class="hero-content">
      <h1>Find Your Next Car with MKR Motors</h1>
      <p>
        Quality used and new cars with clear pricing and friendly support.
        Information is explained in simple language so it is easier to compare options.
      </p>

      <div class="hero-buttons">
        <a href="new-cars.php" class="btn btn-primary">Browse New Cars</a>
        <a href="preowned-cars.php" class="btn btn-secondary">Browse Pre-Owned Cars</a>
      </div>
    </div>
  </section>
 <!-- ADVANCED SEARCH -->
<section class="section section-alt">
  <div class="container">
    <h2>Find a Car</h2>

    <form action="search-results.php" method="GET" class="filter-form">

      <!-- MAKE -->
      <select name="make" class="filter-select">
        <option value="">Any Make</option>
        <?php
          $makesStmt = $conn->prepare("SELECT DISTINCT make FROM cars ORDER BY make ASC");
          if ($makesStmt) {
            $makesStmt->execute();
            $makes = $makesStmt->get_result();
            while ($row = $makes->fetch_assoc()) {
              echo "<option value='" . htmlspecialchars($row['make']) . "'>" . htmlspecialchars($row['make']) . "</option>";
            }
            $makesStmt->close();
          }
        ?>
      </select>

      <!-- MODEL -->
      <select name="model" class="filter-select">
        <option value="">Any Model</option>
        <?php
          $modelsStmt = $conn->prepare("SELECT DISTINCT model FROM cars ORDER BY model ASC");
          if ($modelsStmt) {
            $modelsStmt->execute();
            $models = $modelsStmt->get_result();
            while ($row = $models->fetch_assoc()) {
              echo "<option value='" . htmlspecialchars($row['model']) . "'>" . htmlspecialchars($row['model']) . "</option>";
            }
            $modelsStmt->close();
          }
        ?>
      </select>

      <!-- CONDITION -->
      <select name="condition" class="filter-select">
        <option value="">Any Condition</option>
        <option value="New">New</option>
        <option value="Pre-Owned">Pre-Owned</option>
      </select>

      <!-- SUBMIT -->
      <button type="submit" class="btn btn-primary">Search Cars</button>
    </form>
  </div>
</section>
<!-- FEATURED CARS -->
<section class="section">
  <div class="container">
    <h2>Featured Cars</h2>

    <div class="featured-cars-grid">

      <?php
      $stmt = $conn->prepare("SELECT * FROM cars ORDER BY RAND() LIMIT 3");
      if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
          while ($car = $result->fetch_assoc()) :
      ?>
      
        <div class="featured-card">
          <img src="../assets/images/cars/<?php echo htmlspecialchars($car['image']); ?>"
     alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>">

          <h3>
            <?php echo htmlspecialchars($car['year'] . " " . $car['make'] . " " . $car['model']); ?>
          </h3>

          <p class="price">€<?php echo htmlspecialchars(number_format($car['price'])); ?></p>

          <a href="book-testdrive.php?car_id=<?php echo htmlspecialchars($car['car_id']); ?>" class="btn btn-primary">
            Book Test Drive
          </a>
        </div>

      <?php endwhile;
        }
        $stmt->close();
      } else {
        echo "<p>Unable to load featured cars. Please try again later.</p>";
      } ?>

    </div>
  </div>
</section>



  <!-- WHY CHOOSE US -->
  <section class="section section-alt">
    <div class="container">
      <h2>Why Choose MKR Motors?</h2>
      <p class="lead">
        MKR Motors is a local dealership that focuses on clear and honest communication.
        Cars are checked before we advertise them and we share the basic history,
        so customers can feel more confident about their choice.
      </p>
      <ul class="feature-list">
        <li>Carefully inspected cars with history information</li>
        <li>Simple, transparent pricing — no hidden fees</li>
        <li>Friendly team, no pressure selling</li>
      </ul>
    </div>
  </section>


  <!-- SERVICES -->
  <section class="section">
    <div class="container">
      <h2>Our Services</h2>
      <p class="lead">
        We support customers with buying, selling and trading in cars.
        For many people, buying a car is a big decision, so we keep the process simple.
      </p>

      <ul class="feature-list">
        <li>Car sales (new & used)</li>
        <li>Trade-in valuations</li>
        <li>Finance guidance</li>
      </ul>
    </div>
  </section>


  <!-- TEST DRIVE SECTION -->
  <section class="section" id="testdrive">  
    <div class="container">
      <h1>Book a Test Drive</h1>
      <p class="lead">
        You can book a test drive from any car listing.
        Choose a car from our inventory, then click the
        <strong>"Book Test Drive"</strong> button.
      </p>

      
    </div>
  </section>


  


  <!-- FOOTER -->
  <footer class="footer">
    <div class="container footer-inner">
      <p>&copy; <span id="year"></span> MKR Motors. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS (HERO SLIDER ONLY) -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const yearSpan = document.getElementById("year");
      yearSpan.textContent = new Date().getFullYear();

      const slides = document.querySelectorAll(".hero-slide");
      let currentSlide = 0;

      function showSlide(index) {
        slides.forEach((slide, i) =>
          slide.classList.toggle("active", i === index)
        );
      }

      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }

      setInterval(nextSlide, 5000);
    });
  </script>

</body>
</html>
