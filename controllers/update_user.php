<?php
session_start();
require '../includes/config.php';

$id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Get current image from DB
$query = $db_conn->prepare("SELECT user_image FROM users WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_image = $user['user_image'] ?? "default_user.jpg";

// Handle image upload
if (!empty($_FILES['user_image']['name'])) {
    $upload_dir = "../uploads/users/";
    $ext = strtolower(pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    if (in_array($ext, $allowed)) {
        $new_name = uniqid("user_") . "." . $ext;
        $target = $upload_dir . $new_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['user_image']['tmp_name'], $target)) {
            $user_image = $new_name;
        }
    }
}

// Check if email already exists for another user
$check_stmt = $db_conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$check_stmt->bind_param("si", $email, $id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "Email is already registered.";
    exit;
}

// Build SQL query depending on password update
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db_conn->prepare("UPDATE users SET user_image = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $user_image, $first_name, $last_name, $email, $hashed_password, $id);
} else {
    $stmt = $db_conn->prepare("UPDATE users SET user_image = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $user_image, $first_name, $last_name, $email, $id);
}

// Execute update
if ($stmt->execute()) {
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email'] = $email;
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$check_stmt->close();
$query->close();
?>
