<?php

    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $editname = '';
        $editphone = '';

        $con = mysqli_connect('localhost', 'root', '', 'project');

        $editname = mysqli_real_escape_string($con, $_POST['editname']);
        $editphone = mysqli_real_escape_string($con, $_POST['editphone']);

        $con->query("UPDATE contacts SET name = '$editname', phone = '$editphone' WHERE id = $id ");

        $con->close();

        header('Location: contacts.php');
    }else{
        header('Location: contacts.php');
    }

?>