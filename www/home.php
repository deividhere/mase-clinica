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
    session_start();
    $active = 1;
    include './navbar.php';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      echo "Welcome to the member's area, " . htmlspecialchars($_SESSION['username']) . "!";
    } else {
      echo "Please log in first to see this page.";
    }
    ?>

    <div class="container mt-4">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sagittis vulputate urna non placerat. Mauris mollis egestas risus id iaculis. Vestibulum id tellus mollis, scelerisque lectus a, consequat augue. Vestibulum eleifend diam faucibus nisi consectetur vehicula. Donec vitae neque sed nibh blandit ornare. Sed a imperdiet quam, ut posuere ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus laoreet diam a tincidunt malesuada. Vestibulum at dignissim purus, quis ultricies urna.

      Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam nisl libero, sodales eget erat vel, molestie aliquam metus. Donec cursus cursus eros vel suscipit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus porta placerat enim, quis tincidunt metus sollicitudin sed. Donec ultricies arcu ut diam porttitor tempor. Sed a eros ac ante cursus tincidunt. Quisque pretium quis neque quis venenatis. Etiam efficitur mauris leo, sit amet tincidunt urna ullamcorper in. Phasellus at sem et purus pharetra fermentum sit amet at purus. Fusce vulputate lacus nec quam commodo congue.

      Pellentesque in tellus nunc. Praesent nec erat sit amet nulla hendrerit pharetra. Quisque nisl nibh, semper eu libero sit amet, placerat porttitor nisl. Sed mattis id velit at volutpat. Etiam a tortor viverra, mattis dui in, pulvinar dolor. Donec et est non sapien pellentesque pellentesque. Sed id tristique velit, non porttitor risus. Vivamus at sapien et dui dapibus finibus. Proin nec dui neque. Vestibulum vitae eros sit amet nisi varius malesuada et nec nunc. Aliquam quis nunc nec nisi tincidunt scelerisque. Vivamus nec purus in felis congue volutpat. Nullam ultricies elementum accumsan. Suspendisse dolor arcu, ornare nec laoreet at, vehicula nec nibh.

      Integer dignissim lacus vel augue pellentesque tincidunt. Proin nec finibus lacus, eu aliquet odio. Pellentesque cursus convallis felis, et facilisis ligula venenatis et. Nunc in metus sit amet lacus pharetra pretium et at augue. Donec quis risus sapien. Nam ultrices id quam in hendrerit. Nunc a turpis vel nunc ultricies mattis ut in ipsum. Cras dignissim vehicula augue, in mollis lectus placerat eu. Nullam varius eu magna a consectetur. Cras in semper justo. Nulla lorem leo, hendrerit id ipsum eget, vulputate tempor lectus.

      Nunc et aliquet metus, quis consequat massa. Quisque semper mauris id magna sollicitudin efficitur. Ut nec dolor libero. Vivamus id malesuada ipsum, sit amet egestas mauris. In quis elit id ipsum blandit laoreet. Vestibulum imperdiet ullamcorper luctus. Etiam blandit sem at facilisis luctus.

      Proin nec velit ultricies, porttitor magna nec, consectetur turpis. Fusce molestie nisi et egestas condimentum. Suspendisse hendrerit sapien nec enim porttitor placerat. Etiam lobortis quis nisl in lobortis. Donec laoreet condimentum erat. Donec sed nulla sit amet leo suscipit varius. Duis tristique non ante viverra tincidunt. Integer ut bibendum leo, convallis feugiat justo. Suspendisse ut sem arcu. Suspendisse potenti. Ut facilisis consequat dui at efficitur. Phasellus facilisis, dui vel commodo convallis, quam ex volutpat tortor, eget tristique ipsum dolor sed dui.

      Nam congue neque eu egestas fermentum. Donec eu malesuada magna. Morbi consectetur felis non tortor volutpat, at faucibus nunc congue. Vivamus nec lorem eget mauris feugiat mollis sit amet nec ex. Donec mattis, elit a ultricies pretium, felis ante dapibus neque, nec rutrum est leo quis ante. Nam blandit molestie odio. Suspendisse potenti. Mauris vestibulum magna mauris. Nam tristique, risus at facilisis ullamcorper, ligula quam rutrum arcu, id maximus quam elit in massa. Nunc eleifend ac lorem non molestie. Fusce eu ipsum a nunc suscipit tristique vitae sit amet nisl. Duis varius consectetur magna quis mattis. Donec lacinia, purus sed consectetur finibus, dui urna eleifend ante, ut mattis quam lacus nec nunc. Pellentesque maximus aliquet fringilla. Proin et arcu eget augue fermentum pretium.

      Phasellus molestie, odio non egestas vulputate, diam sapien ornare mi, eu pulvinar odio velit quis metus. Sed sed enim malesuada, pretium nulla ut, lacinia orci. Morbi sodales vel ligula nec venenatis. Aliquam id pharetra tortor, in rutrum nunc. Integer lectus nisl, porttitor id pretium at, vulputate eu nibh. Maecenas condimentum volutpat dui, eu venenatis sapien venenatis nec. Morbi viverra, nibh sed rhoncus dignissim, felis leo posuere mi, ac accumsan urna magna in ligula. Duis in mollis nisi. Mauris sed est ligula.

      Morbi in arcu dapibus, posuere quam vitae, iaculis enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc quis fringilla nunc. Fusce id libero vel velit cursus luctus id eget erat. Pellentesque nisi lorem, convallis sit amet iaculis quis, egestas mattis justo. Suspendisse vel feugiat libero, sit amet cursus enim. Pellentesque nec metus diam. Suspendisse id nulla consequat, porttitor est efficitur, hendrerit justo. Vivamus malesuada diam ut tellus placerat, nec sagittis mi luctus. Pellentesque vitae nunc nunc. Sed ac pellentesque massa. Integer egestas aliquam erat, vitae elementum magna dictum vel. Nullam venenatis fermentum tincidunt. Curabitur a mauris convallis, ornare sem quis, dignissim velit.

      Pellentesque aliquam posuere ultrices. Donec ullamcorper pharetra laoreet. Donec metus metus, luctus vel sagittis in, congue nec odio. Curabitur in urna justo. Quisque auctor tincidunt nunc, non lobortis nibh fermentum sit amet. Morbi condimentum vulputate mi, eu condimentum risus scelerisque id. Aliquam maximus metus consectetur arcu dignissim, vitae elementum tellus cursus. Vivamus nec enim hendrerit, lacinia sapien nec, facilisis ligula. Pellentesque malesuada, neque eu mattis luctus, elit tellus finibus eros, eu eleifend urna mauris sit amet nibh. Sed vel lacinia purus. Pellentesque ac molestie neque, in pulvinar risus. Vestibulum ultricies sapien ipsum, sit amet maximus lorem lacinia id.

      Phasellus scelerisque, metus non lobortis semper, purus purus elementum ligula, eget aliquam magna ligula auctor nisl. Phasellus tincidunt, dui ut mattis placerat, felis tortor finibus tortor, id ullamcorper urna ligula sed neque. Cras sit amet commodo dui, at ullamcorper eros. Fusce at ullamcorper nisl, sit amet porta mi. Nam pretium elit in dolor suscipit vestibulum. Donec malesuada venenatis turpis, a laoreet odio dapibus ac. Phasellus tortor arcu, congue vitae ante et, luctus maximus arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut dictum nisl sit amet tincidunt rhoncus. Nulla at dapibus sem. Suspendisse potenti. Duis sagittis enim nec elementum feugiat. Nam justo erat, facilisis et consectetur efficitur, venenatis non lectus. Aenean a arcu at urna rutrum fringilla. Sed velit sem, hendrerit pretium varius vitae, mollis ut est.

      Curabitur neque lacus, eleifend ut sem vitae, congue tincidunt sapien. Sed ut nisl a sem consequat dictum in sed est. Morbi egestas neque aliquet nibh condimentum, nec ullamcorper felis finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed sodales tristique dui, non efficitur mi ultricies eu. Proin tincidunt quam erat, eu efficitur nisl suscipit et. Proin ac magna in sapien sagittis dignissim. Aliquam ut lacus metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut aliquet scelerisque porta. Nam sit amet lacus tortor. Sed nec dolor vulputate, vehicula lorem quis, laoreet massa. Donec ut consequat lorem, non vestibulum tortor.

      Nulla porttitor libero ut venenatis interdum. Nulla lorem mauris, dignissim at sapien ut, dapibus vehicula odio. Aliquam auctor ac dolor sit amet malesuada. Donec aliquet nunc ac eros malesuada, eu auctor nunc suscipit. Proin et porttitor dolor, sit amet eleifend felis. Aenean commodo faucibus bibendum. Vivamus vitae efficitur lorem. Cras massa dui, convallis id nulla ac, pellentesque ultrices ligula. Vivamus at massa ultricies, viverra nibh sit amet, posuere ligula. Duis consectetur tincidunt massa, id scelerisque tellus dapibus eget. Nulla facilisi. Praesent euismod vestibulum mi, nec commodo tortor accumsan in. Aenean finibus, magna in bibendum euismod, justo velit euismod libero, id venenatis libero eros in libero. Cras eleifend, erat eu bibendum congue, dolor orci eleifend nisi, nec facilisis nibh nunc tempus erat. Suspendisse in commodo ipsum. Quisque eget arcu in magna vulputate condimentum.

      Aenean faucibus et orci at lacinia. Curabitur posuere lacus vel ante porta, eget posuere felis commodo. Morbi felis enim, condimentum accumsan fringilla a, tincidunt nec enim. Vestibulum quis sapien vitae erat blandit commodo. Proin urna diam, tristique et gravida at, eleifend vitae nisi. Curabitur eget sodales risus. Ut rutrum bibendum elit, ut condimentum mauris ultricies quis. Nulla facilisi. Nullam sit amet blandit nulla.

      Donec porta metus sit amet auctor cursus. In et tincidunt risus. Pellentesque iaculis neque id viverra hendrerit. Vestibulum consequat efficitur turpis vel rutrum. Nunc elementum venenatis quam eget vehicula. Mauris rhoncus aliquet dictum. Maecenas tincidunt metus felis, sed placerat felis vehicula et. Nam vulputate venenatis augue, id aliquam odio feugiat convallis. In tempus tincidunt dui et tincidunt. Etiam quis eros fermentum, faucibus mauris quis, tincidunt dolor. Sed congue sit amet sem sit amet sagittis. Sed purus tortor, venenatis nec congue non, malesuada ac leo. Nunc laoreet porta nunc sit amet maximus.

    </div>
    
    <script src="./script/script.js"></script>

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