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
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && !strcmp($_SESSION["userType"], "pacient")) {
        // Initialize SQL fields
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "clinica";

        // Display errors
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Create connection
        $mysqli = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($mysqli->connect_error) {
          die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
        }

        $sql = "SELECT idmedic, nume, prenume, specializare FROM medici ORDER BY nume";
        $stmt = $mysqli->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
      ?>
        <div class="card-body p-md-5">
          <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Adăugare programare</p>

              <form action="/programari/adauga/submit" method="post" id="programariForm" role="form">
                <div class="form-group mt-2"> 	 
                  <div class="mb-2">
                    <label for="idmedic">Medic:</label>
                  </div>
                  <select id="idmedic" class="form-select" name="idmedic" required>
                    <?php
                      while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"". $row["idmedic"] ."\">". $row["nume"] . " " . $row["prenume"] . " - " . $row["specializare"] ."</option>";
                        $i++;
                      }
                    ?>
                  </select>
                  <span id="errMedic"></span>
                </div>

                <div class="form-group mt-2" id="divDataProgramare">
                  <div class="mb-1">
                    <div class="mb-1">
                      <label for="dataProgramare">Data programării:</label>
                    </div>
                    <input type="date" id="dataProgramare" name="dataProgramare" value="2000-01-01" min="1900-01-01" max="2100-01-01"/>  
                  </div>
                  <span id="errDataProgramare"></span>
                </div>

                <div class="form-group mt-2" id="divOraProgramare">
                  <div class="mb-1">
                    <div class="mb-1">
                      <label for="oraProgramare">Ora programării:</label>
                    </div>

                    <div class="d-flex gap-2 mb-1 justify-content-center">
                      <table>
                        <thead>
                          <tr>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora0800" value="08:00" autocomplete="off" checked>
                              <label class="btn btn-outline-success" for="ora0800">08:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora0830" value="08:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora0830">08:30</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora0900" value="09:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora0900">09:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora0930" value="09:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora0930">09:30</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1000" value="10:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1000">10:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1030" value="10:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1030">10:30</label>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1100" value="11:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1100">11:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1130" value="11:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1130">11:30</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1200" value="12:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1200">12:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1230" value="12:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1230">12:30</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1300" value="13:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1300">13:00</label>
                            </th>
                            <th class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1330" value="13:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1330">13:30</label>
                            </th>
                          </tr>
                          <tr>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1400" value="14:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1400">14:00</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1430" value="14:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1430">14:30</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1500" value="15:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1500">15:00</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1530" value="15:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1530">15:30</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1600" value="16:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1600">16:00</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1630" value="16:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1630">16:30</label>
                            </td>
                          </tr>
                          <tr>
                            <td class="tg-0lax"></td>
                            <td class="tg-0lax"></td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1700" value="17:00" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1700">17:00</label>
                            </td>
                            <td class="tg-0lax">
                              <input type="radio" class="btn-check me-2" name="oraProgramare" id="ora1730" value="17:30" autocomplete="off" >
                              <label class="btn btn-outline-success" for="ora1730">17:30</label>
                            </td>
                            <td class="tg-0lax"></td>
                            <td class="tg-0lax"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <span id="errOraProgramare"></span>
                </div>

                <div class="form-group mt-4 d-flex justify-content-center">
                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg" onclick="registerClicked();">Adaugă</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script>
        dataProgramare.min = new Date().toISOString().split("T")[0];
        dataProgramare.value = new Date().toISOString().split("T")[0];
      </script>
      <?php
        }
        else {
          echo "Nu există niciun medic. Nu puteți face o programare.";
        }
        
        $mysqli->close();
      }
      else {
        echo "Nu sunteți logat cu un cont de pacient!";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=/home\">";
      }
      ?>
    </div>
    
    <script src="/script/script.js"></script>
    <script src="/script/programari.js"></script>
    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>
    
  </body>
</html>