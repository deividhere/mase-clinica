<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Clinică medicală</title>

    <link rel="stylesheet" type="text/css" href="/style/style.css">
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
    
    $active = 9;
    
    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$rootDir/persistentlogin.php";
    
    include "$rootDir/navbar.php";
    
    ?>

    <div class="container mt-4">
      <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

          // Initialize SQL fields
          $servername = "localhost";
          $username = "root";
          $password = "";
          $database = "clinica";

          // Display errors
          ini_set('display_errors', '1');
          ini_set('display_startup_errors', '1');
          error_reporting(E_ALL);
          mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

          // Create connection
          $mysqli = new mysqli($servername, $username, $password, $database);

          // Check connection
          if ($mysqli->connect_error) {
            die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
          }

          $userId = $_SESSION["userid"];
          $userType = $_SESSION["userType"];
          $email = $_SESSION["email"];
          $nume = $_SESSION["nume"];
          $prenume = $_SESSION["prenume"];
          $sql = null;

          if (!strcmp($userType, "medic")) {
            $sql = "SELECT * FROM medici WHERE idmedic = $userId";
          }
          else if (!strcmp($userType, "pacient")) {
            $sql = "SELECT * FROM pacienti WHERE idpacient = $userId";
          }
          else {
            die("Tipul de utilizator nu este cunoscut.");
          }

          $stmt = $mysqli->prepare($sql);

          $stmt->execute();

          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            // user was found
            $row = mysqli_fetch_assoc($result);

            ?>
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Detalii cont</p>
                  <div class="form-group">
                    <p>Tip cont: </p>

                    <div class="mt-1 d-flex justify-content-center gap-2">
                      <button class="btn btn-success" style="pointer-events: none;" > <?php echo ucfirst($userType); ?> </label>
                    </div>
                  </div>

                  <div class="form-group mt-2"> 	 
                    <label for="firstname">Prenume: </label>
                    <input class="form-control" type="text" readonly value="<?php echo $prenume; ?>" /> 
                  </div>

                  <div class="form-group mt-2">
                    <label for="lastname">Nume: </label> 
                    <input class="form-control" type="text" readonly value="<?php echo $nume; ?>" />  
                  </div>

                  <div class="form-group mt-2">
                    <label for="email">Adresă de e-mail: </label> 
                    <input class="form-control" type="text" readonly value="<?php echo $email; ?>" />   
                  </div>

                  <?php
                    if (!strcmp($userType, "pacient")) {
                  ?>
                    <div class="form-group mt-2" id="divCNP">
                      <label for="cnp">CNP: </label> 
                      <input class="form-control" type="text" readonly value="<?php echo $row["cnp"]; ?>" />   
                    </div>

                    <div class="form-group mt-2" id="divSex">
                      <p class="mb-1">Sex: </p>

                      <div class="d-flex gap-2">
                        <input type="radio" class="btn-check me-2" <?php if (!strcmp($row["sex"], "Masculin")) {echo "checked";} else {echo "disabled";} ?>>
                        <label class="btn btn-outline-success" for="masculin">Masculin</label>

                        <input type="radio" class="btn-check" <?php if (!strcmp($row["sex"], "Feminin")) {echo "checked";} else {echo "disabled";} ?> >
                        <label class="btn btn-outline-success" for="feminin">Feminin</label>

                        <input type="radio" class="btn-check" <?php if (!strcmp($row["sex"], "Altul")) {echo "checked";} else {echo "disabled";} ?> >
                        <label class="btn btn-outline-success" for="altul">Altul</label>
                      </div>
                    </div>

                    <div class="form-group mt-2" id="divTelefon">
                      <label for="telefon">Telefon: </label> 
                      <input class="form-control" type="text" readonly value="<?php echo $row["telefon"]; ?>" />   
                    </div>

                    <div class="form-group mt-2" id="divDataNastere">
                      <p class="mb-1">Data nașterii:</p>
                      <p class="fw-bold"> <?php echo $row["data_nastere"]; ?> </p>
                    </div>

                    <?php
                      if ($row["asigurare"] == 1) {
                        $sql_as = "SELECT * FROM asigurare WHERE idpacient = $userId";
                        $stmt_as = $mysqli->prepare($sql_as);
                        $stmt_as->execute();
                        $result_as = $stmt_as->get_result();
                        
                        if ($result_as->num_rows > 0) {
                        $row_as = mysqli_fetch_assoc($result_as);
                    ?>
                      <div class="form-group mt-2" id="divAsigurare">
                        <p class="mb-1">Asigurare: </p>

                        <div class="d-flex gap-2">
                          <input type="radio" class="btn-check me-2" disabled>
                          <label class="btn btn-outline-success" for="asigurareNu">Nu</label>

                          <input type="radio" class="btn-check" checked>
                          <label class="btn btn-outline-success" for="asigurareDa">Da</label>
                        </div>
                      </div>

                      <div class="form-group mt-2" id="divTipAsigurare">
                        <p class="mb-1">Tip asigurare: </p>

                        <div class="d-flex gap-2">
                          <input type="radio" class="btn-check me-2" <?php if(!strcmp($row_as["tip_asigurare"], "Stat")) {echo "checked";} else { echo "disabled";} ?> >
                          <label class="btn btn-outline-success" for="asigurareStat">Stat</label>

                          <input type="radio" class="btn-check" <?php if(!strcmp($row_as["tip_asigurare"], "Privat")) {echo "checked";} else { echo "disabled";} ?> >
                          <label class="btn btn-outline-success" for="asigurarePrivat">Privat</label>
                        </div>
                      </div>

                      <div class="form-group mt-2" id="divCasaAsigurare">
                        <label for="telefon">Casa de asigurări: </label> 
                        <input class="form-control" type="text" readonly value="<?php echo $row_as["casa_asigurare"]; ?>" />   
                      </div>
                  <?php
                        }
                        else {
                          echo "Asigurarea nu a fost găsită";
                        }
                        $stmt_as->close();
                      }
                      else {
                  ?>
                      <div class="form-group mt-2" id="divAsigurare">
                        <p class="mb-1">Asigurare: </p>

                        <div class="d-flex gap-2">
                          <input type="radio" class="btn-check me-2" checked>
                          <label class="btn btn-outline-success" for="asigurareNu">Nu</label>

                          <input type="radio" class="btn-check" disabled>
                          <label class="btn btn-outline-success" for="asigurareDa">Da</label>
                        </div>
                      </div>
                  <?php
                      }
                    }
                    else {
                  ?>
                    <div class="form-group mt-2" id="divSpecializare">
                      <label for="specializare">Specializare: </label> 
                      <input class="form-control" type="text" readonly value="<?php echo $row["specializare"]; ?>" />   
                    </div>

                    <div class="form-group mt-2" id="divTelefonCabinet">
                      <label for="telefonCabinet">Telefon cabinet: </label> 
                      <input class="form-control" type="text" readonly value="<?php echo $row["telefon_cabinet"]; ?>" />   
                    </div>
                  <?php
                    }
                  ?>
              </div>
            </div>
            <?php
          }
          else {
            echo "Utilizatorul nu a fost găsit!";
          }

          $stmt->close();
          $mysqli->close();
        }
        else {
          echo "Nu sunteți logat!";
          echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
        }
      ?>
    </div>
    
    <script src="/script/script.js"></script>
    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>
  </body>
</html>