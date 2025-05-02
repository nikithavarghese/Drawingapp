<?php
require_once 'db_config.php';


require_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['drawing_name'];
    $imageData = $_POST['canvasImage'];
    $user_id = $_SESSION['user_id'];

    if (empty($name))
    {
        $error = "Drawing name is required.";
    } else {

        $imageData = explode(',', $imageData)[1];
        $imageData = base64_decode($imageData);


        $stmt = $conn->prepare("INSERT INTO drawings (user_id, name, drawing_data) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $name, $imageData);
        $stmt->send_long_data(2, $imageData);
        
        if ($stmt->execute()) {
            $lastId = $conn->insert_id;
            
            header("Location: confirmation.php?id=" . $lastId);
            exit();
        } else {
            $error = "Error saving your drawing. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Draw - Drawing App</title>
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
        <h2>Create a New Drawing</h2>
        <?php if(isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <form method="post" onsubmit="return captureCanvas()">
          <div class="form-group">
              <label for="drawing_name">Drawing Name:</label>
              <input type="text" id="drawing_name" name="drawing_name" required>
          </div>

          <div class="form-group">
              <label for="shape">Select Shape:</label>
              <select id="shape">
                <option value="line">Line</option>
                <option value="rectangle">Rectangle</option>
                <option value="square">Square</option>
                <option value="circle">Circle</option>
                <option value="triangle">Triangle</option>
              </select>
            
              <label for="color">Color:</label>
              <input type="color" id="color" value="#00796b">
          </div>
          
          <div class="canvas-controls">
              <button type="button" onclick="clearCanvas()">Clear</button>
              <button type="button" onclick="undo()">Undo</button>
          </div>
          
          <canvas id="myCanvas" width="800" height="400"></canvas>
          
          <input type="hidden" name="canvasImage" id="canvasImage">
          <div class="form-actions">
              <input type="submit" value="Save Drawing">
              <button type="button" onclick="location.href='view_drawing.php'">View My Drawings</button>
          </div>
        </form>
    </div>

    <script src="script.js"></script>
    <script>
      function captureCanvas() 
      {
        const canvas = document.getElementById("myCanvas");
        const dataURL = canvas.toDataURL("image/png");
        document.getElementById("canvasImage").value = dataURL;
        return true;
      }
    </script>
</body>
</html>
