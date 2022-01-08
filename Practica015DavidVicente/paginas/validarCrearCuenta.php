<?php
   //define("PATRONNOMBRECOMPLETO", '/^[A-Z]{1}[a-z]{2}\s^[A-Z]{1}[a-z]{2,}\s^[A-Z]{1}[a-z]{2,}\s/i');
   define("PATRONNOMBRECOMPLETO", '/[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}\s[A-Z]{1}[a-z]{2,}/');
    define("PATRONCONTRASEÑA", '/^[A-Za-z0-9]{5,}([A-Z]{1}[a-z]{1}[0-9]{1})$/');
    
    require_once("../seguro/datosBD.php");
    function validarCuenta()
    {
        $bandera=true;
        if(isset($_REQUEST['crearCuenta']))
        {
            
            if(validarUsuario()==false && validarNombreComp()==true && validarFecha()==true && validarMail()==true && validarPass()==true)
            {
                
                $user=$_REQUEST['user'];
                $nCompleto=$_REQUEST['nCompleto'];
                $correo=$_REQUEST['correo'];
                $fecha=$_REQUEST['fecha'];
                $encrip = sha1($_REQUEST['pass']);
                $perfil = "USR01";
                
                try{    
                    $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //usuario,clave, nombre, correo, fechaNacimiento, perfil
                    $preparada=$con->prepare("insert into usuarios values(?,?,?,?,?,?)"); 
                    $con->beginTransaction();  
                    $arrayParametros=array($user, $encrip, $nCompleto, $correo, $fecha, $perfil);
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
            else{
                
                $bandera = false;
            }   
        } else
        {
            $bandera= false;
        }
        
        return $bandera;
    }

    function recordarGenerico($var){
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


    function validarUsuario()
    {
        $bandera=false;
        if(!empty($_REQUEST['user']) && isset($_REQUEST['crearCuenta']))
        {
            try
            {
                $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql=$con->prepare("select usuario from usuarios;");
                $sql->execute();
                $usuarioFormulario=$_REQUEST['user'];
                while($row=$sql->fetch())
                {
                    $usuarioBD=$row['usuario'];
                    if($usuarioBD==$usuarioFormulario)
                    {
                        $bandera=true;
                    }
                }

            }
            catch(PDOException $ex)
            {
                $numError = $ex->getCode();

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
            }finally
            {
                unset($con);
            }
        }
        return $bandera;
    }

    function validarNombreComp()
    {
        $bandera=true;
        if(!empty($_REQUEST['nCompleto']) && isset($_REQUEST['crearCuenta']) && expresionGenerico(PATRONNOMBRECOMPLETO, $_REQUEST['nCompleto'])==true)
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
        if(!empty($_REQUEST['correo']) && isset($_REQUEST['crearCuenta']))
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
        if(!empty($_REQUEST['fecha']) && isset($_REQUEST['crearCuenta']))
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
        if(!empty($_REQUEST['pass']) && !empty($_REQUEST['rPass']) && isset($_REQUEST['crearCuenta']))
        {
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


    function mostrarPaginasUsuario($usuario, $nombre)
{
    try
        {
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
            $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $perfil = "USR01";

            $sqlp = $con->prepare("select descripcion, url 
                    from paginas p join accede a on (p.codigo = a.codigoPagina)
                    where codigoPerfil = :perfil");
    
            $sqlp->bindParam(":perfil", $perfil);
            $sqlp->execute();

            session_start();
            $paginas=array();
            while($row=$sqlp->fetch())
            {
                $paginas[$row[0]]=$row[1];
            }
            $_SESSION['paginas']=$paginas;
            
            $_SESSION['validada'] = true;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nombre"] = $nombre;
           
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
}


?>