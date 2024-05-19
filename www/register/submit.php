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
        // echo "Date introduse: <br>";
        // echo "Tip cont: " . $_POST["account"] . "<br>";
        // echo "Prenume: " . $_POST["firstname"] . "<br>";
        // echo "Nume: " . $_POST["lastname"] . "<br>";
        // echo "Email: " . $_POST["email"] . "<br>";
        // echo "Parola 1: " . $_POST["pass1"] . "<br>";
        // echo "Parola 2: " . $_POST["pass2"] . "<br>";
        // echo "Acceptare termeni: " . $_POST["terms"] . "<br>";

        // echo "Tip cont: ";
        // if ($_POST["account"] == 0) {
        //   echo "Pacient <br>";
        //   echo "CNP: " . $_POST["cnp"] ."<br>";
        //   echo "Sex: " . $_POST["sex"] ."<br>";
        //   echo "Telefon: " . $_POST["telefon"] ."<br>";
        //   echo "Data nasterii: " . $_POST["dataNastere"] ."<br>";
        //   echo "Asigurare: " . $_POST["asigurare"] ."<br>";
        // }
        // else if ($_POST["account"] == 1) {
        //   echo "Medic <br>";
        //   echo "Specializare: " . $_POST["specializare"] ."<br>";
        //   echo "Telefon cabinet: " . $_POST["telefonCabinet"] ."<br>";
        // }
        
        // // echo var_dump($_POST["terms"]);
        // echo "Termeni si conditii acceptati? ";
        // if ($_POST["terms"] == "on") {
        //   echo "Da";
        // }
        // else {
        //   echo "Nu";
        // }

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

        // Set autocommit to off
        $mysqli->autocommit(FALSE);

        // Start transaction
        $mysqli->begin_transaction();

        // Check connection
        if ($mysqli->connect_error) {
          die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
        }
        
        if (strlen($_POST["email"]) > 0) {
          $sql = "SELECT idpacient FROM pacienti WHERE email = ?";
          $stmt = $mysqli->prepare($sql);

          $stmt->bind_param("s", $_POST["email"]);
          $stmt->execute();

          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            echo "Există deja un <b>pacient</b> cu această adresă de e-mail.";
          }
          else {
            $stmt->close();

            $sql = "SELECT idmedic FROM medici WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt->bind_param("s", $_POST["email"])) {
              $err = error_get_last();
              if($err)
                echo "Bind failed.  %s\n", $err['message'];
            }

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              echo "Există deja un <b>medic</b> cu această adresă de e-mail.";
            }
            else {
              $stmt->close();
              
              // patient account
              if ($_POST["account"] == 0) {

                // check password fields again
                if (strcmp($_POST["pass1"], $_POST["pass2"]) == 0 &&
                    strlen($_POST["pass1"]) > 0 && 
                    strlen($_POST["pass2"]) > 0) {
                  
                  $nume = $_POST["firstname"];
                  $prenume = $_POST["lastname"];
                  $cnp = $_POST["cnp"];
                  $sex = "Masculin";
                  if ($_POST["sex"] == 0) {
                    $sex = "Masculin";
                  }
                  else if ($_POST["sex"] == 1) {
                    $sex = "Feminin";
                  }
                  else {
                    $sex = "Altul";
                  }
                  $telefon = $_POST["telefon"];
                  $email = $_POST["email"];
                  $parola = password_hash($_POST["pass1"], PASSWORD_DEFAULT);
                  $data_nastere = date('Y-m-d', strtotime($_POST["dataNastere"]));
                  $asigurare = $_POST["asigurare"];
                  
                  $tip_asigurare = null;
                  $casa_asigurare = null;

                  if ($asigurare == 1) {
                    $tip_asigurare = $_POST["tipAsigurare"];
                    $casa_asigurare = $_POST["casaAsigurare"];
                  }

                  if (strlen($nume) > 0 &&
                      strlen($prenume) > 0 &&
                      strlen($cnp) > 0 &&
                      strlen($telefon) > 0 &&
                      strlen($data_nastere) > 0 &&
                      ($asigurare == 0 || $asigurare == 1) &&
                      ((isset($tip_asigurare) && ($tip_asigurare == 1 || $tip_asigurare == 2)) || !isset($tip_asigurare)) &&
                      ((isset($casa_asigurare) && strlen($casa_asigurare) > 0) || !isset($casa_asigurare))
                      ) {
                    // no need to check email and password as we already checked them before

                    // check if CNP is already in the table
                    $sql = "SELECT idpacient FROM pacienti WHERE cnp = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("s", $cnp);

                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      echo "Există deja o intrare cu același CNP!";
                    }
                    else {
                      $stmt->close();

                      // Prepare an SQL statement with placeholders
                      $sql = "INSERT INTO pacienti (nume, prenume, cnp, sex, telefon, email, parola, data_nastere, asigurare) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                      // Prepare the statement
                      $stmt = $mysqli->prepare($sql);

                      // Bind parameters to the placeholders
                      $stmt->bind_param("ssssssssi", $nume, $prenume, $cnp, $sex, $telefon, $email, $parola, $data_nastere, $asigurare);

                      // $stmt->execute();
                      if($stmt === false) {
                          echo $mysqli->error;
                          die();
                      }
                      if($stmt->execute() === false) {
                          echo $mysqli->error;
                          die();
                      }


                      // Check if the insertion was successful
                      if ($stmt->affected_rows > 0) {
                        $stmt->close();

                        $last_id = $mysqli->insert_id;

                        // add entry to "asigurare" table
                        $sql = "INSERT INTO asigurare (idpacient, tip_asigurare, casa_asigurare) 
                        VALUES (?, ?, ?)";

                        $stmt = $mysqli->prepare($sql);

                        if ($asigurare == 0) {
                          // tip_asigurare will be "Neasigurat"
                          $tip_asigurare = "Neasigurat";
                          $casa_asigurare = "Fara";
                        }

                        $stmt->bind_param("iss", $last_id, $tip_asigurare, $casa_asigurare);

                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                          echo "Înregistrarea a avut loc cu success.";

                          // commit transaction
                          $mysqli->commit();
                        }
                        else {
                          echo "A apărut o eroare la adăugarea informațiilor despre asigurare!";

                          // something went wrong, rollback
                          $mysqli->rollback();
                        }
                      } else {
                        echo "Eroare la adăugarea în baza de date: " . $stmt->error;
                        // maybe the data sent from the form isn't correct
                        // or the user manually accessed the page?

                        // something went wrong, rollback
                        $mysqli->rollback();
                      }


                      // Close the statement
                      $stmt->close();
                    }
                  }
                  else {
                    echo "Eroare la trimiterea datelor.";
                    // one or more fields are empty or incorrect
                    
                    // something went wrong, rollback
                    $mysqli->rollback();
                  }
                }
                else {
                  echo "Eroare la trimiterea datelor!";
                  // passwords don't match or are of length 0

                  // something went wrong, rollback
                  $mysqli->rollback();
                }
              }
              // medic account
              else if ($_POST["account"] == 1) {

                // check password fields again
                if (strcmp($_POST["pass1"], $_POST["pass2"]) == 0 &&
                    strlen($_POST["pass1"]) > 0 && 
                    strlen($_POST["pass2"]) > 0) {
                  // no need to check email and password as we already checked them before
                  
                  $nume = $_POST["firstname"];
                  $prenume = $_POST["lastname"];
                  $email = $_POST["email"];
                  $parola = password_hash($_POST["pass1"], PASSWORD_DEFAULT);
                  $specializare = $_POST["specializare"];
                  $telefonCabinet = $_POST["telefonCabinet"];

                  if (strlen($nume) > 0 &&
                      strlen($prenume) > 0 &&
                      strlen($specializare) > 0 &&
                      strlen($telefonCabinet) > 0
                      ) {
                  // Prepare an SQL statement with placeholders
                  $sql = "INSERT INTO medici (nume, prenume, specializare, email, parola, telefon_cabinet) 
                  VALUES (?, ?, ?, ?, ?, ?)";

                  // Prepare the statement
                  $stmt = $mysqli->prepare($sql);

                  // Bind parameters to the placeholders
                  $stmt->bind_param("ssssss", $nume, $prenume, $specializare, $email, $parola, $telefonCabinet);


                  // $stmt->execute();
                  if($stmt === false) {
                      echo $mysqli->error;
                      die();
                  }
                  if($stmt->execute() === false) {
                      echo $mysqli->error;
                      die();
                  }

                  // Check if the insertion was successful
                  if ($stmt->affected_rows > 0) {
                    echo "Înregistrarea a avut loc cu success.";

                    // commit transaction
                    $mysqli->commit();
                  } else {
                    echo "Eroare la adăugarea în baza de date: " . $stmt->error;
                    // maybe the data sent from the form isn't correct
                    // or the user manually accessed the page?

                    // something went wrong, rollback
                    $mysqli->rollback();
                  }

                  // Close the statement
                  $stmt->close();
                  }
                  else {
                    echo "Eroare la trimiterea datelor.";
                    // one or more fields are empty or incorrect

                    // something went wrong, rollback
                    $mysqli->rollback();
                  }
                }
                else {
                  echo "Eroare la trimiterea datelor!";
                  // passwords don't match or are of length 0

                  // something went wrong, rollback
                  $mysqli->rollback();
                }

              }
              else {
                echo "Eroare la trimiterea datelor.";
                // $_POST["account"] is neither 0 nor 1

                // something went wrong, rollback
                $mysqli->rollback();
              }
            }
          }
        }
        else {
          echo "Eroare la trimiterea datelor.";
          // email length is 0

          // something went wrong, rollback
          $mysqli->rollback();
        }

        $mysqli->close();
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