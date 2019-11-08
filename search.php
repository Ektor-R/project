<?php

    $con = mysqli_connect('localhost', 'root', '', 'project');
    $contucts = $con->query( "SELECT * FROM contucts");

    $contuctsearch = '';

    //check search
    if(isset($_GET['search'])){
        $ok=true;

        //check if contuctsearch is set
        if(isset($_GET['contuctsearch']) && $_GET['contuctsearch'] !== ''){
            $contuctsearch = $con->real_escape_string($_GET['contuctsearch']);

            $result = $con->query("SELECT name, phone FROM contucts WHERE name = '$contuctsearch' OR phone = '$contuctsearch'");

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
    <title>Search</title>
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
    </tr>
    <?php
        foreach($contucts as $row){
            echo "<tr><td>" . htmlspecialchars($row['name']) . "</td><td>" . htmlspecialchars($row['phone']) . "</td></tr>";
        }
    ?>
</table><br>

<!--output result-->

<?php
if($ok) {
    if($result->num_rows) {
        foreach ($result as $row) {
            echo htmlspecialchars($row['name']) . ": " . htmlspecialchars($row['phone']);
        }
    }else{
        echo htmlspecialchars($contuctsearch) . " is not in your contucts.";
    }
}

$con->close();
?>

</body>
</html>




