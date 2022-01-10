<?php
    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");  
    }elseif($_SESSION['perfil']=='USR01' || $_SESSION['perfil']=='MOD01')
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
        <title>Modificar Albaran</title>
    </head>
    <body>
        <header class="cabecera">
        <h1>Tienda Online</h1>
        <a href="./mostrarAlbaranes.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </header>


        <main class="mainModPerfil">
            <h2>Modificar albaran</h2>
            <h4><?php echo $_SESSION['nombre'] ?></h4>
        <?php
            require_once("./validarModificarAlbaranes.php");
            require_once("../codigo/Funciones.php");
            
            if(validarModificacion()==true)
            {
                header("location: ./mostrarAlbaranes.php");
            }else
            {
                $arrayDatos=recuperarAlbaran($_REQUEST['codigo']);
                

        ?>    

        <form action="<?php self();?>" method="post">
            <input type="hidden" name="cantidadArray" value="<?php echo $arrayDatos[3];?>">
            
            <section>
                <label for="idAlbaran">Id Albaran</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="idAlbaran" id="idAlbaran" readonly="readonly" value="<?php echo $arrayDatos[0] ?>">
            </section>

            <section>
                <label for="fecha">F. Albaran</label>
                <input type="date" name="fecha" id="fecha" value="<?php recordarGenerico("fecha",$arrayDatos[1])?>">
                
                <?php
                    comprobarGenerico("fecha");
                ?>
            </section>

            <section>
                <label for="codigoProducto">C. Producto</label>
                <input style="color: #c57485;" type="text" name="codigoProducto" onfocus="this.blur()" id="codigoProducto" value="<?php recordarGenerico("codigoProducto", $arrayDatos[2]) ?>">
                <?php
                    comprobarGenerico("codigoProducto");
                ?>
            </section>

            
            <section>
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" value="<?php recordarGenerico("cantidad",$arrayDatos[3])?>">
                
                <?php
                    comprobarGenerico("cantidad");
                ?>
            </section>
            <section>
                <label for="usuario">Usuario</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="usuario" id="usuario" readonly="readonly" value="<?php echo $arrayDatos[4]?>">
                
            </section>
            
            
            <input type="submit" value="Modificar Albaran" name="modificarAlbaran">
                

            </form>

            <?php
                }
            ?>
        </main>

    </body>
</html>