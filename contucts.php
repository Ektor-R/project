<?php

    $con = mysqli_connect('localhost', 'root', '', 'project');

    $contuctsearch = '';
    $newname = '';
    $newphone = '';

    //check new addition
    if(isset($_POST['add'])){
           $newname = $con->real_escape_string($_POST['newname']);
           $newphone = $con->real_escape_string($_POST['newphone']);
           $con->query("INSERT INTO contucts (name, phone) VALUES ('$newname', '$newphone')");
    }

    $contucts = $con->query( "SELECT * FROM contucts");

    //check search
    if(isset($_GET['search'])){
        $ok=true;

        //check if contuctsearch is set
        if(isset($_GET['contuctsearch']) && $_GET['contuctsearch'] !== ''){
            $contuctsearch = $con->real_escape_string($_GET['contuctsearch']);

            $result = $con->query("SELECT name, phone FROM contucts WHERE name LIKE '$contuctsearch%' OR phone = '$contuctsearch'");

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
    <title>Contucts</title>
</head>
<body>


<!-- search bar -->

<form method="GET" action="">
    <input type="search" name="contuctsearch" placeholder="Search" value="<?php echo htmlspecialchars($contuctsearch); ?>">
    <input type="submit" name="search" value="Search">
</form>


<!-- contucts table -->

<table border="1">
    <caption>Contacts</caption>
    <tr>
        <th>Name</th>
        <th>Number</th>
        <th>Action</th>
    </tr>
    <?php
        foreach($contucts as $row){
            echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td><a href=delete.php?id=". $row['id'] ."><input type='submit' name='delete' value='delete'></a></td>
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
        echo htmlspecialchars($contuctsearch) . " is not in your contucts.";
    }
}

$con->close();
?>


<!--new contuct-->

<div>
    <div>
        <h3>New Contuct</h3>
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




