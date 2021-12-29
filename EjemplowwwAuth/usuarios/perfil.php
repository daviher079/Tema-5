<?php

    if(!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"]))
    {
        header("WWW-Authenticate: Basic Realm='Contenido Restringido'");
        header("HTTP/1.0 401 Unauthorized");
        exit;

    }

    // Si el usuario y la contraseña son correctos...

    if(($_SERVER["PHP_AUTH_USER"] == "david") && ($_SERVER["PHP_AUTH_PW"] == "david"))
    {
        header('Location: ./detalle.php');
    }else
    {
        header("WWW-Authenticate: Basic Realm='Contenido Restringido'");
        header("HTTP/1.0 401 Unauthorized");
        exit;
    }
    
?>