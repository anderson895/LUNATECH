 // $('.archivedTransaction').click(function (e) { 
    $(document).on('click', '.archivedTransaction', function(e) {
        e.preventDefault();
        var purchase_id = $(this).data('purchase_id');
        console.log(purchase_id);
    
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "backend/end-points/controller.php",
                    type: 'POST',
                    data: { purchase_id: purchase_id, requestType: 'archivedTransaction' },
                    dataType: 'json',  // Expect a JSON response
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire(
                                'Deleted!',
                                response.message,  // Show the success message from the response
                                'success'
                            ).then(() => {
                                location.reload(); 
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