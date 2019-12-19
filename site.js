$(function() {

    var searchFunction = function () {
        var searchText = $('#search').val();

        fetch(`search.php?contactsearch=${searchText}`, {
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            }
        }).then(response => {
            $('tbody').empty();
            $('#message').empty();
            response.json().then(data => {
                if(data.length){
                    data.forEach((item, index, array) => {
                        $('tbody').append(`<tr id='editRow_${item.id}'>
                            <td>${item.name}</td>
                            <td>${item.phone}</td>
                            <td><button class='btn btn-secondary btn-sm' onclick='editClick(${item.id}, "${item.name}", "${item.phone}")'>Edit</button> 
                                <form class='d-inline-block m-0' method='POST' action='delete.php'>
                                    <input class='btn btn-secondary btn-sm' type='submit' onclick='deleteClick()' name='delete' value='Delete'>
                                    <input type='hidden' name='id' value=${item.id}>
                                </form>
                            </td>
                        </tr>`)
                    });
                } else{
                    $('#message').append($('#search').val() + ' is not in your contacts.');
                }
            });
        });
    }
    searchFunction();
    $('#search').on('input', () => searchFunction());
    $('#search').on('keypress', event => {
        if(event.keyCode==13){
            event.preventDefault();
        }
    });

    
    //new contact
    $('#newContact').submit(event =>{
        event.preventDefault();
        const formData = new FormData(document.getElementById('newContact'));

        fetch('add.php', {
            method : 'post',
            body : formData
        }).then(response => {
            response.json().then(data => {
                if (data.added == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        html:
                            '<table class="table table-bordered table-sm"><thead class="thead-dark"><tr><th>Name</th><th>Phone</th></tr></thead>' +
                            '<tbody><tr><td>' + formData.get('newname') + '</td><td>' + formData.get('newphone') + '</td></tr></tbody></table>',
                        text: formData.get['newname'] + ' : ' + formData.get['newphone'] + ' is now in your contacts!',
                        confirmButtonColor: '#6c757d'
                    }).then(result=>{
                        $('#reset').click();
                        searchFunction()
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        confirmButtonColor: '#6c757d',
                        footer: 'Maby the number is already in your contacts.'
                    })
                }
            })
        })
    })

});

//edit inside table
function editClick(id, name, phone){
    document.getElementById('editRow_'+id).innerHTML = "" +
        "<td><input class='form-control form-control-sm' id='editName_"+id+"' type='text' name='editname' value="+ name +"></td>" +
        "<td><input class='form-control form-control-sm' id='editPhone_"+id+"' type='text' name='editphone' value="+ phone +"></td>" +
        "<td><button class='btn btn-secondary btn-sm' id='edit_"+id+"' type='button'>Edit</button> <button class='btn btn-secondary btn-sm' id='editReset_"+id+"' type='button'>Reset</button></td>";
        $('#editReset_'+id).click(()=>{
            $('#editName_'+id).val(name);
            $('#editPhone_'+id).val(phone);
        })
        $('#edit_'+id).click(() => {
            const formData = new FormData;
            formData.append('edit', true);
            formData.append('id', id);
            formData.append('editname', $('#editName_'+id).val());
            formData.append('editphone', $('#editPhone_'+id).val())
            fetch('edit.php', {
                method : 'post',
                body : formData
            }).then(respone => {
                respone.json().then(data=> {
                    if(data.edited){
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            html:
                                '<table class="table table-bordered table-sm"><thead class="thead-dark"><tr><th>Name</th><th>Phone</th></tr></thead>' +
                                '<tbody><tr><td>' + formData.get('editname') + '</td><td>' + formData.get('editphone') + '</td></tr></tbody></table>',
                            text: formData.get['editname'] + ' : ' + formData.get['editphone'] + ' is now in your contacts!',
                            confirmButtonColor: '#6c757d'
                        })
                        searchFunction();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#6c757d',
                            footer: 'Maby the number is already in your contacts.'
                        })
                    }
                })
            })
    })
}

//delete button
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
            const formData = new FormData(form);
            fetch('delete.php', {
                method : 'post',
                body : formData
            }).then(result => {
                result.json().then(data => {
                    if(data.deleted){
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: 'The contact has been deleted!',
                            confirmButtonColor: '#6c757d'
                        })
                        searchFunction();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#6c757d',
                        })
                    }
                })
            })
        }else{
            Swal.fire({
                title: 'Cancelled!',
                text: 'Your contact is safe.',
                confirmButtonColor: '#6c757d'
            })
        }
    })
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





