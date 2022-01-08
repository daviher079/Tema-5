<?php
    require_once("../seguro/datosBD.php");


    function validarModificacion()
    {
        $bandera=false;
        if(isset($_REQUEST['insertarProducto']))
        {
            if(validarCodigo()==true && validarDescripcion()==true && validarPrecio()==true && validarStock()==true)
            {
                
                insertarProducto();
                generarAlbaran();
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

    function insertarProducto()
    {    
        try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $preparada=$con->prepare("insert into productos values(?,?,?,?)");
            
            $con->beginTransaction(); 
            $codigo = $_REQUEST['codigo'];
            $descripcion = $_REQUEST['descripcion'];
            $precio = (float)$_REQUEST['precio']; 
            $stock = (int)$_REQUEST['stock'];

            $arrayInsert=array($codigo, $descripcion, $precio, $stock);
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


    function generarAlbaran()
    {
        
        try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $preparada=$con->prepare("insert into albaran values(idAlbaran,?,?,?,?)");
            
            $con->beginTransaction(); 
            $fecha = date ('Y-m-d', time());
            $codigo= $_REQUEST['codigo'];
            $cantidad = (int)$_REQUEST['stock'];
            $usuario= $_SESSION['usuario'];

            $arrayInsert=array($fecha, $codigo, $cantidad, $usuario);
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

    function recordarGenerico($var){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['insertarProducto']))
        {
            echo $_REQUEST[$var];        
        }
    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['insertarProducto'])){
            
            label("Debe haber un campo ".$var);
        }           
    }

    function validarCodigo()
    {
        $bandera=true;
        if(!empty($_REQUEST['codigo']) && isset($_REQUEST['insertarProducto']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarDescripcion()
    {
        $bandera=true;
        if(!empty($_REQUEST['descripcion']) && isset($_REQUEST['insertarProducto']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarPrecio()
    {
        $bandera=true;
        if(!empty($_REQUEST['precio']) && isset($_REQUEST['insertarProducto']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarStock()
    {
        $bandera=true;
        if(!empty($_REQUEST['stock']) && isset($_REQUEST['insertarProducto']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }
?>