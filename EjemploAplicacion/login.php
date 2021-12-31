<?php
    //llamar a verifica sesion
    //validamos el formulario y ponemos los errores validar el perfil de ese usuariio

    require_once "./funciones/validaSesion.php";
   //USER u1 pass 1
   session_start();

    if(validaSession())
    {
        header("Location: ./paginas/menu.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <title>Document</title>
</head>
<body>

    <header>
        <img class="logo" src="../web-root/img/LogotipoDavid.jpg"/>
        <h1>Login</h1>
    </header>
    <main class="loginSesiones">
        
        <form action="./funciones/valida.php" method="post">
            <section>
                <label for="user">Usuario</label><input type="text" name="user" id="user">
            </section>

            <section>
                <label for="pass">Password</label><input type="password" name="pass" id="pass">
            </section>
            
            <input type="submit" value="Login" name="valida">
        </form>
    </main>
</body>
</html>

