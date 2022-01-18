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
        
    </style>
</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
       <div class='user'>
        <?php
            echo "<h2>".$_SESSION['nombre']."</h2>";
        ?>    
            <a href="../index.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </div>
    </header>
    
    <div style="display: flex;">

        <aside>
            
            <?php
            echo"<ul>";
            /**
             * Se recorren las páginas a las que puede acceder al usuario
             */
            foreach ($_SESSION['paginas'] as $key => $value) {
                echo" <li><a class='boton' href='./".$value."'>".$key."</a> </li>";
            }
            echo "</ul>";    
            ?>
        </aside>  
        <main class="mainModPerfil">
            
            <h2>Modificar perfil</h2>
        <?php
            require_once("../codigo/Funciones.php");
            require_once("./validarModPerfil.php");

            if(validarModificacion()==true)
            {
                
                header("location: ./indexPerfil.php");
            }else
            {

        ?>   

        <form action="<?php self();?>" method="post" id="formModPerfil">
            <?php 
                    $arrayDatos = extraerDatosUsuario($_SESSION['usuario']);
            ?>
            <input type="hidden" name="passArray" value="<?php echo $arrayDatos[0];?>">
                <section>
                    <label for="user">Usuario</label>
                    <input style="color: #c57485;" type="text" onfocus="this.blur()" name="user" placeholder="Usuario" id="user" readonly="readonly" value="<?php echo $_SESSION['usuario'] ?>">
                </section>

                <section>
                    <label for="nCompleto">N. Completo</label>
                    <input type="text" name="nCompleto" placeholder="Nombre completo" id="nCompleto"  value="<?php recordarGenerico("nCompleto",$arrayDatos[1])?>">
                    <?php
                        if(isset($_REQUEST['modificarPerfil']) && expresionGenerico(PATRONNOMBRECOMPLETO, $_REQUEST['nCompleto'])==false)
                        {
                            label("El nombre introducido no es valido. Deben tener un mínimo de 3 caracteres el nombre y los 2 apellidos<br>");
                        }
                        comprobarGenerico("nCompleto");
                    ?>
                </section>

                <section>
                    <label for="correo">C. Electronico</label>
                    <input type="mail" name="correo" placeholder="Correo electronico" id="correo" value="<?php recordarGenerico("correo",$arrayDatos[2])?>">
                    <?php
                        comprobarGenerico("correo");
                    ?>
                </section>

                <section>
                    <label for="fecha">F. Nacimiento</label>
                    <input type="date" name="fecha" id="fecha" value="<?php recordarGenerico("fecha", $arrayDatos[3])?>">
                    <?php
                        comprobarGenerico("fecha");
                    ?>
                </section>

                <section>
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" id="passF" value="<?php recordarPass("pass")?>">
                    <?php

                        if(isset($_REQUEST['modificarPerfil']))
                        {
                            $passFormu=sha1($_REQUEST['pass']);
                            if($passFormu==$_REQUEST['passArray'])
                            {
                                label("Error no puede introducir la misma contraseña que ya tenía<br>");
                            }
                            elseif(validarPass()==false)
                            {
                                label("Error. Asegurese de haber introducido la misma contraseña en los dos campos<br>");
                                $_REQUEST['pass']="";
                                $_REQUEST['rPass']="";

                            }
                        }
                        comprobarGenerico("pass");
                    ?>
                </section>

                <section>
                    <label for="rPass">Rep. Contraseña</label>
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
    </div>
    
    
</body>
</html>