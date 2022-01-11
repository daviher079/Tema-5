<?php

require_once("../seguro/datosBD.php");
    function mostrarAlbaranes()
    {
        try
        {
            $arrayAlbaranes=array();
            $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from albaran;");
            $sql->execute();
    
            while ($row =$sql->fetch()) {
                $arrayAlbaranes[$row[0]]=array();
                $arrayAlbaranes[$row[0]]['fechaAlbaran']=$row[1];
                $arrayAlbaranes[$row[0]]['codigoProductoA']=$row[2];
                $arrayAlbaranes[$row[0]]['cantidad']=$row[3];
                $arrayAlbaranes[$row[0]]['usuarioNickA']=$row[4];
                
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
        return $arrayAlbaranes;
    }

    function recuperarAlbaran($codigo)
    {
        $arrayDatos=array();
        try
        {
            $con=new PDO ("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from albaran where idAlbaran = :codigo");
            
            $sql->bindParam(":codigo", $codigo);
            $sql->execute();

            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($arrayDatos, $row[0], $row[1], $row[2], $row[3], $row[4]);
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


    function modificarAlbaran()
    {
        try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $preparada=$con->prepare("update albaran 
            set fechaAlbaran = ?, 
            codigoProductoA = ?, 
            cantidad = ?,  
            usuarioNickA = ?
            WHERE idAlbaran = ?");
            $con->beginTransaction();
            
            $idAlbaran = (int) $_REQUEST['idAlbaran'];
            $fecha = $_REQUEST['fecha'];
            $codProducto = $_REQUEST['codigoProducto'];
            $cantidad = (int) $_REQUEST['cantidad'];
            $usuario = $_REQUEST['usuario'];

            $arrayModificarAlbaran=array($fecha, $codProducto, $cantidad, $usuario, $idAlbaran);
            $preparada->execute($arrayModificarAlbaran); 
            
            

            $preparada=$con->prepare("update productos 
            set stock = ?
            WHERE codigoProducto = ?");
            
            $codProducto = $_REQUEST['codigoProducto'];

            $arrayModificaProductos=array($cantidad, $codProducto);
            $preparada->execute($arrayModificaProductos);    

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
        if(isset($_REQUEST['modificarAlbaran']))
        {
            if(validarFecha()==true && validarCantidad()==true)
            {
                modificarAlbaran();

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
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['modificarAlbaran']))
        {
            echo $_REQUEST[$var];        
        }else
        {
            echo $nombre;
        }
    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['modificarAlbaran'])){
            
            label("Campo ".$var);
        }           
    }


    function validarFecha()
    {
        $bandera=true;
        if(!empty($_REQUEST['fecha']) && isset($_REQUEST['modificarAlbaran']))
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
        if(!empty($_REQUEST['cantidad']) && isset($_REQUEST['modificarAlbaran']))
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