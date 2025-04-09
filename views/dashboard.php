<?php
    require '../includes/config.php';
    session_start();
    include '../includes/header.php';
    include '../includes/navbar.php';

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
    <div class="container px-4">
        <div class="d-flex align-items-center justify-content-center my-4 px-4">
            <div class="col-8">
                <div class="card w-100">
                    <div class="card-body">
                        <form action="">
                            <div class="form-group d-flex align-items-center gap-3 mb-3">
                                <img src="../uploads/users/<?php echo $user['user_image'] ?? "default_user.jpg" ?>" height="50" width="50" class="rounded-circle" alt="">
                                <textarea name="post" id="create_post" class="form-control" placeholder="Write something..."></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <!--<button type="submit" class="btn btn-primary ">Post</button>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
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
