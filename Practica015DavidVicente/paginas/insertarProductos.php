<?php
    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");  
    }elseif($_SESSION['perfil']=='USR01')
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
        <title>Insertar producto</title>
    </head>
    <body>
        <header class="cabecera">
            <h1>Tienda Online</h1>
            <a href="./indexPerfil.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </header>
        

        <main class="mainModPerfil">
            <h2>Insertar Producto</h2>
            <h4><?php echo $_SESSION['nombre'] ?></h4>

            <?php

                require_once("./validarInsertarProducto.php");
                require_once("../codigo/Funciones.php");
                
            
                if(validarModificacion()==true)
                {
                    header("location: ./indexPerfil.php");
                }else
                {

            ?>    

            <form action="<?php self();?>" method="post">
                
                <section>
                    <label for="codigo">C. Producto</label>
                    <input type="text" name="codigo" id="codigo" value="<?php recordarGenerico("codigo") ?>">
                    <?php
                        comprobarGenerico("codigo");
                    ?>
                </section>

                <section>
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" value="<?php recordarGenerico("descripcion")?>">
                    <?php
                        comprobarGenerico("descripcion");
                    ?>
                </section>

                <section>
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" min="1" step="0.01" value="<?php recordarGenerico("precio")?>">
                    
                    <?php
                        comprobarGenerico("precio");
                    ?>
                </section>

                <section>
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" value="<?php recordarGenerico("stock")?>">
                    <?php
                        comprobarGenerico("stock");
                    ?>
                </section>
                
                <input type="submit" value="Insertar producto" name="insertarProducto">
                    

                </form>

                <?php
                    }
                ?>
        </main>
    </body>
</html>