<?php
    session_start();
    if(isset($_SESSION['validada']))
    {
        echo "<p>nombre: ".$_SESSION['user']."</p>";
        echo "<p>valida: ".$_SESSION['validada']."</p>";

        if(isset($_SESSION['contador']))
        {
            echo "<p>".$_SESSION['contador']."</p>";
        }

        echo "<p>".session_id()."</p>";

    }else
    {
        header('Location: ./login.php');
        exit;
    }
?>

<form action="./modifica.php" method="post">
    <?php
        if(!isset($_SESSION['contador'])){

    ?>
        <input type="submit" name="crear" value="crear variable">
    <?php
        }else{
    ?>
    <input type="submit" name="sumar" value="+">
    <input type="submit" name="restar" value="-">
    <input type="submit" name="reset" value="reset">
    <?php }?>
</form>

<a href="./logout.php">LogOut</a>