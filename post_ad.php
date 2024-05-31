<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $conn = new mysqli('localhost', 'root', '', 'mysite');
    $stmt = $conn->prepare("INSERT INTO ads (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $user_id, $title, $description);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>