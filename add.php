<?php
    $con = mysqli_connect('localhost', 'root', '', 'project');

    $added = false;
    $newname = '';
    $newphone = '';

    //check new addition
    if(isset($_POST['newname'])){
        $newname = $con->real_escape_string($_POST['newname']);
        $newphone = $con->real_escape_string($_POST['newphone']);
        if($con->query("INSERT INTO contacts (name, phone) VALUES ('$newname', '$newphone')")){
            $added = true;
            $newid = $con->query("SELECT id FROM contacts WHERE name = '$newname'");
        }else{
            $added = false;
        }
    }

    $myJSON = array('added' => $added);
    echo json_encode($myJSON);
?>

<?php $con->close(); ?>