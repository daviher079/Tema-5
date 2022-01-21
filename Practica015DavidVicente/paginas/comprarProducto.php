<?php



if(isset($_REQUEST['codigo']))
{
    
    if(!isset($_COOKIE['visitado']))
    {
        setcookie("visitado[0]",$_REQUEST['codigo'], time()+31536000, "/");

    }else
    {
       //contar cuantas hay
       $arrayProductosVisitados = $_COOKIE['visitado'];

       $numero=count($arrayProductosVisitados);

       if(!in_array($_REQUEST['codigo'], $arrayProductosVisitados))
       {
           if($numero<3)
           {
                array_unshift($arrayProductosVisitados, $_REQUEST['codigo']);

                foreach ($arrayProductosVisitados as $key => $value) {
                    setcookie('visitado['.$key.']',$value, time()+31536000, "/");
                }  
           }else
           {
               //Ordenar poniendo el primero el ultimo codigo
                array_unshift($arrayProductosVisitados, $_REQUEST['codigo']);
                array_pop($arrayProductosVisitados);

                foreach ($arrayProductosVisitados as $key => $value) {
                    setcookie('visitado['.$key.']',$value, time()+31536000, "/");

                    //setcookie($_SESSION['nombre'].'['.$numero.']',$codigo, time()+31536000, "/" );
                }
           }
       }
    }

}
else
{
    header("Location: ../index.php");
}

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
        #deseo
        {
            display: none;
        }
    </style>
    <title>Comprar Producto</title>
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


                    header("location: ./finalizarCompra.php?codigo=".$_REQUEST['codigo']."&stock=".$_REQUEST['stock']."&precio=".$_REQUEST['precio']."&unidades=".$_REQUEST['cantidad']."&descripcion=".$_REQUEST['descripcion']."&imagen=".$_REQUEST['imagen']);
                }

            }
            else
            {

    ?>

<div class="datosProducto">

            <?php
                if(validaSession()==true)
                {
                
            ?>    
                <section>

                    <label for="deseo">Añadir a la lista de deseos <img id="imagen" src="../web-root/img/amor-01.png" height="18px"></label>

                    <input type="checkbox" name="deseo" id="deseo">
                </section>
            <?php
                }
            ?>

            <form action="<?php self();?>" method="post">
            <input type="hidden" name="codigo" id ="codigo" value="<?php echo $_REQUEST['codigo'];?>">
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
                        //Se comprueba que el input no esté vacio
                        comprobarCantidad();
                    ?>
                </section>


                <section>
                    <input type="submit" value="Comprar Producto" name="comprarProducto">
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