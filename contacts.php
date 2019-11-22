<?php

    $con = mysqli_connect('localhost', 'root', '', 'project');

    $contactsearch = '';
    $newname = '';
    $newphone = '';

    //check new addition
    if(isset($_POST['add'])){
           $newname = $con->real_escape_string($_POST['newname']);
           $newphone = $con->real_escape_string($_POST['newphone']);
           $con->query("INSERT INTO contacts (name, phone) VALUES ('$newname', '$newphone')");
    }

    $contacts = $con->query( "SELECT * FROM contacts");

    //check search
    if(isset($_GET['search'])){
        $ok=true;

        //check if contactsearch is set
        if(isset($_GET['contactsearch']) && $_GET['contactsearch'] !== ''){
            $contactsearch = $con->real_escape_string($_GET['contactsearch']);

            $result = $con->query("SELECT name, phone FROM contacts WHERE name LIKE '$contactsearch%' OR phone = '$contactsearch'");

        }else{
            $ok=false;
        }
    }else {
        $ok=false;
    }

?>

<!DOCTYPE>
<html>
<head>
    <title>Contacts</title>
</head>
<body>


<!-- search bar -->

<form method="GET" action="">
    <input type="search" name="contactsearch" placeholder="Search" value="<?php echo htmlspecialchars($contactsearch); ?>">
    <input type="submit" name="search" value="Search">
</form>


<!-- contacts table -->

<table border="1">
    <caption>Contacts</caption>
    <tr>
        <th>Name</th>
        <th>Number</th>
        <th>Action</th>
    </tr>
    <?php
        foreach($contacts as $row){
            echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td><a href=edit.php?id=". $row['id'] .">edit</a> <a href=delete.php?id=". $row['id'] .">delete</a></td>
             </tr> ";
        }
    ?>
</table><br>


<!--search output result-->

<?php
if($ok) {
    if($result->num_rows) {
        foreach ($result as $row) {
            echo htmlspecialchars($row['name']) . ": " . htmlspecialchars($row['phone']) . "<br>";
        }
    }else{
        echo htmlspecialchars($contactsearch) . " is not in your contacts.";
    }
}

$con->close();
?>


<!--new contact-->

<div>
    <div>
        <h3>New Contact</h3>
    </div>

    <hr>

    <form method="POST" action="">
        <div>
            <label>Name</label>
            <input type="text" name="newname" placeholder="e.g. Nikos" required>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="newphone" placeholder="e.g. 6983574327" required>
        </div>
        <div>
            <input type="submit" name="add" value="Add">
            <input type="reset" value="Reset">
        </div>
    </form>
</div>

</body>
</html>




