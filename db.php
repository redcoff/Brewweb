<?php
/**
 * Created by PhpStorm.
 * User: allia
 * Date: 07.12.2018
 * Time: 15:28
 */


$db_connect = mysqli_connect('localhost', 'root', '', 'bootstrap_php');
$query = "SET CHARSET utf8";
mysqli_query($db_connect, $query);
//if ($db_connect){
//    echo 'Pripojeni se zdarilo.';
//}
//else {
//    echo 'Pripojeni se nezdarilo.. ajajajajaj';
//}

//if ($db_connect){
//    mysqli_close($db_connect);
//}

