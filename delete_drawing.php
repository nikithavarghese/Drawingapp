<?php
require_once 'db_config.php';

require_login();

if (!isset($_GET['id']) || empty($_GET['id'])) 
{
    header("Location: view_drawing.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM drawings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

header("Location: view_drawing.php");
exit();
?>