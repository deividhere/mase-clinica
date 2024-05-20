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
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && !strcmp($_SESSION["userType"], "pacient")) {
        if (isset($_POST["dataProgramare"])) {
          include "$rootDir/sqlinit.php";

          // Create connection
          $mysqli = new mysqli($servername, $username, $password, $database);

          // Set autocommit to off
          $mysqli->autocommit(FALSE);

          // Start transaction
          $mysqli->begin_transaction();

          // Check connection
          if ($mysqli->connect_error) {
            die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
          }

          $sql = "INSERT INTO programare (idmedic, idpacient, status, data_programare, ora_programare) 
          VALUES (?, ?, 'In asteptare', ?, ?)";

          // echo "Medic: " . $_POST["idmedic"] . "<br>";
          // echo "Pacient: " . $_SESSION["userid"] . "<br>";
          // echo "Data: " . $_POST["dataProgramare"] . "<br>";
          // echo "Ora: " . $_POST["oraProgramare"] . "<br>";

          $stmt = $mysqli->prepare($sql);
          $stmt->bind_param("iiss", $_POST["idmedic"], $_SESSION["userid"], $_POST["dataProgramare"], $_POST["oraProgramare"]);
          
          try {
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
              $mysqli->commit();
  
              echo "Programarea a fost adăugată cu succes!";
              echo "<meta http-equiv=\"refresh\" content=\"3;url=/programari\">";
            }
            else {
              echo "Eroare la adăugarea programării!";
              
              $mysqli->rollback();
            }
          }
          catch (Exception $e) {
            $error = $e->getMessage();
            
            if (strpos($error, 'Aveți deja o programare la această oră.') !== false) {
              echo "Eroare: " . $error;
              $mysqli->rollback();
            }
            else if (strpos($error, 'Medicul este în concediu în acea zi.') !== false) {
              echo "Eroare: " . $error;
              $mysqli->rollback();
            }
            else if (strpos($error, 'Nu puteți face o programare în weekend.') !== false) {
              echo "Eroare: " . $error;
              $mysqli->rollback();
            }
            else if (strpos($error, 'Programarea nu poate fi făcută în trecut.') !== false) {
              echo "Eroare: " . $error;
              $mysqli->rollback();
            }
            else {
              echo "Eroare la adăugarea programării!";
              $mysqli->rollback();
            }
          }

          $stmt->close();
          $mysqli->close();
        }
        else {
          echo "Eroare la trimiterea datelor. Vă rugăm încercați din nou.";
        }
      }
      else {
        echo "Nu sunteți logat cu un cont de pacient!";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=/home\">";
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