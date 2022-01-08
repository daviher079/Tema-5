<?php

    define("PATRONNOMBRECOMPLETO", '/[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}/');
    define("PATRONCONTRASEÑA", '/^[A-Za-z0-9]{5,}([A-Z]{1}[a-z]{1}[0-9]{1})$/');
    
    require_once("../seguro/datosBD.php");
    

    function recordarGenerico($var, $nombre){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['modificarPerfil']))
        {
            echo $_REQUEST[$var];        
        }else
        {
            echo $nombre;
        }
    }
    function recordarPass($var)
    {
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['modificarPerfil']))
        {
            echo $_REQUEST[$var];        
        }

    }

    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['modificarPerfil'])){
            
            label("Debe haber un campo ".$var);
        }           
    }

    function expresionGenerico($patron, $var){
        
        $bandera=true;
        $prueba = preg_match($patron, $var);
        $prueba;
        if(!empty($var) && isset($_REQUEST['modificarPerfil']) && $prueba==false)
        {
            $bandera=false;
        }

        return $bandera;
    }



    function validarModificacion()
    {
            $bandera=true;
            if(isset($_REQUEST['modificarPerfil']))
            {
                
                if(validarNombreComp()==true && validarMail() == true && validarFecha() ==true && validarPass()==true)
                {
                   
                    try
                    {
                        $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                    
                        $preparada=$con->prepare("update usuarios 
                                set clave = ?, 
                                nombre = ?, 
                                correo = ?, 
                                fechaNacimiento = ?,
                                perfil = ? 
                                WHERE usuario = ?");
                        $con->beginTransaction();

                        $user=$_REQUEST['user'];
                        $nCompleto=$_REQUEST['nCompleto'];
                        $_SESSION['nombre']=$nCompleto;
                        $cElectronico=$_REQUEST['correo'];
                        $fecha=$_REQUEST['fecha'];
                        $pass=$_REQUEST['pass'];
                        $perfil=$_SESSION['perfil'];

                        $arrayParametros=array($pass, $nCompleto, $cElectronico, $fecha, $perfil, $user);
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
                
                array_push($arrayDatosUser, $row[1], $row[2], $row[3], $row[4]);
            
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

    function validarNombreComp()
    {
        $bandera=true;
        if(!empty($_REQUEST['nCompleto']) && isset($_REQUEST['modificarPerfil']) && expresionGenerico(PATRONNOMBRECOMPLETO, $_REQUEST['nCompleto'])==true)
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }


   function validarMail()
    {
        $bandera=true;
        if(!empty($_REQUEST['correo']) && isset($_REQUEST['modificarPerfil']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarFecha()
    {
        $bandera=true;
        if(!empty($_REQUEST['fecha']) && isset($_REQUEST['modificarPerfil']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }


    function validarPass()
    {
        $bandera=false;
        if(!empty($_REQUEST['pass']) && !empty($_REQUEST['rPass']) && isset($_REQUEST['modificarPerfil']))
        {
            $passFormu=sha1($_REQUEST['pass']);
            if($passFormu==$_REQUEST['passArray'])
            {
                $bandera=false;
            }
            if($_REQUEST['pass']==$_REQUEST['rPass'])
            {
                if(expresionGenerico(PATRONCONTRASEÑA, $_REQUEST['pass'])==true)
                {
                    $bandera=true;    
                }
            }
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }
?>