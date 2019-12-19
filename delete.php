<?php
    $deleted = false;
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $con= mysqli_connect( 'localhost', 'root', '', 'project');

        if($con->query("DELETE FROM contacts WHERE id = $id")){
            $deleted = true;
        }
        
        $con->close();
    }

    $myJSON = array('deleted' => $deleted);
    echo json_encode($myJSON);
?>
