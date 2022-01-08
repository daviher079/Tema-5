<?php
    require_once("../seguro/datosBD.php");
    function mostrarProductos()
    {
        try
        {
            $arrayProductos=array();
            $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from productos;");
            $sql->execute();
    
            while ($row =$sql->fetch()) {
                $arrayProductos[$row[0]]=array();
                $arrayProductos[$row[0]]['descripcion']=$row[1];
                $arrayProductos[$row[0]]['precio']=$row[2];
                $arrayProductos[$row[0]]['stock']=$row[3];
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
        return $arrayProductos;
    }


    function recuperarProducto($codigo)
    {
        $arrayDatos=array();
        try
        {
            $con=new PDO ("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from productos where codigoProducto = :codigo");
            
            $sql->bindParam(":codigo", $codigo);
            $sql->execute();


            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($arrayDatos, $row[0], $row[1], $row[2], $row[3]);
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

    function validarModificacion()
    {
        $bandera=false;
        if(isset($_REQUEST['modificarProducto']))
        {
            if(validarDescripcion()==true && validarPrecio()==true)
            {
                
                try
                {
                    $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                
                    $preparada=$con->prepare("update productos 
                            set descripcion = ?, 
                            precio = ?, 
                            stock = ? 
                            WHERE codigoProducto = ?");
                    $con->beginTransaction();

                    $codigo = $_REQUEST['codigo'];
                    $descripcion = $_REQUEST['descripcion'];
                    $precio = (float)$_REQUEST['precio'];
                    $stock = (int)$_REQUEST['stock'];

                    $arrayParametros=array($descripcion, $precio, $stock, $codigo);
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
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['modificarProducto']))
        {
            echo $_REQUEST[$var];        
        }else
        {
            echo $nombre;
        }
    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['modificarProducto'])){
            
            label("Debe haber un campo ".$var);
        }           
    }

    function validarDescripcion()
    {
        $bandera=true;
        if(!empty($_REQUEST['descripcion']) && isset($_REQUEST['modificarProducto']))
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
        if(!empty($_REQUEST['precio']) && isset($_REQUEST['modificarProducto']))
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