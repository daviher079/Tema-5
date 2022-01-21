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
    <script src="./recogerDeseoUsuario.js" ></script>
   
    <style>
        form section
        {
            margin-bottom: 37px;
        }
    </style>
    <title>Finalizar Compra</title>
</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
        <?php
            /**
             * Comprobar que la sesion ha sido iniciada antes de hacer la
             * compra si ha sido iniciada la compra se efecturá sino
             * se irá a la pantalla de login
             */

            echo "<div class='user'>";
            if(validaSession()==false)
            {
                echo "<a href='../login.php'><img src='../web-root/img/userPR15-01.png' height='50px'></a>";
            }else
            {
                echo "<h2>".$_SESSION['nombre']."</h2>";
                echo "<a href='./indexPerfil.php'><img src='../web-root/img/userPR15-01.png' height='50px'></a>";
            }
            echo "</div>";

        ?>
    </header>
    <main class="mainProducto">
    <?php
            $cadena="../web-root/";
                if(isset($_REQUEST['imagen']))
                {
                    $cadena = $cadena."imgProductosGrandes/".$_REQUEST['imagen'];
                }else
                {
                    $cadena = $cadena."img/store-window-g05f275403_1920.jpg";
                }
            ?>
        <img class ="imgProducto" src=<?php echo $cadena ?> >
        
        <?php
            
            require_once("./validarCompra.php");
            if(isset($_REQUEST['finalizarCompra']))
            {
                
                generarVenta();
                //funcion que genera una compra

                header("location: ./indexPerfil.php");

            }
            else
            {

    ?>

    <div class="datosProducto">

            <form action="<?php self();?>" method="post">
                <input type="hidden" name="codigo" id ="codigo" value="<?php echo $_REQUEST['codigo'];?>">
                <input type="hidden" name="stock" id="stock" value="<?php echo $_REQUEST['stock'];?>">
            
            <?php 

                $precioFinal = (float) $_REQUEST['precio'] * (int) $_REQUEST['unidades'];
                echo "<h1>".$_REQUEST['descripcion']."</h1>"; 
                
            ?>

            <section style=" width:240px">
                <label for="precioFinal">Precio Final</label>
                <input style="color: #c57485; width:80px;" type="text" onfocus="this.blur()" name="precioFinal" id="precioFinal" readonly="readonly" value="<?php echo $precioFinal ?>">
            </section>

            <section style=" width:240px">
                <label for="nProductos" >Nº unidades</label>
                <input style="color: #c57485; width:80px;" type="text" onfocus="this.blur()" name="nProductos" id="nProductos" readonly="readonly" value="<?php echo $_REQUEST['unidades'] ?>">
                
            </section>


                <section>
                    <input type="submit" value="Finalizar Comprar" name="finalizarCompra">
                </section>
            </form>
        </div>
        <?php
            }
        ?>

    </main>
        

    <footer>
        <p>Footer de David</p>
        <a href="../index.php"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>