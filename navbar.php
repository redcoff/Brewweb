<?php
//Odstranění redundantní cesty z proměnné $PATH
$request  = $_SERVER['REQUEST_URI'];

// Rozdělení cesty podle "/"
$params = explode("/", $request);
?>
<header class="masthead mb-auto pt-3 ">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <h3 class="masthead-brand m-0">BrewWeb</h3>
            </div>
            <div class="col-sm-10 d-print-none">
                <nav class="nav nav-masthead justify-content-end">
                    <a class="nav-link <?php if($params[1] == 'homepage' || ($params[1] == '' && sizeof($params) == 2)) echo 'active' ?>" href="/">Domov</a>
                    <a class="nav-link <?php if($params[1] == 'coffee') echo 'active' ?>" href="/coffee">Alternativní přípravy kávy</a>
                    <a class="nav-link <?php if($params[1] == 'map') echo 'active' ?>" href="/map">Mapa kaváren</a>
                    <a class="nav-link <?php if($params[1] == 'contact') echo 'active' ?>" href="/contact">Kontakt</a>
                    <a class="nav-link <?php if(isset($_SESSION['valid']) && $_SESSION['valid']) echo 'd-none'?> <?php if($params[1] == 'login') echo 'active' ?>" href="/login">Přihlásit se</a>
                    <a class="nav-link <?php if(!isset($_SESSION['valid']) || !$_SESSION['valid']) echo 'd-none'?> <?php if($params[1] == 'logut') echo 'active' ?>" href="/logout">Odhlásit se</a>
                </nav>
            </div>
        </div>
    </div>
 </header>