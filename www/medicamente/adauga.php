<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Clinică medicală</title>

    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <link rel="stylesheet" type="text/css" href="/style/register.css">
    <link rel="icon" href="/assets/favicon/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap 5 JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  </head>
  <body>
    <?php 
    if (session_id() == "")
      session_start();
    
    $active = 3;

    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$rootDir/persistentlogin.php";
    
    include "$rootDir/navbar.php";
    
    ?>

    <div class="container mt-4">
      <?php 
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && !strcmp($_SESSION["userType"], "medic")) {
      ?>
      <div class="card-body p-md-5">
          <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Adăugare medicamente</p>

              <form action="/medicamente/adauga/submit" method="post" id="medicamentForm" role="form">

                <div class="form-group mt-2"> 	 
                  <label for="denumire">Denumire: </label>
                  <input class="form-control" type="text" name="denumire" id = "denumire" onkeyup="checkDenumire();" onfocus="checkDenumire();" required /> 
                  <span id="errDenumire"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="descriere">Descriere: </label>
                  <input class="form-control" type="text" name="descriere" id = "descriere" onkeyup="checkDescriere();" onfocus="checkDescriere();" required /> 
                  <span id="errDescriere"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="prospect">Prospect: </label>
                  <input class="form-control" type="text" name="prospect" id = "prospect" onkeyup="checkProspect();" onfocus="checkProspect();" required /> 
                  <span id="errProspect"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="pret">Pret: </label>
                  <input class="form-control" type="text" name="pret" id = "pret" onkeyup="checkPret();" onfocus="checkPret();" required /> 
                  <span id="errPret"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="nume_farmacie">Nume farmacie: </label>
                  <input class="form-control" type="text" name="nume_farmacie" id = "nume_farmacie" onkeyup="checkNumeFarmacie();" onfocus="checkNumeFarmacie();" required /> 
                  <span id="errNumeFarmacie"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="stoc">Stoc: </label>
                  <input class="form-control" type="text" name="stoc" id = "stoc" inputmode="numeric" onkeyup="checkStoc();" onfocus="checkStoc();" required /> 
                  <span id="errStoc"></span>
                </div>

                <div class="form-group mt-4 d-flex justify-content-center">
                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg" onclick="registerClicked();">Adaugă</button>
                </div>
              </form>
          </div>
        </div>
      </div>
      <?php
      }
      else {
        echo "Nu sunteți logat cu un cont de medic!";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=/home\">";
      }
      ?>
    </div>
    
    <script src="/script/script.js"></script>
    <script src="/script/medicamente.js"></script>
    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>
    
  </body>
</html>