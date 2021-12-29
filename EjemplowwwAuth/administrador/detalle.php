<?php

if(($_SERVER["PHP_AUTH_USER"] != "admin") && ($_SERVER["PHP_AUTH_PW"] != "admin"))
{
    header('Location: ./perfil.php');
    exit;
}
    echo "Nombre: ". $_SERVER['PHP_AUTH_USER'];

?>