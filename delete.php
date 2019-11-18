<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $con= mysqli_connect( 'localhost', 'root', '', 'project');

        $con->query("DELETE FROM contucts WHERE id = $id");

        $con->close();

        header('Location: contucts.php');
    }else{
        header('Location: contucts.php');
    }

?>
