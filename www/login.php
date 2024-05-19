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

    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$rootDir/persistentlogin.php";

    $active = 9;

    $success = 0;

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      // echo "Sunteți deja logat.";
      $success = 2;
    }
    else {
      // echo "Date introduse: <br>";
      // echo "Email: " . $_POST["emailLogin"] . "<br>";
      // echo "Parola: " . $_POST["passwordLogin"] . "<br>";
      // echo "Sesiune: " . $_POST["rememberLogin"] . "<br>";

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
      
      $emailLogin = $_POST["emailLogin"];
      $passwordLogin = $_POST["passwordLogin"];
      $rememberLogin = false;

      if (isset($_POST["rememberLogin"]) && !strcmp($_POST["rememberLogin"], "on")) {
        $rememberLogin = true;
        // echo "Remember login e setat corect <br>";
      }

      $sql = "SELECT * FROM pacienti WHERE email = ?";
      $stmt = $mysqli->prepare($sql);

      $stmt->bind_param("s", $emailLogin);
      $stmt->execute();

      $result_pacienti = $stmt->get_result();

      $stmt->close();

      $sql = "SELECT * FROM medici WHERE email = ?";
      $stmt = $mysqli->prepare($sql);

      $stmt->bind_param("s", $emailLogin);
      $stmt->execute();

      $result_medici = $stmt->get_result();

      if ($result_medici->num_rows > 0 && $result_pacienti->num_rows > 0) {
        // email has been found in both - big error
        // echo "<b>Eroare</b><br> Adresa de e-mail este înregistrată ca <b>medic</b> și ca <b>pacient</b>. Vă rugăm contactați administratorul paginii.";
        $success = 3;
      }
      else if ($result_medici->num_rows > 0 || $result_pacienti->num_rows > 0) {
        // email has been found only in one table
        // echo "Email gasit corect<br>";
        
        $result = null;
        $usertype = null;

        if ($result_medici->num_rows > 0) {
          $result = $result_medici;
          $usertype = "medic";
        }
        else if ($result_pacienti->num_rows > 0) {
          $result = $result_pacienti;
          $usertype = "pacient";
        }

        $row = mysqli_fetch_assoc($result);

        $queryPassword = $row["parola"];
        $queryNume = $row["nume"];
        $queryPrenume = $row["prenume"];

        $isPasswordCorrect = password_verify($passwordLogin, $queryPassword);
        
        if ($isPasswordCorrect) {
        // echo "Parola corecta<br>";
        // login successful

          // set session attributes
          $_SESSION["loggedin"] = true;
          $_SESSION["email"] = $emailLogin;
          $_SESSION["userType"] = $usertype;
          $_SESSION["nume"] = $queryNume;
          $_SESSION["prenume"] = $queryPrenume;

          $success = 1;

          // check if necessary cookies are enabled
          if ($rememberLogin && isset($_COOKIE["cookie_consent_level"])) {
            // echo "Popup de cookie acceptat<br>";
            $cookie_consent_level_login = $_COOKIE["cookie_consent_level"];
            $obj_login = json_decode($cookie_consent_level_login);
            $strictly_necessary_login = $obj_login->{'strictly-necessary'};

            if ($strictly_necessary_login == 1) {
              // echo "Cookie-urile strict necesare au fost acceptate<br>";

              setcookie("persistentLogin", true, time() + (86400 * 30), "/");
              setcookie("email", $emailLogin, time() + (86400 * 30), "/");
              setcookie("nume", $queryNume, time() + (86400 * 30), "/");
              setcookie("prenume", $queryPrenume, time() + (86400 * 30), "/");
              setcookie("userType", $usertype, time() + (86400 * 30), "/");
              
              // generate unique ID based on timestamp and email address
              $uniqueId = uniqid() . md5($emailLogin);

              setcookie("uniqueId", $uniqueId, time() + (86400 * 30), "/");

              // insert unique ID into server database
              $mysqli->begin_transaction();

              $stmt->close();

              $sql = "INSERT INTO persistentlogin (uniqueid, email) 
              VALUES (?, ?)";

              $stmt = $mysqli->prepare($sql);

              $stmt->bind_param("ss", $uniqueId, $emailLogin);

              $stmt->execute();

              if ($stmt->affected_rows > 0) {
                // echo "Sesiunea a fost reținută cu succes.";
                $success = 1;

                // commit transaction
                $mysqli->commit();
              }
              else {
                // echo "A apărut o eroare la reținerea sesiunii. Vă rugăm încercați din nou!";
                $success = 4;

                // something went wrong, rollback
                $mysqli->rollback();

                // unset all cookies and session data
                unset($_SESSION["loggedin"]);
                unset($_SESSION["email"]);
                unset($_SESSION["userType"]);
                unset($_SESSION["nume"]);
                unset($_SESSION["prenume"]);

                unset($_COOKIE["persistentLogin"]);
                unset($_COOKIE["email"]);
                unset($_COOKIE["nume"]);
                unset($_COOKIE["prenume"]);
                unset($_COOKIE["uniqueId"]);

                setcookie('persistentLogin', '', time() - 3600, '/');
                setcookie('email', '', time() - 3600, '/');
                setcookie('nume', '', time() - 3600, '/');
                setcookie('prenume', '', time() - 3600, '/');
                setcookie('uniqueId', '', time() - 3600, '/');
              }
            }
            else {
              // echo "Cookie-urile strict necesare NU au fost acceptate<br>";
              // strictly necessary cookies haven't been accepted
              // do nothing
            }
          }
          else {
            // cookie window hasn't been dismissed yet or the user didn't check "Remember me"
            // do nothing
          }
        }
        else {
          // password incorrect
          // echo "Adresa de e-mail sau parola sunt incorecte.";
          $success = 5;
        }
      }
      else {
        // email hasn't been found
        // echo "Adresa de e-mail sau parola sunt incorecte.";
        $success = 5;
      }

      $stmt->execute();
      $mysqli->close();
    }

    if ($success != 1) {
      include "$rootDir/navbar.php";
    }
    ?>

    <div class="container mt-4">
      <?php
        switch($success) {
          case 0:
            echo "Eroare de autentificare! Vă rugăm contactați administratorul paginii!";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
          case 1:
            echo "<meta http-equiv=\"refresh\" content=\"0;url=home\">";
            // echo "Yay";
            die();
            break;
          case 2:
            echo "Sunteți deja logat.";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
          case 3:
            echo "<b>Eroare</b><br> Adresa de e-mail este înregistrată ca <b>medic</b> și ca <b>pacient</b>. Vă rugăm contactați administratorul paginii.";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
          case 4:
            echo "A apărut o eroare la reținerea sesiunii. Vă rugăm încercați din nou!";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
          case 5:
            echo "Adresa de e-mail sau parola sunt incorecte.";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
          default:
            echo "Eroare de autentificare! Vă rugăm contactați administratorul paginii!";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
            break;
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