<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/navbar.css">

        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="topnav" id="myTopnav">
            <a href="home" class="nohover"><img src="assets/hospital.png" class="small"></a>
            <a href="home" class="<?php if ($active == 1) {echo "active";}?>">Clinică</a>
            <a href="medici" class="<?php if ($active == 2) {echo "active";}?>">Medici</a>
            <a href="medicamente" class="<?php if ($active == 3) {echo "active";}?>">Medicamente</a>
            <?php 
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo "Welcome to the member's area, " . htmlspecialchars($_SESSION['username']) . "!";
            } 
            else 
            {
                echo "<a href=\"javascript:void(0);\" class=\"right";
                if ($active == 9) {echo " active";};
                echo "\"";
                echo " onclick=\"document.getElementById('id01').style.display='none'\"";
                echo ">Autentificare</a>";
            }
            ?>
            
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>

        <div id="id01" class="modal">
  
            <form class="modal-content animate" action="/action_page.php" method="post">
                <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="img_avatar2.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                    
                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </form>
        </div>

        <script src="script/navbar.js"></script>
    </body>
</html>