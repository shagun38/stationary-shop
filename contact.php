<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stationery Shop</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shop high-quality stationery, office supplies, and creative tools at our online store.">
    <meta name="keywords" content="stationery, office supplies, art tools, paper, pens, markers">
    <meta name="author" content="Your Brand Name">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
</head>
<body>
<div class="container mt-5">
  <h2>Contact Us</h2>
  <p>If you have any questions or concerns, feel free to reach out using the form below.</p>

  <form action="contact-handler.php" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Your Name</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Your Email</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="message" class="form-label">Message</label>
      <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Send Message</button>
  </form>
</div>
</body>
</html>
