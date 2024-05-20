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

    $active = 2;

    include "$rootDir/navbar.php";
    
    ?>

    <div class="container mt-4">
      <?php
        include "$rootDir/sqlinit.php";

        // Create connection
        $mysqli = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($mysqli->connect_error) {
          die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
        }
        
        if (isset($_GET["id"])) {
          ?>
          <p class="text-center h2 fw-bold mb-2 mx-1 mx-md-4 mt-4">Vizualizare medic</p>
          <?php
          $sql = "SELECT nume, prenume, specializare, email, telefon_cabinet FROM medici WHERE idmedic = ?";
          $stmt = $mysqli->prepare($sql);

          $stmt->bind_param("s", $_GET["id"]);
          $stmt->execute();

          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);

            echo "Nume: " . $row["nume"] . "<br>";
            echo "Prenume: " . $row["prenume"] . "<br>";
            echo "Specializare: " . $row["specializare"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "Telefon cabinet: " . $row["telefon_cabinet"] . "<br>";
          }
          else {
            echo "Nu s-a găsit niciun medic cu ID-ul specificat";
          }
        }
        else {
          $sql = "SELECT idmedic, nume, prenume, specializare, email, telefon_cabinet FROM medici ORDER BY nume";
          $stmt = $mysqli->prepare($sql);
  
          $stmt->execute();
  
          $result = $stmt->get_result();
  
          if ($result->num_rows > 0) {
            $i = 1;
            ?>
            <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nume</th>
                <th scope="col">Prenume</th>
                <th scope="col">Specializare</th>
                <th scope="col">E-Mail</th>
                <th scope="col">Telefon cabinet</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<tr class=\"clickable\" onclick=\"showDetails(". $row["idmedic"] .")\">";
                  echo "<th scope=\"row\">$i</th>";
                  echo "<td>" . $row["nume"] . "</td>";
                  echo "<td>" . $row["prenume"] . "</td>";
                  echo "<td>" . $row["specializare"] . "</td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["telefon_cabinet"] . "</td>";
                  echo "</tr>";
                  $i++;
                }
              ?>
            </tbody>
          </table>
            <?php
          }
          else {
            echo "Nu a fost găsit niciun medic.";
          }
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
    <script type="text/javascript">
    function showDetails(id)
    {
      window.location = '/medici?id='+id;
    }
    </script>
  </body>
</html>