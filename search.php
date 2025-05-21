<?php
session_start();
include 'db.php';

$query = $_GET['query'] ?? '';
$escaped = $conn->real_escape_string($query);

$sql = "SELECT * FROM products 
        WHERE name LIKE '%$escaped%' OR description LIKE '%$escaped%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Search Results - Stationery Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>


<header>
<nav class="navbar navbar-expand-lg bg-white border-bottom px-3">
  <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">

    <!-- Logo -->
    <a class="navbar-brand fw-bold" href="home.php" style="color: #333;">Stationery Shop</a>

    <div class="collapse navbar-collapse justify-content-center" id="navCategories">
    <ul class="navbar-nav mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="product-category-writing.php">Writing Supplies</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-paper.php">Paper Products</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-art.php">Art & Craft</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-office.php">Office Essentials</a></li>
    </ul>
  </div>
    <!-- Right: Search + User + Cart + Toggle -->
    <div class="d-flex align-items-center gap-3 flex-wrap">

      <!-- Search -->
      <form method="GET" action="search.php" class="d-flex">
        <input class="form-control" type="search" name="query" placeholder="Search..." required>
      </form>

      <!-- Admin Panel -->
      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="admin.php" class="btn btn-warning btn-sm">Admin Panel</a>
      <?php endif; ?>

      <!-- User/Login -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown">
          <img src="images/user-icon.ico" alt="User" width="32" height="32"
               class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="user-dashboard.php">Dashboard</a></li>
            <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="login.php" title="Login" aria-label="Login">
          <img src="images/user-icon.ico" alt="Login" width="28" height="28">
        </a>
      <?php endif; ?>

      <!-- Cart -->
      <a href="cart.php" class="position-relative" title="Cart" aria-label="View Cart">
        <img src="images/cart-icon.ico" alt="Cart" width="28" height="28">
        <?php if (!empty($_SESSION['cart'])): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>
          </span>
        <?php endif; ?>
      </a>

      <!-- Hamburger Toggle for Categories -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCategories"
              aria-controls="navCategories" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </div>
</nav>
</header>

<!-- ✅ SEARCH RESULTS -->
<div class="container mt-5">
    <h2 class="mb-4">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>"
                        alt="<?php echo htmlspecialchars($row['name']); ?>"
                        class="card-img-top object-fit-contain"
                        style="height: 180px; width: 100%; padding: 10px; object-fit: contain;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text small"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="fw-bold mb-2">₹<?php echo number_format($row['price'], 2); ?></p>
                            <form method="POST" action="cart-handler.php" class="mt-auto">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4">No products found matching your search.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
