<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $db_conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    session_destroy();
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$db_conn->close();

?>