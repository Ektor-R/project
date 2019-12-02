<?php

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $con= mysqli_connect( 'localhost', 'root', '', 'project');

        $con->query("DELETE FROM contacts WHERE id = $id");

        $con->close();

        header('Location: contacts.php');
    }else{
        header('Location: contacts.php');
    }

?>
