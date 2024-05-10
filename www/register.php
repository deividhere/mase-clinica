<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Clinică medicală</title>

    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link rel="stylesheet" type="text/css" href="./style/register.css">
    <link rel="icon" href="./assets/favicon/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap 5 JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  </head>
  <body>
    <?php 
    session_start();
    $active = 9;
    include 'navbar.php';
    ?>

    <div class="container mt-4">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form action="" method="post" id="fileForm" role="form">

                  <div class="form-group"> 	 
                    <label for="firstname"><span class="req">* </span> First name: </label>
                    <input class="form-control" type="text" name="firstname" id = "firstname" onkeyup = "Validate(this)" required /> 
                    <div id="errFirst"></div>
                  </div>

                  <div class="form-group">
                    <label for="lastname"><span class="req">* </span> Last name: </label> 
                    <input class="form-control" type="text" name="lastname" id = "lastname" onkeyup = "Validate(this)" placeholder="hyphen or single quote OK" required />  
                      <div id="errLast"></div>
                  </div>

                  <div class="form-group">
                    <label for="email"><span class="req">* </span> Email Address: </label> 
                    <input class="form-control" required type="text" name="email" id = "email"  onchange="email_validate(this.value);" />   
                    <div class="status" id="status"></div>
                  </div>

                  <div class="form-group">
                    <label for="pass1"><span class="req">* </span> Password: </label>
                    <input required name="pass1" type="password" class="form-control inputpass" minlength="4" maxlength="16"  id="pass1" /> </p>

                    <label for="pass2"><span class="req">* </span> Password Confirm: </label>
                    <input required name="pass2" type="password" class="form-control inputpass" minlength="4" maxlength="16" placeholder="Enter again to validate"  id="pass2" onkeyup="checkPass(); return false;" />
                    <span id="confirmMessage" class="confirmMessage"></span>
                  </div>

                  <div class="form-group">
                  
                      <?php //$date_entered = date('m/d/Y H:i:s'); ?>
                      <input type="hidden" value="<?php //echo $date_entered; ?>" name="dateregistered">
                      <input type="hidden" value="0" name="activate" />
                      <hr>

                      <input type="checkbox" required name="terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" id="terms">   
                      <label for="terms">
                        <!-- I agree with the <a href="terms.php" title="You may read our terms and conditions by clicking on this link">terms and conditions</a> for Registration. -->
                        I agree all statements in <a href="#!">Terms of service</a>
                      </label>

                  </div>

                  <div class="form-group mt-2 d-flex align-items-center">
                    <!-- <input class="btn btn-success" type="submit" name="submit_reg" value="Register"> -->
                    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" onclick="register_click()">Register</button>
                  </div>

                  </fieldset>
                </form>

                <!-- <form class="mx-1 mx-md-4">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fa fa-user fa-lg me-3 fa-fw mt-4"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <label class="form-label" for="name">Your Name</label>
                      <input type="text" id="name" class="form-control" />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fa fa-envelope fa-lg me-3 fa-fw mt-4"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <label class="form-label" for="email">Your Email</label>
                      <input type="email" id="email" class="form-control" />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fa fa-eye fa-lg me-3 fa-fw mt-4"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <label class="form-label" for="pass">Password</label>
                      <input type="password" name="pass" id="pass" required="required" class="form-control" oninput="check_pass()"/>
                      <i class="fa fa-eye" id="togglePassword"></i>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-5">
                    <i class="fa fa-eye fa-lg me-3 fa-fw mt-4"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <label class="form-label" for="pass2">Repeat your password</label>
                      <input type="password" name="pass2" id="pass2" required="required" class="form-control" oninput="check_pass()"/>
                    </div>
                  </div>

                  <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="agree" />
                    <label class="form-check-label" for="agree">
                      I agree all statements in <a href="#!">Terms of service</a>
                    </label>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Register</button>
                  </div>

                </form> -->

              </div>
              <!-- <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                  class="img-fluid" alt="Sample image">

              </div> -->
            </div>
          </div>
    </div>
    
    <script src="./script/script.js"></script>
    <script src="./script/register.js"></script>
    <script type="text/javascript">
      document.getElementById("terms").setCustomValidity("Please indicate that you accept the Terms and Conditions");
    </script>
  </body>
</html>