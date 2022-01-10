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
        <title>Modificar Venta</title>
    </head>
    <body>
        <header class="cabecera">
        <h1>Tienda Online</h1>
        <a href="./mostrarVentas.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </header>


        <main class="mainModPerfil">
            <h2>Modificar venta</h2>
            <h4><?php echo $_SESSION['nombre'] ?></h4>
        <?php
            require_once("./validarModificarVentas.php");
            require_once("../codigo/Funciones.php");
            
            if(validarModificacion()==true)
            {
                header("location: ./mostrarVentas.php");
            }else
            {
                $arrayDatos=recuperarVenta($_REQUEST['codigo']);

        ?>    

        <form action="<?php self();?>" method="post">

            <input type="hidden" name="cantidadArray" value="<?php echo $arrayDatos[4];?>">
            <section>
                <label for="idVenta">Id Venta</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="idVenta" id="idVenta" readonly="readonly" value="<?php echo $arrayDatos[0] ?>">
            </section>

            <section>
                <label for="usuario">Usuario</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="usuario" id="usuario" readonly="readonly" value="<?php echo $arrayDatos[1]?>">
                
            </section>

            <section>
                <label for="fecha">F. Compra</label>
                <input type="date" name="fecha" id="fecha" value="<?php recordarGenerico("fecha",$arrayDatos[2])?>">
                
                <?php
                    comprobarGenerico("fecha");
                ?>
            </section>

            <section>
                <label for="codigoProducto">C. Producto</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="codigoProducto" id="codigoProducto" readonly="readonly" value="<?php echo $arrayDatos[3]?>">
                
            </section>

            <section>
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" value="<?php recordarGenerico("cantidad",$arrayDatos[4])?>">
                
                <?php
                    comprobarGenerico("cantidad");
                ?>
            </section>

            <section>
                <label for="precio">P. Total</label>
                <input style="color: #c57485;" type="text" onfocus="this.blur()" name="precio" id="precio" readonly="readonly" value="<?php echo $arrayDatos[5]?>">
                
            </section>
            
            <input type="submit" value="Modificar Venta" name="modificarVenta">
                

            </form>

            <?php
                }
            ?>
        </main>

    </body>
</html>