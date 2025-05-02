<?php
require_once 'db_config.php';
require_login();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $drawingData = null;

    $stmt = $conn->prepare("SELECT name, drawing_data  FROM drawings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $drawingData = $result->fetch_assoc();
    } else {
    
        header("Location: view_drawing.php");
        exit();
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Drawing - Drawing App</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <div class="navbar">
      <div class="nav-right">
         
          <a href="logout.php">Logout</a>
      </div>
  </div>

  <div class="container">
    <h2>Viewing: <?= htmlspecialchars($drawingData['name']) ?></h2>
    <div class="drawing-details">
     
      
      <div class="drawing-container">
        <img src="data:image/png;base64,<?= base64_encode($drawingData['drawing_data']) ?>" alt="Your drawing" />
      </div>
    </div>
    
    <div class="actions">
      <button onclick="location.href='view_drawing.php'">Back to My Drawings</button>
      <button onclick="location.href='draw.php'">Create New Drawing</button>
    </div>
  </div>
</body>
</html>

<?php
} else {
   
    $user_id = $_SESSION['user_id'];
    $drawings = array();

    
    $stmt = $conn->prepare("SELECT id ,name FROM drawings WHERE user_id = ?"); 
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $drawings[] = $row;
        }
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Drawings - Drawing App</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  <style>
    .drawings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    .drawing-card {
      background: #fff;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }
    .drawing-card h3 {
      margin-top: 0;
      color: #00796b;
    }
    .drawing-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }
    .drawing-actions button {
      padding: 8px 15px;
      font-size: 12px;
    }
    .no-drawings {
      text-align: center;
      padding: 40px;
      background: #f9f9f9;
      border-radius: 8px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="navbar">
      <div class="nav-right">
          <a href="logout.php">Logout</a>
      </div>
  </div>

  <div class="container">
    <h2>My Drawings</h2>
    
    <?php if (empty($drawings)): ?>
      <div class="no-drawings">
        <p>You haven't created any drawings yet.</p>
        <button onclick="location.href='draw.php'">Create Your First Drawing</button>
      </div>
    <?php else: ?>
      <div class="drawings-grid">
        <?php foreach ($drawings as $drawing): ?>
          <div class="drawing-card">
            <h3><?= htmlspecialchars($drawing['name']) ?></h3>
            
            <div class="drawing-actions">
              <button onclick="location.href='view_drawing.php?id=<?= $drawing['id'] ?>'">View</button>
              <button onclick="if(confirm('Are you sure you want to delete this drawing?')) location.href='delete_drawing.php?id=<?= $drawing['id'] ?>'" style="background-color: #d32f2f;">Delete</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <div class="actions" style="margin-top: 30px;">
        <button onclick="location.href='draw.php'">Create New Drawing</button>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

<?php
}
?>