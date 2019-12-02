<?php

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
<div class="container-fluid" id="main">

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
                    <a href="contacts.php" class="btn btn-dark">Contacts</a>
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
                    if($result->num_rows) {
                        foreach ($result as $row) {
                            echo "
                            <tr id='" . $row['id'] . "'>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td><button class='btn btn-secondary btn-sm' onclick='/*editClick(" . $row['id'] . ", \"". $row['name'] . "\", \"" . $row['phone'] . "\"), */openEdit(" . $row['id'] . ", \"". $row['name'] . "\", \"" . $row['phone'] . "\")'>Edit</button> 
                                    <form class='d-inline-block m-0' method='POST' action='delete.php'>
                                        <input class='btn btn-secondary btn-sm' type='submit' onclick='deleteClick()' value='Delete'>
                                        <input type='hidden' name='id' value=" . $row['id'] . ">
                                    </form>
                                        </td>
                            </tr>";
                            }
                    }else{
                        echo "<p class='d-flex justify-content-center'>" . htmlspecialchars($contactsearch) . " is not in your contacts. Do you want to add it? </p>
                            <form method='POST' action=''>
                            <tr>
                                <td><input class='form-control' type='text' name='newname'"; if(!ctype_digit($contactsearch)){ echo "value=" . $contactsearch;}else{echo "placeholder='e.g. Nikos'";} echo " required></td>
                                <td><input class='form-control' type='text' name='newphone'"; if(ctype_digit($contactsearch)){ echo "value=" . $contactsearch;}else{echo "placeholder='e.g. 6983574327'";} echo" required></td>
                                <td><input class='btn btn-secondary' type='submit' name='add' value='Add'></td>
                            </tr>
                        </form>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
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

<!-- edit panel -->
<div class="bg-light border-left" id="editPanel">
    <div>
        <button class="btn btn-light" onclick="closeEdit()">&times;</button>
    </div>
    <form method="POST" action="edit.php">
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" id="editName" type="text" name="editname" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input class="form-control" id="editPhone" type="text" name="editphone" required>
        </div>
        <div>
            <input class="btn btn-secondary" type="submit" name="edit" value="Edit">
            <input class="btn btn-secondary" type="reset">
            <input type="hidden" id="editHidden" name="id">
        </div>
    </form>
</div>

<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function () {
        <?php
        if(isset($_POST['add'])){
            if($added){
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Done!',
                    html:
                        '<table class=\"table table-bordered table-sm\"><thead class=\"thead-dark\"><tr><th>Name</th><th>Phone</th></tr></thead>' +
                        '<tbody><tr><td>" . $newname . "</td><td>" . $newphone . "</td></tr></tbody></table>',
                    text: '" . $newname . " : " . $newphone . " is now in your contacts!',
                    confirmButtonColor: '#6c757d'
                })";
            }else{
                echo "Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonColor: '#6c757d',
                    footer: 'Maby the number is already in your contacts.'
                })";
            }
        }
        ?>
    });

    function deleteClick(){
        event.preventDefault();
        var form = event.target.form;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }else{
                Swal.fire({
                    title: 'Cancelled!',
                    text: 'Your contact is safe.',
                    confirmButtonColor: '#6c757d'
                })
            }
        })
    }

    function editClick(id, name, phone){
        document.getElementById(id).innerHTML = "<form method='POST' action='edit.php'>" +
            "<td><input class='form-control form-control-sm' type='text' name='editname' value="+ name +"></td>" +
            "<td><input class='form-control form-control-sm' type='text' name='editphone' value="+ phone +"></td>" +
            "<td><input class='btn btn-secondary btn-sm' type='submit' value='Edit'> <input class='btn btn-secondary btn-sm' type='reset' value=' Reset '></td>" +
            "<input type='hidden' name='id' value="+ id +">" +
         "</form>";
    }

    //sidepanel
    function openEdit(id, name, phone){
        document.getElementById("main").style.opacity = "0.4";
        document.getElementById("editPanel").style.width = "250px";
        document.getElementById("editPanel").style.padding = "0px 10px 0px 10px";
        document.getElementById("editName").value = name;
        document.getElementById("editPhone").value = phone;
        document.getElementById("editHidden").value = id;
    }
    function closeEdit(){
        document.getElementById("main").style.opacity = "1";
        document.getElementById("editPanel").style.width = "0px";
        document.getElementById("editPanel").style.padding = "0px";
    }

</script>
</body>
</html>
<?php $con->close(); ?>