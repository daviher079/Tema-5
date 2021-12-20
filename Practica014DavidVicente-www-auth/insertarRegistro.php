<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>
    <title>CRUD</title>
    <style>

        table
        {
            border: 2px solid black;
        }
        
        th
        {
            border: 2px solid black;
            text-align: left;
        }

        

    </style>
</head>
<body>
    <header>
        <img class="logo" src="./web-root/img/LogotipoDavidVicente.png"/>
        <h1>CRUD</h1>
    </header>
    <main>
    
        <div class="content">
            <div class="title">
                <h1>DWES</h1>
                
               <?php
                require_once("./validarInsertarRegistro.php");
                if(validarFormulario()==true)
                {
                    header('Location: ./lecturaTabla.php');
                    
                }else
                {
                    
            ?>
        
            <form action="<?php echo "insertarRegistro.php"?>" method="post" name="formulario">
                <article>
                <section style="margin-right: 30px;">
                        <label for="puntos">Puntos:</label>
                        <input type="number" name="puntos" id="puntos" placeholder="0" size="30" value="<?php
                            recordargenerico("puntos"); 
                        ?>">
                        <?php
                            comprobarGenerico("puntos");
                        ?>
                    </section>
                    <section style="margin-right: 30px;">
                        <label for="nombre">Nombre del Club:</label>
                        <input type="text" name="nombre" id="nombre" size="40" placeholder="Nombre" value="<?php
                            recordargenerico("nombre"); 
                        ?>">
                        <?php
                            //Se comprueba que la cadena sea correcta segun la expresión regular
                            if(isset($_REQUEST['enviado']) && expresionGenerico(PATRONNOMBRE, $_REQUEST['nombre'])==false)
                            {
                                echo "<label>El nombre introducido no es valido. Minimo 3 caracteres</label>";
                            }
                            //En caso de estar vacio el input se informa al usuario de que debe rellenarlo
                            comprobarGenerico("nombre");
                            
                        ?>
                    </section>

                    <section style="margin-right: 30px;">
                        <label for="mediaGoles">Media Goles:</label>
                        <input type="number" name="mediaGoles" id="mediaGoles" placeholder="0.00" size="30" step="0.25" value="<?php
                            recordargenerico("mediaGoles");
                        ?>">
                        <?php
                            comprobarGenerico("mediaGoles");
                        ?>
                    </section>

                    <section style="margin-right: 30px;">
                        <label for="fecha">Fecha:</label>
                        <input type="text" name="fecha" id="fecha" size="30" placeholder="Fecha"
                        value="<?php
                            recordarGenerico("fecha");
                        ?>">

                        <?php
                            //Se comprueba que la cadena sea correcta segun la expresión regular
                            if(isset($_REQUEST['enviado']) && expresionGenerico(PATRONFECHA, $_REQUEST['fecha'])==true)
                            {
                                
                                
                            }elseif(isset($_REQUEST['enviado'])) 
                            {
                                //Se ejecuta cuando la fecha no está bien formada y se informa al usuario de cual es el formato correcto
                                echo "<label>La fecha debe ser introducida en uno de los siguientes formatos dd-mm-yyyy o dd/mm/yyyy</label>";
                            }
                            comprobarGenerico("fecha");
                        ?>
                    </section>

                    
                </article>
                <section id="botones" style="margin-top: 30px;">

                    <input type="submit" value="Enviar los Datos" name="enviado">

                    <input type="reset" value="Limpiar">
                    <a href="./lecturaTabla.php"><img src="./web-root/img/volver.png" height="30px"></a>
                </section>
            </form>
        </div>   
        <?php
                }
                
        ?>
            </div>
        </div>  
        

        
           
        

    </main>
    <footer>
        <p>Footer de David</p>
        <a href="./verCodigo.php?ficheroPHP=<?php
            $pagina=basename($_SERVER['SCRIPT_FILENAME']);
            echo $pagina;
        ?>"><img src="./web-root/img/gafas-de-sol.png" height="100px"></a>
    </footer>
</body>
</html>