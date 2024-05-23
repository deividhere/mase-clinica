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
    $active = 1;

    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$rootDir/persistentlogin.php";
    
    include "$rootDir/navbar.php";

    ?>

    <div class="container mt-4">
      <div class="mb-2">
        <p class="mb-1 fw-bold">Studenți:</p>
        <p class="mb-0">
          Andreea-Liliana Petre
        </p>
        <p class="mb-1">
          Trușcă Ionuț-David
        </p>
      </div>

      <div class="mb-2">
        <p class="mb-1 fw-bold">Cerință:</p>
        <p>
          Aplicaţie (web sau mobilă) de monitorizare complexă a unui pacient la nivelul unei unităţi medicale (programare, consultație, diagnostic, tratament), care să prevadă un sistem de eliberare şi urmărire a reţetelor, în relaţie cu unităţile farmaceutice. În faza de proiectare, se va realiza o modelare principială şi funcţională a aplicaţiei. În faza de implementare, se va realiza o bază de date a unităților și departamentelor medicale, a pacienţilor și a medicilor, precum și şi o interfaţă de utilizator (admin/medic/pacient), cu toate opţiunile şi facilităţile necesare, conform cerinţelor. Uneltele software (instrumente de modelare, limbaje de programare, medii de dezvoltare) folosite pentru realizarea aplicaţiei, inclusiv a interfeţei, sunt la alegerea proiectantului.
        </p>
      </div>
    </div>
    
    <script src="/script/script.js"></script>

    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>

    <noscript>Cookie Consent by <a href="https://www.freeprivacypolicy.com/">Free Privacy Policy Generator</a></noscript>
    <!-- End Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
  </body>
</html>