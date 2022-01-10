<?php

require_once("../seguro/datosBD.php");
    function mostrarVentas()
    {
        try
        {
            $arrayVentas=array();
            $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from venta;");
            $sql->execute();
    
            while ($row =$sql->fetch()) {
                $arrayVentas[$row[0]]=array();
                $arrayVentas[$row[0]]['usuarioNickV']=$row[1];
                $arrayVentas[$row[0]]['fechaCompra']=$row[2];
                $arrayVentas[$row[0]]['codigoProductoV']=$row[3];
                $arrayVentas[$row[0]]['cantidad']=$row[4];
                $arrayVentas[$row[0]]['precioTotal']=$row[5];
                
            }
    
        }
        catch(PDOException $ex)
        {
            $numError = $ex->getCode();
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<p>No se reconoce la BBDD.</p>";
            }
            
            // Si no existe la tabla... (nº error = 1146)
            if($numError == 1146)
            {
                echo "<p>La tabla no existe.</p>";
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
        }
        finally
        {
            unset($con);
        }
        return $arrayVentas;
    }


    function recuperarVenta($codigo)
    {
        $arrayDatos=array();
        try
        {
            $con=new PDO ("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from venta where idVenta = :codigo");
            
            $sql->bindParam(":codigo", $codigo);
            $sql->execute();


            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($arrayDatos, $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
            }
        }catch(PDOException $ex)
        {
            $numError = $ex->getCode();
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<p>No se reconoce la BBDD.</p>";
            }
            
            // Si no existe la tabla... (nº error = 1146)
            if($numError == 1146)
            {
                echo "<p>La tabla no existe.</p>";
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
        }
        finally
        {
            unset($con);
        }

        return $arrayDatos;
    }

    function modificarProducto()
    {
        try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $preparada=$con->prepare("update productos 
            set stock = ?
            WHERE codigoProducto = ?");
            $con->beginTransaction();
            $cantidadAntigua= (int)$_REQUEST['cantidadArray'];
            $cantidadFormulario = (int) $_REQUEST['cantidad'];
            
            $array = recuperarPrecioStockProducto($_REQUEST['codigoProducto']);
            $stockProducto = (int)$array[1];
            $codProducto = $_REQUEST['codigoProducto'];
            $stockFinal=0;

            if($cantidadFormulario>$cantidadAntigua)
            {
                $stockFinal = $stockProducto - ($cantidadFormulario - $cantidadAntigua);

            }elseif($cantidadFormulario<$cantidadAntigua)
            {
                $stockFinal = $stockProducto + ($cantidadAntigua - $cantidadFormulario);
            }else
            {
                $stockFinal = $stockProducto;
            }
            

            $arrayParametros=array($stockFinal, $codProducto);
            $preparada->execute($arrayParametros);    

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


    function modificarVenta()
    {
        try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $preparada=$con->prepare("update venta 
            set usuarioNickV = ?, 
            fechaCompra = ?, 
            codigoProductoV = ?,
            cantidad = ?,  
            precioTotal = ?
            WHERE idVenta = ?");
            $con->beginTransaction();
            $array = recuperarPrecioStockProducto($_REQUEST['codigoProducto']);
            
            $idVenta = (int) $_REQUEST['idVenta'];
            $usuario = $_REQUEST['usuario'];
            $fecha = $_REQUEST['fecha'];
            $codProducto = $_REQUEST['codigoProducto'];
            $cantidad = (int) $_REQUEST['cantidad'];
            $precioProducto = (float) $array[0];
            $precioFinal = (float) $precioProducto * $cantidad;

            $arrayParametros=array($usuario, $fecha, $codProducto, $cantidad, $precioFinal, $idVenta);
            $preparada->execute($arrayParametros);    

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


    function validarModificacion()
    {
        $bandera=false;
        if(isset($_REQUEST['modificarVenta']))
        {
            if(validarFecha()==true && validarCantidad()==true)
            {
                modificarProducto();
                modificarVenta();

                $bandera=true;
            }   
            else{
                
                $bandera = false;
            }   
        } else
        {
            $bandera= false;
        }
        return $bandera;
    }



    function recordarGenerico($var, $nombre){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['modificarVenta']))
        {
            echo $_REQUEST[$var];        
        }else
        {
            echo $nombre;
        }
    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['modificarVenta'])){
            
            label("Campo ".$var);
        }           
    }


    function validarFecha()
    {
        $bandera=true;
        if(!empty($_REQUEST['fecha']) && isset($_REQUEST['modificarVenta']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarCantidad()
    {
        $bandera=true;
        if(!empty($_REQUEST['cantidad']) && isset($_REQUEST['modificarVenta']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }


    function recuperarPrecioStockProducto($codigoProducto)
    {
        try
        {
            $arrayPrecioStock=array();
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select precio, stock from productos where codigoProducto = :codigo;");

            $sql->bindParam(":codigo", $codigoProducto);
            $sql->execute();

            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($arrayPrecioStock, $row[0], $row[1]);
            }

        }catch(PDOException $e)
        {
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

        return $arrayPrecioStock;
    }

?>