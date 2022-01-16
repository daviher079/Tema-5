<?php

require("./seguro/datosBD.php");
            require("./codigo/consultas.php");
            require("./codigo/Funciones.php");

    if(isset($_COOKIE['recuerdame']))
    {
        $user=$_COOKIE['recuerdame'][0];
        $pass=$_COOKIE['recuerdame'][1];

        if(recuperarDatos($user, $pass)==true)
        {
            header("Location: ./paginas/indexPerfil.php");

        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>
    <title>Login</title>
</head>
<body>

    <header class="cabecera">
       <h1>Tienda Online</h1>
       
    </header>
    <main class="loginSesiones">
        <?php
            

            crearFormulario();
            
            if(valida())
            {
                //inicio session
                recuerdame();
                header("Location: ./paginas/indexPerfil.php");
                exit;
            }else
            {
                
        ?>
        <form action="<?php self();?>" method="post">
            <?php
                if(isset($_REQUEST['user']) && isset($_REQUEST['pass']) && valida()==false)
                {
                    echo "<p>Error. Usuario o contraseña incorrectos</p>";
                }
            
            ?>
            <section>
                <label for="user">Usuario</label><input type="text" name="user" id="user">
            </section>

            <section>
                <label for="pass">Password</label><input type="password" name="pass" id="pass">
            </section>
            <section>
                <label for="recordarme">Recordarme</label> <input type="checkbox" name="recordarme" id="recordarme">
            </section>
            
            <input type="submit" value="Crear cuenta" name="crearCuenta">
            <input type="submit" value="Login" name="valida">

        </form>

        <?php
                
            }
        
        ?>
    </main>
    <footer>
        <p>Footer de David</p>
        <a href="./index.php"><img src="./web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>