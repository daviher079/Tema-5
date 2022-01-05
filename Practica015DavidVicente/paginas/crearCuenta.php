


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <style>
       
        
    </style>

    <title>Crear Cuenta</title>
</head>
<body>
    <header>
        <img class="logo" src="../web-root/img/LogotipoDavid.jpg"/>
        <h1>Crear Cuenta</h1>
    </header>

    <?php
        require_once("../codigo/Funciones.php");
        require_once("./validarCrearCuenta.php");

        if(validarCuenta()==true)
        {
            mostrarPaginasUsuario($_REQUEST['user'], $_REQUEST['nCompleto']);
            header("location: ./indexPerfil.php");
        }else
        {

    ?>
    <main class="crearCuenta">
    <form action="<?php self();?>" method="post">
           
            <section>
                <label for="user">Usuario</label>
                <input type="text" name="user" placeholder="Usuario" id="user" value="<?php recordarGenerico("user")?>">
                <?php
                    if(isset($_REQUEST['crearCuenta']) && validarUsuario()==true)
                    {
                        label("No pueden existir dos usuarios con el mismo nombre");
                    }
                    comprobarGenerico("user");
                ?>
            </section>

            <section>
                <label for="nCompleto">Nombre Completo</label>
                <input type="text" name="nCompleto" placeholder="Nombre completo" id="nCompleto"  value="<?php recordarGenerico("nCompleto")?>">
                <?php
                    if(isset($_REQUEST['crearCuenta']) && expresionGenerico(PATRONNOMBRECOMPLETO, $_REQUEST['nCompleto'])==false)
                    {
                        label("El nombre introducido no es valido. Deben tener un mínimo de 3 caracteres el nombre y los 2 apellidos<br>");
                    }
                    comprobarGenerico("nCompleto");
                ?>
            </section>

            <section>
                <label for="correo">Correo electronico</label>
                <input type="mail" name="correo" placeholder="Correo electronico" id="correo" value="<?php recordarGenerico("correo")?>">
                <?php
                    comprobarGenerico("correo");
                ?>
            </section>

            <section>
                <label for="fecha">F. Nacimiento</label>
                <input type="date" name="fecha" id="fecha" value="<?php recordarGenerico("fecha")?>">
                <?php
                    comprobarGenerico("fecha");
                ?>
            </section>

            <section>
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" id="passF" value="<?php recordarGenerico("pass")?>">
                <?php
                    if(isset($_REQUEST['crearCuenta']) && validarPass()==false)
                    {
                        label("Error. Asegurese de haber introducido la misma contraseña en los dos campos<br>");
                        $_REQUEST['pass']="";
                        $_REQUEST['rPass']="";
                    }
                    comprobarGenerico("pass");
                ?>
            </section>

            <section>
                <label for="rPass">Repetir Contraseña</label>
                <input type="password" name="rPass" id="rPass" value="<?php recordarGenerico("rPass")?>">
                <?php
                    comprobarGenerico("rPass");
                ?>
            </section>
            
            <input type="submit" value="Crear cuenta" name="crearCuenta">
            

        </form>

        <?php
            }
        ?>

    </main>
    <footer>
        <p>Footer de David</p>
        <a href="../login.php"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>    