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

    
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
        <link rel="stylesheet" href="../web-root/css/style.css"/>
        <title>Modificar producto</title>
    </head>
    <body>
        <header class="cabecera">
            <h1>Tienda Online</h1>
            <div class='user'>
            <?php
                echo "<h2>".$_SESSION['nombre']."</h2>";
            ?>    
                <a href="./indexPerfil.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
            </div>
        </header>

        <main class="mainModPerfil">
            <h2>Modificar Producto</h2>
            
            <?php

                require_once("./validarModProducto.php");
                require_once("../codigo/Funciones.php");
                $datos= recuperarProducto($_REQUEST['codigo']);
            
                if(validarModificacion()==true)
                {
                    header("location: ./modificarProductos.php");
                }else
                {

            ?>    

                <form action="<?php self();?>" method="post">
                    
                    <section>
                        <label for="codigo">C. Producto</label>
                        <input style="color: #c57485;" type="text" onfocus="this.blur()" name="codigo" id="codigo" readonly="readonly" value="<?php echo $datos[0] ?>">
                    </section>

                    <section>
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" value="<?php recordarGenerico("descripcion",$datos[1])?>">
                        <?php
                            comprobarGenerico("descripcion");
                        ?>
                    </section>

                    <section>
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" id="precio" step="0.01" min="1" value="<?php recordarGenerico("precio",$datos[2])?>">
                        
                        <?php
                            comprobarGenerico("precio");
                        ?>
                    </section>

                    <section>
                        <label for="stock">Stock</label>
                        <input style="color: #c57485;" type="number" name="stock" id="stock" onfocus="this.blur()" readonly="readonly" value="<?php recordarGenerico("stock", $datos[3])?>">
                        
                    </section>
                    
                    <input type="submit" value="Modificar producto" name="modificarProducto">
                        

                    </form>

                    <?php
                        }
                    ?>
        </main>
</body>
</html>    
