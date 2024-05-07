<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clinică medicală</title>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link rel="icon" href="./assets/favicon/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <main>
        <h1>MASE</h1>

        <br>

        <!-- Button to open the modal login form -->
        <button onclick="document.getElementById('id01').style.display='block'" class="genericbtn">Login</button>

        <!-- The Modal -->
        <div id="id01" class="modal">
          <span onclick="document.getElementById('id01').style.display='none'"
        class="close" title="Close Modal">&times;</span>

          <!-- Modal Content -->
          <form class="modal-content animate" action="/action_page.php">
            <div class="imgcontainer">
              <img src="./assets/avatar.png" alt="Avatar" class="avatar">
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

            <div class="container">
              <div style="text-align: center;">
                <span style="font-weight: bold;">Not registered?</span>
                <span style=""><a href="#">Create an account!</a></span>
              </div>
            </div>

            <div class="container" style="background-color:#f1f1f1">
              <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
              <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
          </form>
        </div>

    </main>
	<script src="script.js"></script>
  </body>
</html>