<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/style/navbar.css">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <?php
            if (session_id() == "")
                session_start();
        ?>

        <!-- Navigation bar -->
        <ul class="topnav" id="myTopnav">
            <li><div class="px-2 px-auto" style="display: flex; align-items: center; height: 52px;"><img src="/assets/hospital.png" class="small"></div></li>
            <li><a href="/home" class="<?php if ($active == 1) {echo "active";}?>">Clinică</a></li>
            <li><a href="/medici" class="<?php if ($active == 2) {echo "active";}?>">Medici</a></li>
            <li><a href="/medicamente" class="<?php if ($active == 3) {echo "active";}?>">Medicamente</a></li>
            <li class="right">
                <?php 
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        // echo "Welcome to the member's area, " . htmlspecialchars($_SESSION['username']) . "!";
                ?>
                    <button class="btn-navbar<?php if ($active == 9) {echo " active";};?>" data-bs-toggle="modal" data-bs-target="#myModalUser">
                <?php
                    echo $_SESSION["nume"];
                ?>
                    </button>
                <?php
                    } 
                    else 
                    {
                ?>
                    <button class="btn-navbar<?php if ($active == 9) {echo " active";};?>" data-bs-toggle="modal" data-bs-target="#myModal">
                        Autentificare
                    </button>
                <?php
                    }
                ?>
            </li>
            <li class="icon">
                <a href="javascript:void(0);"  onclick="toggleNavbar()">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <h2 class="modal-title w-100 ms-4"><i class="fa fa-lock"></i> Autentificare</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                <form action="/login" method="post" id="loginForm" role="form">
                    <div class="mb-3">
                        <label for="emailLogin"><i class="fa fa-user"></i> E-mail</label>
                        <input type="text" class="form-control" id="emailLogin" name="emailLogin" placeholder="Introduceți adresa de e-mail">
                    </div>
                    
                    <div class="mb-1">
                        <label for="passwordLogin"><i class="fa fa-eye"></i> Parolă</label>
                        <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Introduceți parola">
                    </div>

                    <div class="mb-2">
                        <input type="checkbox" onclick="showPass()" id="showpass" name="showpass">
                        <p class="mb-1 d-inline">Afișare parolă</p>
                    </div>
                    
                    <div class="checkbox">
                        <label><input type="checkbox" class="me-1" id="rememberLogin" name="rememberLogin" autocomplete="off" checked>Ține minte sesiunea</label>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success btn-block" style="background-color: #5cb85c; border-color: #5cb85c;"> Autentificare</button>
                    </div>

                </form>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-between w-100">
                        <div class="col-4">
                            <button class="btn btn-danger btn-default" data-bs-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Anulare</button>
                        </div>
                        <div class="col-sm-auto">
                            <p class="text-end my-0">Nu sunteți membru?</p> <p p class="text-end"><a href="/register">Înregistrare</a></p>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
        </div> 

        <!-- Modal User -->
        <div class="modal fade" id="myModalUser" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <h2 class="modal-title w-100 ms-4"><i class="fa fa-lock"></i> <?php echo ucfirst($_SESSION["userType"]); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <p class="mb-3">
                        Sunteți logat ca <b><?php echo $_SESSION["nume"] . " " . $_SESSION["prenume"]; ?></b>.
                    </p>

                    <?php
                    if (!strcmp($_SESSION["userType"], "pacient"))
                    {
                    ?>
                        <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Vizualizare
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#">Programări</a></li>
                                <li><a class="dropdown-item" href="#">Diagnostic</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-outline-success"><i class="fa fa-user" aria-hidden="true"></i> Detalii cont</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location = '/logout';"><i class="fa fa-unlink" aria-hidden="true"></i> Deconectare</button>
                        </div>
                    <?php
                    }
                    else if (!strcmp($_SESSION["userType"], "medic")) {
                    ?>
                        <div class="btn-group mb-2" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Vizualizare
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#">Programări</a></li>
                                <li><a class="dropdown-item" href="#">Diagnostic</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-outline-success"><i class="fa fa-user" aria-hidden="true"></i> Detalii cont</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location = '/logout';"><i class="fa fa-unlink" aria-hidden="true"></i> Deconectare</button>
                        </div>
                    <?php
                    }
                    else {
                        // unknown user type! Logout?
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-between w-100">
                        <div class="col-4">
                            <button class="btn btn-outline-danger btn-default" data-bs-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Anulare</button>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
        </div> 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="/script/navbar.js"></script>
    </body>
</html>