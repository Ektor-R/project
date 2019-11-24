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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-center">
        <h3>Edit Contact</h3>
    </div>

    <div class="row d-flex justify-content-center">
        <form method="GET" action="">
            <?php foreach($contact as $row){?>
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="editname" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input  class="form-control" type="text" name="editphone" value="<?php echo $row['phone']; ?>" required>
            </div>
            <?php } ?>
            <div>
                <input class="btn btn-secondary" type="submit" name="edit" value="Edit">
                <input class="btn btn-secondary" type="reset" value="Reset">
            </div>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        </form>
    </div>
</div>
</body>
</html>
