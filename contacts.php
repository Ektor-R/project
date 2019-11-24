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

            $result = $con->query("SELECT * FROM contacts WHERE name LIKE '$contactsearch%' OR phone = '$contactsearch'");

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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
<div class="container-fluid">
    <!-- search bar -->
    <div class="row d-flex justify-content-center">
        <form class="form-inline d-flex justify-content-center" method="GET" action="">
            <input class="form-control" type="search" name="contactsearch" placeholder="Search" value="<?php echo htmlspecialchars($contactsearch); ?>">
            <input type="submit" name="search" value="Search" class="btn btn-secondary">
        </form>
    </div>
     <!-- contacts table -->
    <div class="row d-flex justify-content-center">
        <div>
           <table class="table table-bordered table-sm">
                <caption>
                    Contacts
                </caption>
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($contacts as $row){
                            echo "<tr>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td><a class='btn btn-secondary btn-sm' role='button' href=edit.php?id=". $row['id'] .">edit</a> 
                                    <a class='btn btn-secondary btn-sm' role='button' href=delete.php?id=". $row['id'] .">delete</a></td>
                            </tr> ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--search output result-->
    <div class="row d-flex justify-content-center">
            <?php
            if($ok) {
                if($result->num_rows) {
            ?>
            <div>
                <table class="table table-borderless table-sm table-responsive">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php                    
                    foreach ($result as $row) {
                        echo "
                            <tr>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td><a class='btn btn-secondary btn-sm' role='button' href=edit.php?id=". $row['id'] .">edit</a> 
                                    <a class='btn btn-secondary btn-sm' role='button' href=delete.php?id=". $row['id'] .">delete</a></td>
                            </tr>";
                    }
                ?>  </tbody>
                </table>
            </div>
            <?php
                }else{
                    echo htmlspecialchars($contactsearch) . " is not in your contacts.";
                }
            }

            $con->close();
            ?>
    </div>
    
    <hr>

    <!--new contact-->

    <div class="row d-flex justify-content-center">
        <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#newC" aria-expanded="false" aria-controls="collapseExample">
            <h5>New Contact</h5>
        </button>
    </div>
    <div class="collapse" id="newC">
        <div class="row d-flex justify-content-center">
        <form method="POST" action="">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="newname" placeholder="e.g. Nikos" required>
            </div>
            <div class="form-group"> 
                <label>Phone</label>
                <input class="form-control" type="text" name="newphone" placeholder="e.g. 6983574327" required>
            </div>
            <div>
                <input class="btn btn-secondary" type="submit" name="add" value="Add">
                <input class="btn btn-secondary" type="reset" value="Reset">
            </div>
        </form>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>




