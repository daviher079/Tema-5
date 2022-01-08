<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>

    <title>Comprar Producto</title>
</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
        <?php
            
            require_once "../codigo/validaSesion.php";
            
            session_start();
            
            if(validaSession()==false)
            {
                echo "<a href='../login.php'><img src='../web-root/img/userPR15-01.png' height='50px'></a>";
            }else
            {
                echo "<a href='./indexPerfil.php'><img src='../web-root/img/userPR15-01.png' height='50px'></a>";
            }


          
            
        ?>
    </header>
    <main class="mainProducto">
        <img class ="imgProducto" src="../web-root/img/store-window-g05f275403_1920.jpg" >
        

        <?php
        
        require_once("./validarCompra.php");
        if(validarCompra()==true)
        {
            

            if(comprobarSesion()==false)
            {
                header("location: ../login.php");

            }else
            {
                generarVenta();
                
            }

                
        }
        else
        {

    ?>

        <div class="datosProducto">
            <form action="<?php self();?>" method="post">
            <input type="hidden" name="codigo" value="<?php echo $_REQUEST['codigo'];?>">
            <input type="hidden" name="stock" value="<?php echo $_REQUEST['stock'];?>">
            <input type="hidden" name="precio" value="<?php echo $_REQUEST['precio'];?>">
            
            <?php 
                echo "<h1>".$_REQUEST['descripcion']."</h1>"; 
                echo "<h2>".$_REQUEST['precio']."€</h2>";
            ?>
                <section>
                    <label for="nProductos">Nº unidades</label>
                    <input type="number" name="cantidad" id="nProductos"  min="1" value="1">
                    <?php
                        comprobarCantidad();
                    ?>
                </section>

                <section>
                    <input type="submit" value="Comprar" name="comprarProducto">
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