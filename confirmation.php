<?php
require_once 'db_config.php';


require_login();
if (!isset($_GET['id']) || empty($_GET['id'])) 
{
    header("Location: draw.php");
    exit();
}
$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$drawingData = null;


$stmt = $conn->prepare("SELECT name, drawing_data FROM drawings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    $drawingData = $result->fetch_assoc();
} else {

    header("Location: draw.php");
    exit();
}
$stmt->close();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Drawing Saved - Drawing App</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <div class="navbar">
      <div class="nav-right">
          <a href="logout.php">Logout</a>
      </div>
  </div>
  <div class="container confirmation">
    <h2>Drawing Saved Successfully!</h2>
    <div class="confirmation-details">
      <p><strong>Name:</strong> <?= htmlspecialchars($drawingData['name']) ?></p>

      <h3>Your Drawing:</h3>
      <div class="drawing-container">
        <img src="data:image/png;base64,<?= base64_encode($drawingData['drawing_data']) ?>" alt="Your drawing" />
      </div>
    </div> 
    <div class="actions">
      <button onclick="location.href='draw.php'">Create New Drawing</button>
      <button onclick="location.href='view_drawing.php'">View All My Drawings</button>
    </div>
  </div>
</body>
</html>