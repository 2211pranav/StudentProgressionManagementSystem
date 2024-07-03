<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Login & Registration</title>
</head>
<body>
    
 <div class="wrapper">
    
    <div class="form-box">
        <img src="logo (2).png" alt="">
   
        <!------------------- login form -------------------------->

        <form action="login.php" method="post">
            <div class="login-container" id="login">
                <div class="top">
                    
                    <header>Login</header>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Username or Email" name="Email">
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" placeholder="Password" name="password">
                    <i class="bx bx-lock-alt bx-low-vision"></i>
                    <i id="bx bx-low-vision"></i>
                </div>
                <form action="home.php" method="POST">
                <div class="input-box">
                    <input type="submit" class="submit" value="Sign In" name="submit">
                    
                </div>
                </form>
                <div class="two-col">
                    <div class="one">
                        <input type="checkbox" id="login-check">
                        <label for="login-check"> Remember Me</label>
                    </div>
                    <div class="two">
                        <label><a href="#">Forgot password?</a></label>
                    </div>
                </div>
            </div>
        </form>
        
      
        
<script src="script.js"></script>
</body>
</html>