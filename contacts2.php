<?php
    header('Content-Type: application/json');
    $con = mysqli_connect('localhost', 'root', '', 'project');

    $contactsearch = '';
    $newname = '';
    $newphone = '';

    //check new addition
    if(isset($_POST['add'])){
           $newname = $con->real_escape_string($_POST['newname']);
           $newphone = $con->real_escape_string($_POST['newphone']);
           if($con->query("INSERT INTO contacts (name, phone) VALUES ('$newname', '$newphone')")){
               $added = true;
               $newid = $con->query("SELECT id FROM contacts WHERE name = '$newname'");
           }else{
               $added = false;
           }
    }



    //check search
    if(isset($_GET['search']) && isset($_GET['contactsearch']) && $_GET['contactsearch'] !== ''){
        $ok=true;

        $contactsearch = $con->real_escape_string($_GET['contactsearch']);
        $result = $con->query("SELECT * FROM contacts WHERE name LIKE '$contactsearch%' OR phone = '$contactsearch'");
    }else {
        $ok=false;
        $result = $con->query( "SELECT * FROM contacts");
    }
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}


echo json_encode($rows);
?>


<?php $con->close(); ?>