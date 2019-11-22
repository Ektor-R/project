<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $con= mysqli_connect( 'localhost', 'root', '', 'project');

        $con->query("DELETE FROM contacts WHERE id = $id");

        $con->close();

        header('Location: contacts.php');
    }else{
        header('Location: contacts.php');
    }

?>
