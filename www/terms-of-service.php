<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Clinică medicală</title>

    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link rel="icon" href="./assets/favicon/favicon.ico" type="image/x-icon">

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

    include "$rootDir/navbar.php";
    
    $active = 9;
    ?>

    <div class="container mt-4">
      <p class="mb-4 fw-bold fs-2 text-center">
      Termeni și Condiții de Utilizare
      </p>

      <p class="mb-1">
      Ultima actualizare: 20.05.2024
      </p>

      <p class="mb-3">
      Bine ați venit la clinica noastră medicală! Vă rugăm să citiți cu atenție acești <b>Termeni și Condiții</b> înainte de a utiliza site-ul nostru web.
      </p>

      <p class="mb-2 fw-bold fs-4">
      1. Acceptarea Termenilor
      </p>

      <p class="mb-3">
      Prin accesarea și utilizarea acestui site web, sunteți de acord să respectați și să fiți obligat de acești Termeni și Condiții. Dacă nu sunteți de acord cu acești termeni, vă rugăm să nu utilizați site-ul nostru.
      </p>

      <p class="mb-2 fw-bold fs-4">
      2. Servicii Oferite
      </p>

      <p class="mb-3">
      Site-ul nostru permite pacienților să facă programări și să acceseze diagnosticele oferite de medici. De asemenea, medicii pot vedea programările pacienților și pot înregistra diagnostice.
      </p>

      <p class="mb-2 fw-bold fs-4">
      3. Confidențialitatea Datelor
      </p>

      <p class="mb-1">
      a. Datele personale colectate pot include: nume, prenume, email, CNP, număr de telefon, informații despre asigurare (dacă pacientul are asigurare sau nu, casa de asigurări).
      </p>

      <p class="mb-3">
      b. Toate datele personale sunt colectate și utilizate în conformitate cu legislația în vigoare privind protecția datelor cu caracter personal (Regulamentul General privind Protecția Datelor - GDPR).
      </p>

      <p class="mb-2 fw-bold fs-4">
      4. Utilizarea Datelor Personale
      </p>

      <p class="mb-1">
      <b>a.</b> Datele personale colectate vor fi utilizate exclusiv pentru gestionarea programărilor, furnizarea de diagnostic și alte servicii medicale.
      </p>

      <p class="mb-3">
      <b>b.</b> Datele nu vor fi partajate cu terțe părți fără consimțământul explicit al utilizatorilor, cu excepția cazurilor prevăzute de lege.
      </p>

      <p class="mb-2 fw-bold fs-4">
      5. Responsabilitățile Utilizatorilor
      </p>

      <p class="mb-1">
      <b>a.</b> Utilizatorii sunt responsabili pentru menținerea confidențialității contului și parolei lor și pentru toate activitățile desfășurate în contul lor.
      </p>

      <p class="mb-3">
      <b>b.</b> Utilizatorii se angajează să furnizeze informații corecte și complete și să actualizeze aceste informații în mod prompt.
      </p>

      <p class="mb-2 fw-bold fs-4">
      6. Limitarea Răspunderii
      </p>

      <p class="mb-3">
      Clinica medicală nu va fi responsabilă pentru niciun prejudiciu direct, indirect, accidental sau de altă natură care rezultă din utilizarea sau incapacitatea de a utiliza site-ul nostru web sau serviciile oferite prin intermediul acestuia.
      </p>

      <p class="mb-2 fw-bold fs-4">
      7. Modificarea Termenilor
      </p>

      <p class="mb-3">
      Clinica medicală își rezervă dreptul de a modifica acești Termeni și Condiții în orice moment. Modificările vor fi efective imediat ce sunt publicate pe site-ul nostru. Vă încurajăm să revizuiți periodic acești Termeni și Condiții pentru a fi la curent cu eventualele modificări.
      </p>

      <p class="mb-2 fw-bold fs-4">
      8. Proprietatea Intelectuală
      </p>

      <p class="mb-5">
      Toate materialele de pe acest site, inclusiv texte, grafică, logo-uri, imagini, sunt proprietatea [Numele Clinicii] și sunt protejate de legile privind drepturile de autor și alte legi privind proprietatea intelectuală.
      </p>

    </div>
    
    <script src="./script/script.js"></script>
    <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
    cookieconsent.run({"notice_banner_type":"simple","consent_type":"implied","palette":"dark","language":"ro","page_load_consent_levels":["strictly-necessary","functionality","tracking","targeting"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":true,"page_refresh_confirmation_buttons":false,"website_name":"david.d0.ro","website_privacy_policy_url":"http://www.david.d0.ro"});
    });
    </script>
  </body>
</html>