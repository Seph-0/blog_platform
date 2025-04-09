<?php
    session_start();
    require '../includes/config.php';
    include '../includes/header.php';
    
    $userId = $_SESSION['user_id'];

    $stmt = $db_conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
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
</head>
<body>
    <div class="container vh-100">
        <div class="px-4 py-2" id="user_profile_modal">
            <h2>User Profile</h2>
            <div class="row mb-3">
                <div class="col-1">
                    <img src="../assets/<?php echo $_SESSION['user_image']  ?? "default_user.jpg"; ?>" class="rounded-circle" height="75" width="75" alt="">
                </div>
                <div class="col-9 d-flex flex-column justify-content-center">
                    <h5 class="mb-0"><?php echo $user['first_name'] . " " . $user['last_name']; ?></h5>
                    <p class="mb-0"><?php echo $user['email']; ?></p>
                </div>
                <div class="col-2">
                    <div class="d-flex flex-column">
                        <button id="edit_user_btn" class="btn btn-warning mb-2">Edit Profile</button>
                        <button id="delete_user_btn" class="btn btn-danger">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-2 d-none" id="edit_user_modal">
            <h2 class="">Edit User</h2>
            <form action="" id="edit_user_form" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-1">
                        <img src="../assets/default_user.jpg" class="rounded-circle" height="75" width="75" alt="">
                    </div>
                    <div class="form-group col-4">
                        <input type="file" class="form-control mt-2" id="user_image" name="user_image" accept="image/*" >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                        value="<?php echo $user['last_name']; ?>" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="register-email">Email</label>
                    <input type="email" class="form-control" id="register-email" name="email"
                    value="<?php echo $user['email'] ?? ''; ?>" required>
                    <div id="email-error" class="text-danger mb-2 d-none" ></div>
                </div>
                <div class="form-group mb-3">
                    <label for="update-password">Password</label>
                    <input type="password" class="form-control" id="update-password" name="password">
                    <div id="password-error" class="text-danger mb-2 d-none" ></div>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm-update-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-update-password" name="confirm_password" >
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning mb-3 w-100">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#edit_user_btn').click(function() {
                $('#user_profile_modal').addClass('d-none');
                $('#edit_user_modal').removeClass('d-none');
            });
            $('#edit_user_form').submit(function(e) {
                e.preventDefault();
                if($('#update-password').val() === $('#confirm-update-password').val()) {
                    $.ajax({
                        url: '../controllers/update_user.php',
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if(response.trim() === "success") {
                                alert("User updated successfully!");
                                window.location.href = "dashboard.php";
                            } else {
                                alert(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#password-error').text("Passwords do not match.").removeClass('d-none').show();
                }
            });
            $('#delete_user_btn').click(function() {
                    $.ajax({
                    url: '../controllers/delete_user.php',
                    type: 'POST',
                    success: function(response) {
                        if(response.trim() === "success") {
                            alert("User deleted successfully!");
                            window.location.href = "../index.php";
                        } else {
                            alert(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>