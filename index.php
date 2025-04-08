    <?php
        require 'config.php';
        include 'header.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog Platform | Login</title>
    </head>
    <body>
        <div class="container d-flex justify-content-end align-items-center vh-100">
            <div class="px-4 py-2" id="login_modal">
                <h2 class="text-center">Login</h2>
                <form action="" id="login_form">
                    <div class="form-group mb-3">
                        <label for="login-email">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="login-password">Password</label>
                        <input type="password" class="form-control " id="login-password" name="password" required>
                        <div class="">
                            <input class="" type="checkbox" value="" id="remember-me">
                            <label class="" for="remember-me">Remember me</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mb-3 w-100">Login</button>
                        <div class="col text-center">
                            <p>Don't have an account yet? <a href="#" id="register-btn">Register</a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" px-4 py-2 d-none" id="register_modal">
                <h2 class="text-center">Register</h2>
                <form action="" id="register_form" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="form-group col-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="register-email">Email</label>
                        <input type="email" class="form-control" id="register-email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="register-password">Password</label>
                        <input type="password" class="form-control" id="register-password" name="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mb-3 w-100">Register</button>
                        <div class="col text-center">
                            <p>Already have an account? <a href="#" id="login-btn">Login</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#register-btn').click(function() {
                    $('#login_modal').addClass('d-none');
                    $('#register_modal').removeClass('d-none');
                });

                $('#login-btn').click(function() {
                    $('#register_modal').addClass('d-none');
                    $('#login_modal').removeClass('d-none');
                });

                $('#register_form').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'handle_register.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            alert('Registration successful!');
                            $('#register_modal').addClass('d-none');
                            $('#login_modal').removeClass('d-none');
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                });

                $('#login_form').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'handle_login.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response.trim() === "success") {
                                window.location.href = 'dashboard.php'; 
                            } else {
                                alert(response); 
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                })
            });


        </script>
    </body>
    </html>
