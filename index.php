<?php
session_start();
require_once "db.php";
include "utils/passwordUtils.php";
include "alert.php";
?>

<?php

//Odstranění redundantní cesty z proměnné $PATH
$request  = $_SERVER['REQUEST_URI'];

// Rozdělení cesty podle "/" a zbavení $_GET parametru
$request = explode('?', $request)[0];
$params = explode("/", $request);


//Záložky v menu
$safe_pages = array("login", "homepage", "register", "logout", "coffee", "contact", "map", "api", "stylechange", "mapadd");

//deklarace
$page = null;
$alert = new Alert();

//Načtení požadované stránky
if(in_array($params[1], $safe_pages)) { //Pokud se vyskytuje rozdělená cesta v poli záložek
    include("/pages/".$params[1].".php");
    $page = new $params[1]; //načte se požadovaná stránka
} elseif ($params[1] == '' && sizeof($params) == 2) { //Pokud rozdělená cesta je "prázdná" a pole cest se rovná 2 (tzn za adresou brewweb za lomítkem je prázdný string
    include("/pages/homepage.php");
    $page = new homepagePage(); // načte se hlavní stránka
} else {
    include("/pages/404.php"); //Pokud je to neznámá cesta, která není prázdná a není v poli záložek
    $page = new Error404Page(); // načte se error stránka
}
?>

<!doctype html>
<html lang="en" class="<?php if(isset($_COOKIE["background"])) echo($_COOKIE["background"]); ?>">
<?php
//Hlavička
include "head.php";
?>
<!-- Body -->
<body class="<?php if(isset($_COOKIE["background"])) echo($_COOKIE["background"]); ?>">
<?php
//render alertu (např. při přihlášení, registrace apod.)
$alert->render();
//navbar
include "navbar.php";
?>

<?php
//render stránky
$page->render();
?>
<!-- Patička -->
<?php
include "footer.php";
?>


<!-- script -->
<script src="/script.js"></script>
</body>
</html>