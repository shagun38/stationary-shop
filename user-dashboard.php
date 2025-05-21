<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$userSql = "SELECT * FROM users WHERE id = $userId";
$userResult = $conn->query($userSql);
$user = $userResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg bg-white border-bottom px-3">
  <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">

    <a class="navbar-brand fw-bold" href="home.php" style="color: #333;">Stationery Shop</a>

    <div class="collapse navbar-collapse justify-content-center" id="navCategories">
    <ul class="navbar-nav mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="product-category-writing.php">Writing Supplies</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-paper.php">Paper Products</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-art.php">Art & Craft</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-office.php">Office Essentials</a></li>
    </ul>
  </div>
  
    <div class="d-flex align-items-center gap-3 flex-wrap">

   
      <form method="GET" action="search.php" class="d-flex">
        <input class="form-control" type="search" name="query" placeholder="Search..." required>
      </form>

      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="admin.php" class="btn btn-warning btn-sm">Admin Panel</a>
      <?php endif; ?>

   
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

  
      <a href="cart.php" class="position-relative" title="Cart" aria-label="View Cart">
        <img src="images/cart-icon.ico" alt="Cart" width="28" height="28">
        <?php if (!empty($_SESSION['cart'])): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>
          </span>
        <?php endif; ?>
      </a>

   
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCategories"
              aria-controls="navCategories" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </div>
</nav>
</header>

<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p>You can update your profile details below.</p>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Profile updated successfully!</div>
    <?php endif; ?>

    <form action="update-profile.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
        <a href="contact.php" class="btn btn-outline-secondary mt-0 ms-2">Contact Support</a>

    </form>

    <hr class="my-5">

    <h4>Your Recent Orders</h4>
    <?php
    $orderQuery = "SELECT * FROM orders WHERE user_id = $userId ORDER BY created_at DESC";
    $orders = $conn->query($orderQuery);
    ?>

    <?php if ($orders->num_rows > 0): ?>
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Shipping To</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td>₹<?php echo number_format($order['total'], 2); ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($order['name']) . "<br>" . nl2br(htmlspecialchars($order['address'])); ?>
                            </td>

                            <td>
                                <ul class="mt-2 ms-2">
                                    <?php
                                    $orderId = $order['id'];
                                    $itemRes = $conn->query("SELECT * FROM order_items WHERE order_id = $orderId");
                                    while ($item = $itemRes->fetch_assoc()):
                                    ?>
                                        <li>
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                            x <?php echo $item['quantity']; ?>
                                            (₹<?php echo number_format($item['price'], 2); ?> each)
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="mt-3">You haven't placed any orders yet.</p>
    <?php endif; ?>

    <a href="home.php" class="btn btn-primary mt-4">Continue Shopping</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
