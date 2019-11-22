<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $editname = '';
        $editphone = '';

        $con = mysqli_connect('localhost', 'root', '', 'project');

        if(isset($_GET['edit'])){
            $editname = mysqli_real_escape_string($con, $_GET['editname']);
            $editphone = mysqli_real_escape_string($con, $_GET['editphone']);

            $con->query("UPDATE contacts SET name = '$editname', phone = '$editphone' WHERE id = $id ");

            $con->close();

            header('Location: contacts.php');
        }

        $contact = $con->query("SELECT * FROM contacts WHERE id = $id");

        $con->close();
    }else{
        header('Location: contacts.php');
    }

?>

<!DOCTYPE>
<html>
<head>
    <title>Edit</title>
</head>
<body>

<div>
    <h3>Edit Contact</h3>
</div>

<div>
    <form method="GET" action="">
        <?php foreach($contact as $row){?>
        <div>
            <label>Name</label>
            <input type="text" name="editname" value="<?php echo $row['name']; ?>" required>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="editphone" value="<?php echo $row['phone']; ?>" required>
        </div>
        <?php } ?>
        <div>
            <input type="submit" name="edit" value="Edit">
            <input type="reset" value="Reset">
        </div>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    </form>
</div>

</body>
</html>
