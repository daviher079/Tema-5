
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <script src="./recogerDeseoUsuario.js" ></script>
   
    
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
            require_once "../codigo/validaSesion.php";
            
            session_start();
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
        <img class ="imgProducto" src="../web-root/img/store-window-g05f275403_1920.jpg" >
        
        <?php
            
            require_once("./validarCompra.php");
            if(validarCompra()==true)
            {
                //si la compra es correcta se comprueba si la sesion ha
                //ya ha sido validada si ha sido validada se genera la venta
                //sino te lleva login

                if(comprobarSesion()==false)
                {
                    header("location: ../login.php");

                }else
                {
                    generarVenta();
                    //funcion que genera una compra

                    header("location: ./indexPerfil.php");
                }

            }
            else
            {

    ?>

    <div class="datosProducto">

            <form action="<?php self();?>" method="post">
            <?php echo $_REQUEST['codigo'];?>
            <?php echo $_REQUEST['stock'];?>
            <?php echo $_REQUEST['precio'];?>
            <?php echo $_REQUEST['unidades'];?>
            
            <?php 
                echo "<h1>".$_REQUEST['descripcion']."</h1>"; 
                echo "<h2>".$_REQUEST['precio']."€</h2>";
            ?>
                <section>
                    <label for="nProductos">Nº unidades</label>
                    <input type="number" name="cantidad" id="nProductos"  min="1" value="1">
                    <?php
                        //Se comprueba que el input no esté vacio
                        comprobarCantidad();
                    ?>
                </section>


                <section>
                    <input type="submit" value="Finalizar Comprar" name="comprarProducto">
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