<?php

if(($_SERVER["PHP_AUTH_USER"] != "david") && ($_SERVER["PHP_AUTH_PW"] != "david"))
{
    header('Location: ./perfil.php');
    exit;
}
    echo "Nombre: ". $_SERVER['PHP_AUTH_USER'];

?>