<?php
    require 'config.php';
    session_start();
    include 'header.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello World</h1>
    <a href="edit_user.php">Edit user</a>
</body>
</html>