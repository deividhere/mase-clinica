<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./style/navbar.css">
    </head>
    <body>

    <ul class="topnav">
        <li>
            <div>
                <a href="#home">
                    <img class="small" src="./assets/hospital.png">
                    Clinică
                </a>
            </div>
        </li>
        <?php
        if (true)
        {
        ?>
        <li><a class="active" href="#home">Acasă</a></li>
        <?php
        }
        ?>
        <li><a href="#news">Medici</a></li>
        <li><a href="#contact">Medicamente</a></li>
        <li class="right"><a href="#user">User</a></li>
    </ul>

    </body>
</html>