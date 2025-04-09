<?php
    require '../includes/config.php';
    include '../includes/header.php';

    $userId = $_SESSION['user_id'];

    $stmt = $db_conn->prepare("SELECT user_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header >
        <nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container">
                <a class="navbar-brand fw-bold" href="../views/dashboard.php">Blog Platform</a>
              
                <ul class="navbar-nav">
                    <div class="dropdown ">
                        <a class="btn dropdown-toggle " id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../uploads/users/<?php echo $user['user_image'] ?? 'default_user.jpg'; ?>" alt="User Image" height="45" width="45" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu px-0" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="../views/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="../views/user_profile.php">Profile</a></li>
                            <li><a class="dropdown-item" id="logout-btn" href="#">Logout</a></li>
                        </ul>
                    </div>
                </ul>
            </div>
        </nav>
    </header>
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