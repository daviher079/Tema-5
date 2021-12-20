<?php


require_once("./segura/conexionBD.php");



function dsn()
{
    return "mysql:host=".IP.";dbname=".BBDD;
}

function crearBD()
{

    try
    {
        @$con=new PDO(dsn(), USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $commands = file_get_contents("../segura/script.sql");
        $con->exec($commands);

    }
    catch(PDOException $e)
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
    
}


function compruebaErrores()
{
    
    try
    {
        @$con=new PDO(dsn(), USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
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
            echo "<input type='submit' value='CrearBD' name='crear'>";
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


function lectura()
{
    try
    {
        @$con=new PDO(dsn(), USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql="select * from DATOSCLUB;";
        $resultado = $con->query($sql);
        echo "<table>";
        echo"<thead>";
        echo"<tr>";
        echo"<th COLSPAN=6>Datos Equipos</th>";
        echo"</tr>";
        echo "<tr >";
        echo "<th style='text-align: center;'>Puntos</th>";
        echo "<th style='text-align: center;'>Equipo</th>";
        echo "<th style='text-align: center;'>Media Goles</th>";
        echo "<th style='text-align: center;'>Año de creación</th>";
        echo"<th style='text-align: center;' COLSPAN=2>Editar</th>";
        echo"</tr>";
        echo"</thead>";
        echo"<tbody >";
            while($row = $resultado->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr >";
                echo"<td>".$row['PUNTOS']."</td>";
                echo"<td>".$row['NOMBRE']."</td>";
                echo"<td>".$row['MEDIA_GOLES']."</td>";
                echo"<td>".$row['FECHA']."</td>";
                echo"<td><a href='./codigo/borra/config.php?id=".$row['ID']."'><img src='./web-root/img/papelera-de-reciclaje.png' height='20px'/></a></td>";
                echo"<td><a href='./codigo/modifica/modificar.php?id=".$row['ID']."'><img src='./web-root/img/editar-texto.png' height='20px'/></a></td>";
                echo "</tr>";
            }
        echo"</tbody>";
        echo"</table>";
        
        

    }
    catch(PDOException $e)
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
}


function filtrado($cadena)
{
    try
    {
        @$con=new PDO(dsn(), USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $preparado=$con->prepare("select * from DATOSCLUB where NOMBRE LIKE :nombre");
        
        $cadena = "%".$cadena."%";

        $preparado->bindParam(":nombre",$cadena);

        $preparado->execute();
        if($preparado->rowCount()!=0)
        {
            echo "<table>";
            echo"<thead>";
            echo"<tr>";
            echo"<th COLSPAN=6>Datos Equipos</th>";
            echo"</tr>";
            echo "<tr>";
            echo "<th>Puntos</th>";
            echo "<th>Equipo</th>";
            echo"<th>Media Goles</th>";
            echo "<th>Año de creación</th>";
            echo"<th COLSPAN=2>Editar</th>";
            echo"</tr>";
            echo"</thead>";
            echo"<tbody>";
            while($row=$preparado->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr>";
                    
                    echo"<td>".$row['PUNTOS']."</td>";
                    echo"<td>".$row['NOMBRE']."</td>";
                    echo"<td>".$row['MEDIA_GOLES']."</td>";
                    echo"<td>".$row['FECHA']."</td>";
                    echo"<td><a href='./codigo/borrado.php?id=".$row['ID']."'><img src='./web-root/img/papelera-de-reciclaje.png' height='20px'/></a></td>";
                    echo"<td><a href='./codigo/modificar.php?id=".$row['ID']."'><img src='./web-root/img/editar-texto.png' height='20px'/></a></td>";
                    echo "</tr>";
                }
            echo"</tbody>";
            echo"</table>";
        }else
        {
            echo "<p>No se han encontrado registros en la base de datos</p>";
        } 
        
        
        $preparado->closeCursor();

    }
    catch(PDOException $e)
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
}

?>