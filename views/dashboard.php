<?php
    require '../includes/config.php';
    session_start();
    include '../includes/header.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
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
    <h1>Hello <?php echo $_SESSION['first_name']; ?></h1>
    <a href="edit_user.php">Edit user</a>
    <a href="../controllers/logout.php" id="logout-btn">Logout</a>
    <script>
        $(document).ready(function() {
            $('#logout-btn').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '../controllers/handle_logout.php',
                    type: 'POST',
                    success: function(response) {
                        window.location.href = '../index.php';
                    }
                });
            });
        });
    </script>
</body>
</html>