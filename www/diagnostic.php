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
          include "$rootDir/sqlinit.php";

          // Create connection
          $mysqli = new mysqli($servername, $username, $password, $database);

          // Check connection
          if ($mysqli->connect_error) {
            die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
          }

          if (!strcmp($_SESSION["userType"], "medic")) {
            if (isset($_GET["id"])) {
              ?>
              <p class="text-center h2 fw-bold mb-2 mx-1 mx-md-4 mt-4">Vizualizare diagnostic</p>
              <?php
              $sql = "SELECT iddiagnostic, diagnostic, descriere, recomandari, data_programare, ora_programare, pc.nume nume, pc.prenume prenume FROM diagnostic d
              INNER JOIN programare p ON d.idprogramare = p.idprogramare 
              INNER JOIN medici m ON p.idmedic = m.idmedic
              INNER JOIN pacienti pc ON p.idpacient = pc.idpacient
              WHERE m.idmedic = ? AND iddiagnostic = ?";
              $stmt = $mysqli->prepare($sql);

              $stmt->bind_param("ii", $_SESSION["userid"], $_GET["id"]);
              $stmt->execute();

              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);

                echo "Nume pacient: " . $row["nume"] . "<br>";
                echo "Prenume pacient: " . $row["prenume"] . "<br>";
                echo "Diagnostic: " . $row["diagnostic"] . "<br>";
                echo "Descriere: " . $row["descriere"] . "<br>";
                echo "Recomandări: " . $row["recomandari"] . "<br>";
                echo "Dată programare: " . $row["data_programare"] . "<br>";
                echo "Oră programare: " . $row["ora_programare"] . "<br>";

                $iddiagnostic = $row["iddiagnostic"];

                $stmt->close();

                $sql = "SELECT l.idmedicament idm, denumire, cantitate FROM reteta r
                INNER JOIN lista l ON r.idreteta = l.idreteta 
                INNER JOIN medicamente m ON l.idmedicament = m.idmedicament
                WHERE r.iddiagnostic = ?";
                $stmt = $mysqli->prepare($sql);

                $stmt->bind_param("i", $iddiagnostic);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  echo "Rețetă: <br>";
                  $i = 1;
                  ?>
                  <table class="table table-hover">
                    <thead class="table-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Denumire</th>
                        <th scope="col">Cantitate</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while($row = mysqli_fetch_assoc($result)) {
                          echo "<tr class=\"clickable\" onclick=\"showDetailsMed(". $row["idm"] .")\">";
                          echo "<th scope=\"row\">$i</th>";
                          echo "<td>" . $row["denumire"] . "</td>";
                          echo "<td>" . $row["cantitate"] . "</td>";
                          echo "</tr>";
                          $i++;
                        }
                      ?>
                    </tbody>
                  </table>
                  <?php
                }
                else {
                  echo "Diagnosticul nu are nicio rețetă.";
                }
              }
              else {
                echo "Nu s-a găsit niciun diagnostic cu ID-ul specificat.";
              }
            }
            else {
              $sql = "SELECT iddiagnostic, diagnostic, descriere, recomandari FROM diagnostic d
              INNER JOIN programare p ON d.idprogramare = p.idprogramare 
              WHERE p.idmedic = ?";
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
                      <th scope="col">Diagnostic</th>
                      <th scope="col">Descriere</th>
                      <th scope="col">Recomandări</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class=\"clickable\" onclick=\"showDetails(". $row["iddiagnostic"] .")\">";
                        echo "<th scope=\"row\">$i</th>";
                        echo "<td>" . substr($row["diagnostic"], 0, 30) . "</td>";
                        echo "<td>" . substr($row["descriere"], 0, 30) . "</td>";
                        echo "<td>" . substr($row["recomandari"], 0, 30) . "</td>";
                        echo "</tr>";
                        $i++;
                      }
                    ?>
                  </tbody>
                </table>
                <?php
              }
              else {
                echo "Nu a fost găsit niciun diagnostic.";
              }
              ?>
              <?php
            }
          }
          else if (!strcmp($_SESSION["userType"], "pacient")) {
            if (isset($_GET["id"])) {
              ?>
              <p class="text-center h2 fw-bold mb-2 mx-1 mx-md-4 mt-4">Vizualizare diagnostic</p>
              <?php
              $sql = "SELECT iddiagnostic, diagnostic, descriere, recomandari, data_programare, ora_programare, nume, prenume FROM diagnostic d
              INNER JOIN programare p ON d.idprogramare = p.idprogramare 
              INNER JOIN medici m ON p.idmedic = m.idmedic
              WHERE p.idpacient = ? AND iddiagnostic = ?";
              $stmt = $mysqli->prepare($sql);

              $stmt->bind_param("ii", $_SESSION["userid"], $_GET["id"]);
              $stmt->execute();

              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);

                echo "Nume medic: " . $row["nume"] . "<br>";
                echo "Prenume medic: " . $row["prenume"] . "<br>";
                echo "Diagnostic: " . $row["diagnostic"] . "<br>";
                echo "Descriere: " . $row["descriere"] . "<br>";
                echo "Recomandări: " . $row["recomandari"] . "<br>";
                echo "Dată programare: " . $row["data_programare"] . "<br>";
                echo "Oră programare: " . $row["ora_programare"] . "<br>";

                $iddiagnostic = $row["iddiagnostic"];

                $stmt->close();

                $sql = "SELECT l.idmedicament idm, denumire, cantitate FROM reteta r
                INNER JOIN lista l ON r.idreteta = l.idreteta 
                INNER JOIN medicamente m ON l.idmedicament = m.idmedicament
                WHERE r.iddiagnostic = ?";
                $stmt = $mysqli->prepare($sql);

                $stmt->bind_param("i", $iddiagnostic);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  echo "Rețetă: <br>";
                  $i = 1;
                  ?>
                  <table class="table table-hover">
                    <thead class="table-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Denumire</th>
                        <th scope="col">Cantitate</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while($row = mysqli_fetch_assoc($result)) {
                          echo "<tr class=\"clickable\" onclick=\"showDetailsMed(". $row["idm"] .")\">";
                          echo "<th scope=\"row\">$i</th>";
                          echo "<td>" . $row["denumire"] . "</td>";
                          echo "<td>" . $row["cantitate"] . "</td>";
                          echo "</tr>";
                          $i++;
                        }
                      ?>
                    </tbody>
                  </table>
                  <?php
                }
                else {
                  echo "Diagnosticul nu are nicio rețetă.";
                }
              }
              else {
                echo "Nu s-a găsit niciun diagnostic cu ID-ul specificat.";
              }
            }
            else {
              $sql = "SELECT iddiagnostic, diagnostic, descriere, recomandari FROM diagnostic d
              INNER JOIN programare p ON d.idprogramare = p.idprogramare 
              WHERE p.idpacient = ?";
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
                      <th scope="col">Diagnostic</th>
                      <th scope="col">Descriere</th>
                      <th scope="col">Recomandări</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class=\"clickable\" onclick=\"showDetails(". $row["iddiagnostic"] .")\">";
                        echo "<th scope=\"row\">$i</th>";
                        echo "<td>" . substr($row["diagnostic"], 0, 30) . "</td>";
                        echo "<td>" . substr($row["descriere"], 0, 30) . "</td>";
                        echo "<td>" . substr($row["recomandari"], 0, 30) . "</td>";
                        echo "</tr>";
                        $i++;
                      }
                    ?>
                  </tbody>
                </table>
                <?php
              }
              else {
                echo "Nu a fost găsit niciun diagnostic.";
              }
              ?>
              <?php
            }
          }
          else {
            echo "Tipul de utilizator nu este cunoscut!";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=/home\">";
          }
        }
        else {
          echo "Nu sunteți logat!";
          echo "<meta http-equiv=\"refresh\" content=\"3;url=home\">";
        }
      ?>
    </div>
    
    <script type="text/javascript">
    function showDetails(id)
      {
        window.location = '/diagnostic?id='+id;
      }
    </script>
    <script type="text/javascript">
    function showDetailsMed(id)
      {
        window.location = '/medicamente?id='+id;
      }
    </script>
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