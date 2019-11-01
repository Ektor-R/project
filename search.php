<!DOCTYPE>
<html>
<head>
    <title>Search</title>
</head>
<body>

<?php
    $contucts = array(
            "Ektoras" => "6959408130",
            "Konstantinos" => "6945873669",
            "Panos" => "6989405121",
            "Maria" => "6972891833");
    $namesearch = '';

    //check search
    if(isset($_GET['search'])){
        $ok=true;

        //check if name is set
        if(isset($_GET['namesearch']) && $_GET['namesearch'] !== ''){
            $namesearch = $_GET['namesearch'];
        }else{
            $ok=false;
        }
    }else {
        $ok=false;
    }
?>

<!-- search bar -->

<form method="GET" action="">
    <input type="search" name="namesearch" placeholder="Search" value="<?php echo $namesearch; ?>">
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
        foreach($contucts as $rowname => $rownumber){
            echo "<tr><td>" . $rowname . "</td><td>" . $rownumber . "</td></tr>";
        }
    ?>
</table><br>

<!--output result-->

<?php
if($ok) {
    if (array_key_exists($namesearch, $contucts)) {
        echo $namesearch . ": " . $contucts[$namesearch];
    } else {
        echo htmlspecialchars($namesearch) . " is not in your contucts.";
    }
}
?>

</body>
</html>
