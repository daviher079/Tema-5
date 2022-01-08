<?php
    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");
    }

    //y sino te llevo al login y exit
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <title>Modificar Perfil</title>

    <style>
        .mainModPerfil
        {
            padding: 40px;
        }

        .mainModPerfil h2
        {
            color: #d02b4d;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 2.5em;
            margin-bottom: 25px;
        }

        .mainModPerfil h4 
        {
            color: #d02b4d;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 1.5em;
            margin-bottom: 45px;
        }

        .mainModPerfil form 
        {
            border: 3px solid #d02b4d;
            padding: 90px 150px;
            border-radius: 25px;
        }

        .mainModPerfil form section label
        {
            width: 140px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: #d02b4d;
            float: left;
            text-align: left;
            padding: 2px;
        }
    </style>
</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
       <a href="./indexPerfil.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
    </header>
    

    <main class="mainModPerfil">
        <h2>Modificar perfil</h2>
        <h4><?php echo $_SESSION['nombre'] ?></h4>
        

    
    <?php
        require_once("../codigo/Funciones.php");
        require_once("./validarModPerfil.php");

        if(validarModificacion()==true)
        {
            /*mostrarPaginasUsuario($_REQUEST['user'], $_REQUEST['nCompleto']);
            header("location: ./indexPerfil.php");*/
        }else
        {

    ?>    


    <form action="<?php self();?>" method="post" id="formModPerfil">
           <?php 
                $arrayDatos = extraerDatosUsuario($_SESSION['usuario']);
                echo $arrayDatos[0]."<br>";
                echo $arrayDatos[1]."<br>";
                echo $arrayDatos[2]."<br>";
           ?>
            <section>
                <label for="user">Usuario</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="user" placeholder="Usuario" id="user" readonly="readonly" value="<?php echo $_SESSION['usuario'] ?>">
            </section>

            <section>
                <label for="nCompleto">Nombre Completo</label>
                <input type="text" name="nCompleto" placeholder="Nombre completo" id="nCompleto"  value="<?php recordarGenerico("nCompleto",$arrayDatos[0])?>">
                <?php
                    if(isset($_REQUEST['modificarPerfil']) && expresionGenerico(PATRONNOMBRECOMPLETO, $_REQUEST['nCompleto'])==false)
                    {
                        label("El nombre introducido no es valido. Deben tener un mínimo de 3 caracteres el nombre y los 2 apellidos<br>");
                    }
                    comprobarGenerico("nCompleto");
                ?>
            </section>

            <section>
                <label for="correo">Correo electronico</label>
                <input type="mail" name="correo" placeholder="Correo electronico" id="correo" value="<?php recordarGenerico("correo",$arrayDatos[1])?>">
                <?php
                    comprobarGenerico("correo");
                ?>
            </section>

            <section>
                <label for="fecha">F. Nacimiento</label>
                <input type="date" name="fecha" id="fecha" value="<?php recordarGenerico("fecha", $arrayDatos[2])?>">
                <?php
                    comprobarGenerico("fecha");
                ?>
            </section>

            <section>
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" id="passF" value="<?php recordarPass("pass")?>">
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
                <input type="password" name="rPass" id="rPass" value="<?php recordarPass("rPass")?>">
                <?php
                    comprobarGenerico("rPass");
                ?>
            </section>
            
            <input type="submit" value="Modificar perfil" name="modificarPerfil">
            

        </form>

        <?php
            }
        ?>
    </main>
    
</body>
</html>