<?php
    //valida si existe el usuario
    //validamos el formulario y ponemos los errores

    if(!true)
    {
        header(("Location: ../login.php?mensaje="));
        exit;
    }


    //valida si existe el usuario en la bd

    require("../seguro/datosBD.php");
    require("../funciones/consultas.php");

    $user =$_REQUEST['user'];
    $pass=$_REQUEST['pass'];

    if(valida($user, $pass))
    {
        //inicio session

        header("Location: ../paginas/menu.php");
        exit;
    }
?>