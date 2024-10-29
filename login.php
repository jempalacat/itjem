<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICORDS</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="login">
        <div class="center-right">
            <br><br><br><br><br><br><br>
            <h1><strong>LOG IN HERE!</strong></h1>
            <form action="login_handler.php" method="POST">

                <div class="inputBox">
                    <input type="text" name="email" id="email" placeholder="Email" required>  
                </div>

                <div class="inputBox">
                    <input type="password" name="password" id="password" placeholder="Password"  required>
                </div>

                <div class="fp">
                    <a href="forget_pass.php"><strong>Forgot Password?</strong></a>
                </div>

                <div class="inputBox">
                    <input type="submit" name="submit" value="Login" id="btn" required>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
