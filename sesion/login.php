<?php
    /*session_start();
    print_r($_SESSION);
    $_SESSION['var1']="Mi primera Sesión entrando por 3 vez";
    //Para hacer un log out
    session_destroy();
    print_r($_SESSION);
    echo session_name();

    echo session_id();*/

    //Siempre es necesario un session_start();
    session_start();

    if(isset($_REQUEST['valida']))
    {
        //Validar que el usuario esté en la base de datos y la Contraseña
        // comprobar que no está vacio y contraseña 8 caracteres

        if($_REQUEST['user']=='david' && $_REQUEST['pass']=='david')
        {
            $_SESSION['user']=$_REQUEST['user'];
            $_SESSION['pass']=$_REQUEST['pass'];
            $_SESSION['validada']= true;
            header("Location: ./detalle.php");
            exit;

        }
    }else
    {
        if(isset($_SESSION['validada']))
        {
            header("Location: ./detalle.php");
        }else{

    


    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <title>Ejemplo Sesiones Login</title>
</head>
<body>
    <header>
        <img class="logo" src="../web-root/img/LogotipoDavid.jpg"/>
        <h1>Ejemplo Sesiones Login</h1>
    </header>
    <main class="loginSesiones">
        <form action="./login.php" method="post">
            <section>
                <label for="user">Usuario</label><input type="text" name="user" id="user">
            </section>
            <section>
                <label for="pass">Password</label><input type="password" name="pass" id="pass">
            </section>

            <input type="submit" value="Login" name="valida">
        </form>
    </main>
    <footer>
        <p>Footer de David</p>
        <a href="../index.html"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>

<?php

}

}
?>
