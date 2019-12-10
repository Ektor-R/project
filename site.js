$(function() {


    var searchFunction = function () {
        var searchText = $('#search').val();

        fetch(`contacts2.php?contactsearch=${searchText}&search=Search`, {
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            }
        }).then(response => {

            $('tbody').empty();
            response.json().then(data => {
                console.table(data);
                data.forEach((item, index, array) => {
                    console.log(item);
                    $('tbody').append(`<tr><td>${item.name}</td><Td>${item.phone}</Td><Td><button>test</button></Td>`)
                });
            });
        });
    }
    searchFunction();
    $('button').click(() => searchFunction());

    $('#search').on('input', () => searchFunction());
});





