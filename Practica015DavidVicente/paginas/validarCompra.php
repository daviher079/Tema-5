<?php

require_once "../codigo/validaSesion.php";
require_once "../codigo/Funciones.php";
require_once "../seguro/datosBD.php";
    function validarCompra()
    {
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

    function crearVenta()
    {
        
        try{

            $user = $_SESSION["usuario"];
            $fecha = date ('Y-m-d', time());
            $codigo = $_REQUEST['codigo'];
            $cantidad = (int)$_REQUEST['cantidad'];
            $precioTotal = (float)$_REQUEST['precio'] * $cantidad;

            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $preparada=$con->prepare("insert into venta values(idVenta,?,?,?,?,?)");

            $con->beginTransaction();  
            $arrayInsert=array($user, $fecha, $codigo, $cantidad, $precioTotal);
            $preparada->execute($arrayInsert);
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
                echo "<br>La tabla no existe.<br>";
            }
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<br>No se reconoce la BBDD.<br>";
            }
            // Error al conectar con el servidor...
            else if($numError == 2002)
            {
                echo "<br>Error al conectar con el servidor.<br>";
            }
            // Error de autenticación...
            else if($numError == 1045)
            {
                echo "<br>Error en la autenticación.<br>";
            }
        }finally
        {
            unset($con);
        }    
    }

    function actualizarProducto()
    {
        try{  
            $codigo = $_REQUEST['codigo'];
            $stockFinal = (int)$_REQUEST['stock'] - (int)$_REQUEST['cantidad'];
              
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $preparada=$con->prepare("
                UPDATE productos SET stock = ? WHERE codigoProducto = ?;
            ");

            $con->beginTransaction();  
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
                echo "<br>La tabla no existe.<br>";
            }
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<br>No se reconoce la BBDD.<br>";
            }
            // Error al conectar con el servidor...
            else if($numError == 2002)
            {
                echo "<br>Error al conectar con el servidor.<br>";
            }
            // Error de autenticación...
            else if($numError == 1045)
            {
                echo "<br>Error en la autenticación.<br>";
            }
        }finally
        {
            unset($con);
        }    
    }

    function generarVenta()
    {
        crearVenta();
        actualizarProducto();

        header("location: ./indexPerfil.php");
    }


?>