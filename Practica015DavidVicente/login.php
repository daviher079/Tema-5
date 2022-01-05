<?php
    //llamar a verifica sesion
    //validamos el formulario y ponemos los errores validar el perfil de ese usuariio

    require_once "./codigo/validaSesion.php";
   
    session_start();

    if(validaSession())
    {
        header("Location: ./paginas/mostrarProductos.php");
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

    <header>
        <img class="logo" src="./web-root/img/LogotipoDavid.jpg"/>
        <h1>Login</h1>
    </header>
    <main class="loginSesiones">
        <?php
            require("./seguro/datosBD.php");
            require("./codigo/consultas.php");
            require("./codigo/Funciones.php");

         
            
            crearFormulario();
            
            if(valida())
            {
                //inicio session
        
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