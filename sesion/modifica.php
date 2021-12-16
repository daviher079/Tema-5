<?php
    session_start();
    //validar que hay sesion
    //enviar al login
    //validar que se ha enviado el desde el formulario 
    //hacer lo que nos haya pedido

    if(!isset($_SESSION['valida']))
    {
        header("Location: ./login.php");
        exit;
    }

    if(count($_POST)==0)
    {
        header("Location: ./detalle.php");
    }
    else
    {
        if(isset($_POST['crear']) || isset($_POST['reset']))
        {
            $_SESSION['contador']=0;
        }elseif(isset($_POST['sumar']))
        {
            $_SESSION['contador']++;
        }else
        {
            $_SESSION['contador']--;
        }

        header("Location: ./detalle.php");
        exit;
    }
?>