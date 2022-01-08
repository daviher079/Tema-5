<?php

    define("PATRONNOMBRECOMPLETO", '/[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}/');
    define("PATRONCONTRASEÑA", '/^[A-Za-z0-9]{5,}([A-Z]{1}[a-z]{1}[0-9]{1})$/');
    
    require_once("../seguro/datosBD.php");
    

    function recordarGenerico($var, $nombre){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['crearCuenta']))
        {
            echo $_REQUEST[$var];        
        }else
        {
            echo $nombre;
        }
    }
    function recordarPass($var)
    {
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['crearCuenta']))
        {
            echo $_REQUEST[$var];        
        }

    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['crearCuenta'])){
            
            label("Debe haber un campo ".$var);
        }           
    }

    function expresionGenerico($patron, $var){
        
        $bandera=true;
        $prueba = preg_match($patron, $var);
        $prueba;
        if(!empty($var) && isset($_REQUEST['crearCuenta']) && $prueba==false)
        {
            $bandera=false;
        }

        return $bandera;
    }



    function validarModificacion()
    {
        return false;
    }


    function extraerDatosUsuario($user)
    {
        try
        {
            $arrayDatosUser=array();
            $con = new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql=$con->prepare("select * from usuarios where usuario = :user");
            $sql->bindParam(":user", $user);
            $sql->execute();

            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                
                array_push($arrayDatosUser, $row[2], $row[3], $row[4]);
            
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

        return $arrayDatosUser;
    }

?>