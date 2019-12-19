<?php
    $edited = false;
    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        
        $con = mysqli_connect('localhost', 'root', '', 'project');

        $editname = mysqli_real_escape_string($con, $_POST['editname']);
        $editphone = mysqli_real_escape_string($con, $_POST['editphone']);

        if($con->query("UPDATE contacts SET name = '$editname', phone = '$editphone' WHERE id = $id ")){
            $edited = true;
        }

        $con->close();

    }
    $myJSON = array('edited' => $edited);
    echo json_encode($myJSON);
?>