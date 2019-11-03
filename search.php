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
    $contuctsearch = '';

    //check search
    if(isset($_GET['search'])){
        $ok=true;

        //check if contuctsearch is set
        if(isset($_GET['contuctsearch']) && $_GET['contuctsearch'] !== ''){
            $contuctsearch = $_GET['contuctsearch'];
        }else{
            $ok=false;
        }
    }else {
        $ok=false;
    }
?>

<!-- search bar -->

<form method="GET" action="">
    <input type="search" name="contuctsearch" placeholder="Search" value="<?php echo $contuctsearch; ?>">
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
    if (array_key_exists($contuctsearch, $contucts)) {
        echo $contuctsearch . ": " . $contucts[$contuctsearch];
    } else if(in_array($contuctsearch, $contucts)){
        echo array_search($contuctsearch, $contucts);
        }else{
        echo htmlspecialchars($contuctsearch) . " is not in your contucts.";
    }
}
?>

</body>
</html>
