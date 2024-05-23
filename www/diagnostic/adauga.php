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
    
    $active = 9;

    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$rootDir/persistentlogin.php";
    
    include "$rootDir/navbar.php";
    
    ?>

    <div class="container mt-4">
      <?php 
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && !strcmp($_SESSION["userType"], "medic")) {
        include "$rootDir/sqlinit.php";

        // Create connection
        $mysqli = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($mysqli->connect_error) {
          die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
        }

        $sql = "SELECT idprogramare, data_programare, ora_programare, nume, prenume
        FROM programare AS pr
        INNER JOIN pacienti AS pc ON pr.idpacient = pc.idpacient
        WHERE pr.idmedic = ?
        AND TIMESTAMP(pr.data_programare, pr.ora_programare) <= NOW()
        ORDER BY data_programare, ora_programare";
        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          $id_from_get = 0;

          if (isset($_GET["id"])) {
            $id_from_get = $_GET["id"];
          }
      ?>
        <div class="card-body p-md-5">
          <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Adăugare diagnostic</p>

              <form action="/diagnostic/adauga/submit" method="post" id="diagnosticForm" role="form">
                <div class="form-group mt-2"> 	 
                  <div class="mb-2">
                    <label for="idprogramare">Programare:</label>
                  </div>
                  <select id="idprogramare" class="form-select" name="idprogramare" required>
                    <?php
                      while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"". $row["idprogramare"] ."\" ";
                        if ($id_from_get == $row["idprogramare"]) echo "selected=\"selected\"";
                        echo ">". $row["nume"] . " " . $row["prenume"] . " - " . $row["data_programare"] . " " . $row["ora_programare"] ."</option>";
                        $i++;
                      }
                    ?>
                  </select>
                  <span id="errIdProgramare"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="diagnostic">Diagnostic: </label>
                  <input class="form-control" type="text" name="diagnostic" id = "diagnostic" onkeyup="checkDiagnostic();" onfocus="checkDiagnostic();" required /> 
                  <span id="errDiagnostic"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="descriere">Descriere: </label>
                  <input class="form-control" type="text" name="descriere" id = "descriere" onkeyup="checkDescriere();" onfocus="checkDescriere();" required /> 
                  <span id="errDescriere"></span>
                </div>

                <div class="form-group mt-2"> 	 
                  <label for="recomandari">Recomandari: </label>
                  <input class="form-control" type="text" name="recomandari" id = "recomandari" onkeyup="checkRecomandari();" onfocus="checkRecomandari();" required /> 
                  <span id="errRecomandari"></span>
                </div>

                <div class="form-group mt-2">
                  <p class="mb-1"> Rețetă: </p>
                  <?php
                    $stmt->close();

                    $sql = "SELECT m.idmedicament id, denumire name, stoc stock, nume pharmacy
                    FROM medicamente AS m
                    INNER JOIN farmacie AS f ON m.idmedicament = f.idmedicament
                    ORDER BY denumire";
                    $stmt = $mysqli->prepare($sql);

                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      $rows = [];

                      while($row = mysqli_fetch_array($result))
                      {
                        $rows[] = $row;
                      }

                      echo "<span id=\"sqlResult\" style=\"display: none;\">";
                      echo json_encode($rows);
                      echo "</span>";
                  ?>
                  <div id="retetaContainer" class="p-2 rounded"></div>
                  <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                      fetchMedicines();
                    });

                    let allMedicines = [];
                  </script>
                  <?php
                    }
                    else {
                      echo "Nu există medicamente în stoc. Puteți face un diagnostic și fără medicamente.";
                    }
                  ?>
                  <p class="mb-2">
                    <span id="errReteta"></span>
                  </p>
                  <button class="btn btn-outline-success" type="button" id="addMedicineButton">Adăugare medicament</button>
                </div>

                <input type="hidden" id="medicineNumber" name="medicineNumber" value="0">

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
          echo "Nu există nicio programare validă. Nu puteți face un diagnostic. <br> 
          Pentru ca o programare să fie validă, trebuie să fie făcută la dumneavoastră și să fie efectuată (data și ora să fie în trecut).";
        }
        
        $mysqli->close();
      }
      else {
        echo "Nu sunteți logat cu un cont de medic!";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=/home\">";
      }
      ?>
    </div>
    
    <script src="/script/script.js"></script>
    <script src="/script/diagnostic.js"></script>
    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>
    
  </body>
</html>