<?php

require_once "../codigo/validaSesion.php";
require_once "../codigo/Funciones.php";
require_once "../seguro/datosBD.php";
    function validarCompra()
    {
        /**
         * Si existe el boton de comprar producto en la varaible
         * superglobal request y la cantidad ha sido validada correctamente
         * devuelve true y ejecuta la compra
         */
        $bandera=true;
        if(isset($_REQUEST['comprarProducto'])==true)
        {
            if(validarCantidad()==true)
            {
                $bandera=true;
            }else
            {
                $bandera=false;
            }
            
        }else
        {
            $bandera=false;
        }

        return $bandera;
    }

    function comprobarSesion()
    {
        $bandera=true;
            
        if(validaSession()==false)
        {
            $bandera=false;
            //header("location: ../login.php");
            //echo "<a href='../login.php'><img src='../web-root/img/userPR15-01.png' height='50px'></a>";
        }
        return $bandera;
    }



    function recordarGenerico($var){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['comprarProducto']))
        {
            echo $_REQUEST[$var];        
        }
    }

    function comprobarCantidad(){
        /**
         * Para validar el numero de productos que el usuario ha comprado 
         * Si el input no esta vacio y la cantidad que solicita el usuario
         * no es mayor que la de stock se ejecutará la compra
         */
        if(!empty($_REQUEST['cantidad']) && isset($_REQUEST['comprarProducto'])){
            $cantidad = (int)$_REQUEST['cantidad'];
            $stockFinal = (int)$_REQUEST['stock'];

            if($cantidad>$stockFinal)
            {
                label("No puede superar el numero de stock disponible");

            }
            
        }   
        
        if(empty($_REQUEST['cantidad']) && isset($_REQUEST['comprarProducto']))
        {
            label("El Nº de unidades no puede estar vacio");
        }
    }

    function validarCantidad()
    {
        $bandera=true;
        if(!empty($_REQUEST['cantidad']) && isset($_REQUEST['comprarProducto']))
        {
            $cantidad = (int)$_REQUEST['cantidad'];
            $stockFinal = (int)$_REQUEST['stock'];
            if($cantidad>$stockFinal)
            {
                $bandera=false;

            }
        }
        else
        {
            $bandera=false;
        }  

        return $bandera;
    }

    function generarVenta()
    {
        
        try{
            /**
             * Se genera una nueva linea en la tabla de venta
             */
            $user = $_SESSION["usuario"];
            $fecha = date ('Y-m-d', time());
            $codigo = $_REQUEST['codigo'];
            $cantidad = (int)$_REQUEST['cantidad'];
            $precioTotal = (float)$_REQUEST['precio'] * $cantidad;
            $stockFinal = (int)$_REQUEST['stock'] - (int)$_REQUEST['cantidad'];

            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $preparada=$con->prepare("insert into venta values(idVenta,?,?,?,?,?)");

            $con->beginTransaction();  
            $arrayInsert=array($user, $fecha, $codigo, $cantidad, $precioTotal);
            $preparada->execute($arrayInsert);
            /**
             * Se actualiza el stock del producto 
             */
            $preparada=$con->prepare("
            UPDATE productos SET stock = ? WHERE codigoProducto = ?;
            ");
            
            $arrayUpdate=array($stockFinal, $codigo);
            $preparada->execute($arrayUpdate);

            $con->commit();
            $preparada->closeCursor();
    
        }
        catch(PDOException $e)
        {
            $con->rollBack();
            $numError = $e->getCode();
    
            // Si no existe la tabla... (nº error = 1146)
            if($numError == 1146)
            {
                echo "<p>La tabla no existe.</p>";
            }
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<p>No se reconoce la BBDD.</p>";
            }
            // Error al conectar con el servidor...
            else if($numError == 2002)
            {
                echo "<p>Error al conectar con el servidor.</p>";
            }
            // Error de autenticación...
            else if($numError == 1045)
            {
                echo "<p>Error en la autenticación.</p>";
            }
        }finally
        {
            unset($con);
        }    
    }


?>