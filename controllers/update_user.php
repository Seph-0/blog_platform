<?php
    session_start();
    require '../includes/config.php';

    $id = $_SESSION['user_id'];
    $user_image = $_POST['user_image'] ?? "default_user.jpg";
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_stmt = $db_conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    

    if ($check_stmt->num_rows > 0) {
        echo "Email is already registered.";
    } else {
        $stmt = $db_conn->prepare("UPDATE users SET user_image = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $user_image, $first_name, $last_name, $email, $password, $id);
        if ($stmt->execute()) {
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['email'] = $email;
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
?>