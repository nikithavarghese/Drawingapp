
<?php
require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drawing Web App</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <div class="home-container">
  <div class="box">
    <h1>🎨 Welcome to Drawing App</h1>
     <br>
      <br>
      <?php if (is_logged_in()): ?>
        <div class="welcome-box">
          <p>Welcome back, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
          <div class="button-group">
            <button onclick="location.href='draw.php'">Start Drawing</button>
            <button onclick="location.href='view_drawing.php'">My Drawings</button>
            <button class="secondary" onclick="location.href='logout.php'">Logout</button>
          </div>
        </div>
      <?php else: ?>
        <div class="auth-options" >
          <div class="button-group">
          <button onclick="location.href='login.php'">Login</button>
            <button onclick="location.href='register.php'">Register</button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>