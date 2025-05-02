<?php
require_once 'db_config.php';

$error = "";

// If user is already logged in, redirect to drawing page
if (is_logged_in()) {
    header("Location: draw.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM user_accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                
                header("Location: draw.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Drawing App</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login to Drawing App</h2>
        <?php if(!empty($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-actions">
                <input type="submit" value="Login">
            </div>
        </form>
        
        <p><a href="register.php">Register here</a></p>
        
        <div class="actions">
            <button onclick="location.href='index.php'">Back to Home</button>
        </div>
    </div>
</body>
</html>