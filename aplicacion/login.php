<?php
    //llamar a verifica sesion
    //validamos el formulario y ponemos los errores validar el perfil de ese usuariio

   //USER u1 pass 1

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./funciones/valida.php" method="post">
        <label for="user">Usuario</label><input type="text" name="user" id="user">
        <label for="pass">Password</label><input type="password" name="pass" id="pass">
        <br>
        <input type="submit" value="Login" name="valida">
    </form>
</body>
</html>

