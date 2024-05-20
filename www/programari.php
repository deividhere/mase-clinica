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

          if (!strcmp($_SESSION["userType"], "medic")) {
            if (isset($_GET["id"])) {
              ?>
              <p class="text-center h2 fw-bold mb-2 mx-1 mx-md-4 mt-4">Vizualizare programare</p>
              <?php
              $sql = "SELECT idprogramare, pc.nume numepac, pc.prenume prenumepac, data_programare, ora_programare, status FROM programare AS p
              INNER JOIN medici AS m ON p.idmedic = m.idmedic 
              INNER JOIN pacienti AS pc ON pc.idpacient = p.idpacient
              WHERE p.idprogramare = ? AND p.idmedic = ?
              ORDER BY p.status, p.data_programare DESC, p.ora_programare ASC";
              $stmt = $mysqli->prepare($sql);

              $stmt->bind_param("ii", $_GET["id"], $_SESSION["userid"]);
              $stmt->execute();

              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);

                echo "Nume pacient: " . $row["numepac"] . "<br>";
                echo "Prenume pacient: " . $row["prenumepac"] . "<br>";
                echo "Dată programare: " . $row["data_programare"] . "<br>";
                echo "Oră programare: " . $row["ora_programare"] . "<br>";
                echo "Status: " . $row["status"] . "<br>";
                ?>
                <div class="mt-1 d-flex gap-2">
                  <button type="button" class="btn btn-outline-success" onclick="">Adăugare diagnostic</button>
                  <button type="button" class="btn btn-outline-success ms-2" onclick="confirmBoxConfirm();">Confirmă programarea</button>
                  <button type="button" class="btn btn-outline-danger" onclick="confirmBoxCancel();">Anulează programarea</button>
                  <button type="button" class="btn btn-danger ms-2" onclick="confirmBox();">Șterge programarea</button>
                </div>
                <?php
              }
              else {
                echo "Nu s-a găsit nicio programare cu ID-ul specificat.";
              }
            }
            else {
              $sql = "SELECT idprogramare, pc.nume numepac, pc.prenume prenumepac, data_programare, ora_programare, status FROM programare AS p
              INNER JOIN medici AS m ON p.idmedic = m.idmedic 
              INNER JOIN pacienti AS pc ON pc.idpacient = p.idpacient
              WHERE m.idmedic = ?
              ORDER BY p.status, p.data_programare DESC, p.ora_programare ASC";
              $stmt = $mysqli->prepare($sql);
      
              $stmt->bind_param("i", $_SESSION["userid"]);
              $stmt->execute();
      
              $result = $stmt->get_result();
      
              if ($result->num_rows > 0) {
                $i = 1;
                ?>
                <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nume pacient</th>
                    <th scope="col">Prenume pacient</th>
                    <th scope="col">Dată programare</th>
                    <th scope="col">Oră programare</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<tr class=\"clickable\" onclick=\"showDetails(". $row["idprogramare"] .")\">";
                      echo "<th scope=\"row\">$i</th>";
                      echo "<td>" . $row["numepac"] . "</td>";
                      echo "<td>" . $row["prenumepac"] . "</td>";
                      echo "<td>" . $row["data_programare"] . "</td>";
                      echo "<td>" . $row["ora_programare"] . "</td>";
                      echo "<td>" . $row["status"] . "</td>";
                      echo "</tr>";
                      $i++;
                    }
                  ?>
                </tbody>
              </table>
                <?php
              }
              else {
                echo "Nu a fost găsită nicio programare.";
              }
            }
          }
          else if (!strcmp($_SESSION["userType"], "pacient")) {
            if (isset($_GET["id"])) {
              ?>
              <p class="text-center h2 fw-bold mb-2 mx-1 mx-md-4 mt-4">Vizualizare programare</p>
              <?php
              $sql = "SELECT nume, prenume, specializare, data_programare, ora_programare, status FROM programare p 
              INNER JOIN medici m ON p.idmedic = m.idmedic 
              WHERE p.idprogramare = ? AND p.idpacient = ?";
              $stmt = $mysqli->prepare($sql);

              $stmt->bind_param("ii", $_GET["id"], $_SESSION["userid"]);
              $stmt->execute();

              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);

                echo "Nume medic: " . $row["nume"] . "<br>";
                echo "Prenume medic: " . $row["prenume"] . "<br>";
                echo "Specializare medic: " . $row["specializare"] . "<br>";
                echo "Dată programare: " . $row["data_programare"] . "<br>";
                echo "Oră programare: " . $row["ora_programare"] . "<br>";
                echo "Status: " . $row["status"] . "<br>";
                ?>
                <div class="mt-2">
                  <button type="button" class="btn btn-outline-danger" onclick="confirmBox();">Șterge programarea</button>
                </div>
                <?php
              }
              else {
                echo "Nu s-a găsit nicio programare cu ID-ul specificat.";
              }
            }
            else {
              $sql = "SELECT idprogramare, nume, prenume, specializare, data_programare, ora_programare, status FROM programare p 
              INNER JOIN medici m ON p.idmedic = m.idmedic 
              WHERE p.idpacient = ?
              ORDER BY p.status, p.data_programare DESC, p.ora_programare ASC";
              $stmt = $mysqli->prepare($sql);
      
              $stmt->bind_param("i", $_SESSION["userid"]);
              $stmt->execute();
      
              $result = $stmt->get_result();
      
              if ($result->num_rows > 0) {
                $i = 1;
                ?>
                <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nume medic</th>
                    <th scope="col">Prenume medic</th>
                    <th scope="col">Specializare</th>
                    <th scope="col">Dată programare</th>
                    <th scope="col">Oră programare</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<tr class=\"clickable\" onclick=\"showDetails(". $row["idprogramare"] .")\">";
                      echo "<th scope=\"row\">$i</th>";
                      echo "<td>" . $row["nume"] . "</td>";
                      echo "<td>" . $row["prenume"] . "</td>";
                      echo "<td>" . $row["specializare"] . "</td>";
                      echo "<td>" . $row["data_programare"] . "</td>";
                      echo "<td>" . $row["ora_programare"] . "</td>";
                      echo "<td>" . $row["status"] . "</td>";
                      echo "</tr>";
                      $i++;
                    }
                  ?>
                </tbody>
              </table>
                <?php
              }
              else {
                echo "Nu a fost găsită nicio programare.";
              }
              ?>
              <div class="mt-2">
                <button type="button" class="btn btn-outline-success" onclick="window.location = '/programari/adauga';">Adăugare programare</button>
              </div>
              <?php
            }
          }
          else {
            echo "Tipul de utilizator nu este cunoscut!";
          }

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
    <script type="text/javascript">
    function showDetails(id)
    {
      window.location = '/programari?id='+id;
    }
    </script>
    <script type="text/javascript">
    function confirmBox() {
      let text = "Sunteți sigur că vreți să ștergeți programarea?";
      if (confirm(text) == true) {
        window.location = '/programari/sterge?id=<?php echo $_GET["id"] ?>';
      } else {
        return;
      }
    }
    </script>
    <script type="text/javascript">
    function confirmBoxCancel() {
      let text = "Sunteți sigur că vreți să anulați programarea?";
      if (confirm(text) == true) {
        window.location = '/programari/editare?action=cancel&id=<?php echo $_GET["id"] ?>';
      } else {
        return;
      }
    }
    </script>
    <script type="text/javascript">
    function confirmBoxConfirm() {
      let text = "Sunteți sigur că vreți să confirmați programarea?";
      if (confirm(text) == true) {
        window.location = '/programari/editare?action=confirm&id=<?php echo $_GET["id"] ?>';
      } else {
        return;
      }
    }
    </script>
  </body>
</html>