$(document).on('click', '.remove-stock-inv', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var table = $(this).data('table');
    var id_name = $(this).data('id_name');
    console.log(id_name);

    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { id: id,table: table, id_name: id_name, requestType: 'GenericDelete' },
                dataType: 'json',  // Expect a JSON response
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            response.message,  // Show the success message from the response
                            'success'
                        ).then(() => {
                            // location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,  // Show the error message from the response
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
});