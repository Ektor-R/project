<?php
    header('Content-Type: application/json');
    $con = mysqli_connect('localhost', 'root', '', 'project');

    $contactsearch = '';

    //check search
    if(isset($_GET['contactsearch']) && $_GET['contactsearch'] !== ''){
        $contactsearch = $con->real_escape_string($_GET['contactsearch']);
        $result = $con->query("SELECT * FROM contacts WHERE name LIKE '$contactsearch%' OR phone LIKE '$contactsearch%'");
    }else {
        $result = $con->query( "SELECT * FROM contacts");
    }
    $rows = array();
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }

    echo json_encode($rows);
?>

<?php $con->close(); ?>