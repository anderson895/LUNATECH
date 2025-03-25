


$('#adduproductButton').click(function (e) { 
    e.preventDefault();
    $('#addProductModal').fadeIn();
  });  

  $('.addProductModalClose').click(function (e) { 
    e.preventDefault();
    $('#addProductModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#addProductModal").click(function(event) {
        if ($(event.target).is("#addProductModal")) {
            $("#addProductModal").fadeOut();
        }
    });
  










    // $('.togglerDeleteProduct').click(function (e) { 
    $(document).on('click', '.togglerDeleteProduct', function(e) {
        e.preventDefault();
        var prod_id = $(this).data('prod_id');
        console.log(prod_id);
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "backend/end-points/controller.php",
                    type: 'POST',
                    data: { prod_id: prod_id, requestType: 'DeleteProduct' },
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









$('.togglerDeleteUserAdmin').click(function (e) { 
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { user_id: id, requestType: 'DeleteUser' },
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






// $('.togglerDeleteBranch').click(function (e) { 
$(document).on('click', '.togglerDeleteBranch', function(e) {
    e.preventDefault();
    var branchId = $(this).data('branch_id');
    console.log(branchId);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: { branch_id: branchId, requestType: 'deletebranch' },
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





// $('.togglerUpdateProduct').click(function (e) { 
$(document).on('click', '.togglerUpdateProduct', function(e) {
    var prod_id = $(this).data('prod_id');
    var prod_name = $(this).data('prod_name');
    var prod_capital = $(this).data('prod_capital');
    var prod_price = $(this).data('prod_price');

    $('#update_prod_id').val(prod_id);
    $('#update_prod_name').val(prod_name);
    $('#update_product_capital').val(prod_capital);
    $('#update_prod_price').val(prod_price);

    console.log(prod_capital);
    
    e.preventDefault();
    $('#updateProductModal').fadeIn();
});




$('.updateProductModalClose').click(function (e) { 
    e.preventDefault();
    $('#updateProductModal').fadeOut();
  });  

    // Close Modal when clicking outside the modal content
    $("#updateProductModal").click(function(event) {
        if ($(event.target).is("#updateProductModal")) {
            $("#updateProductModal").fadeOut();
        }
    });



// $('.togglerUpdateBranch').click(function (e) { 
$(document).on('click', '.togglerUpdateBranch', function(e) {
    var branch_id = $(this).data('branch_id');
    var branch_code = $(this).data('branch_code');
    var branch_name = $(this).data('branch_name');
    var branch_address = $(this).data('branch_address');
    var branch_started = $(this).data('branch_started');
    var branch_manager_id = $(this).data('branch_manager_id');
    var user_fullname = $(this).data('user_fullname');
    var branch_tel = $(this).data('branch_tel');

    // Populate the form fields
    $('#branch_id').val(branch_id);
    $('#update_branch_code').val(branch_code);
    $('#update_branch_name').val(branch_name);
    $('#update_branch_address').val(branch_address);
    $('#update_branch_started').val(branch_started);
    $('#branch_tel').val(branch_tel);

    // Set the branch manager
    $('#currentValue').val(branch_manager_id);
    $('#currentValue').text(user_fullname);
    
    e.preventDefault();
    $('#updateUserModal').fadeIn();
});



















$('.togglerUpdateUserAdmin').click(function (e) { 
    var id =$(this).data('id');
    var user_fullname =$(this).data('user_fullname');
    var user_email =$(this).data('user_email');
    var user_username =$(this).data('user_username');
    var user_type =$(this).data('user_type');


    $('#update_id').val(id)
    $('#update_user_fullname').val(user_fullname)
    $('#update_user_username').val(user_username)
    $('#update_user_email').val(user_email)
    $('#update_user_type').val(user_type)
   
    
    e.preventDefault();
    $('#updateUserModal').fadeIn();
  });  

  $('.UpdateBranchModalClose').click(function (e) { 
    e.preventDefault();
    $('#updateUserModal').fadeOut();
  });  

    // Close Modal when clicking outside the modal content
    $("#updateUserModal").click(function(event) {
        if ($(event.target).is("#updateUserModal")) {
            $("#updateUserModal").fadeOut();
        }
    });



$('#adduserButton').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeIn();
  });  

  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeOut();
  });  

   // Close Modal when clicking outside the modal content
   $("#addUserModal").click(function(event) {
        if ($(event.target).is("#addUserModal")) {
            $("#addUserModal").fadeOut();
        }
    });
  
  


  $('#addBranchButton').click(function (e) { 
    e.preventDefault();
    $('#addBranchModal').fadeIn();
  });  


  $('.addBranchModalClose').click(function (e) { 
    e.preventDefault();
    $('#addBranchModal').fadeOut();
  });  
  // Close Modal when clicking outside the modal content
    $("#addBranchModal").click(function(event) {
        if ($(event.target).is("#addBranchModal")) {
            $("#addBranchModal").fadeOut();
        }
    });


$(document).ready(function () {

   




    $("#addbranchForm").submit(function (e) {
            e.preventDefault();


            $('.spinner').show();
            $('#btnAddBranches').prop('disabled', true);
        
            var formData = new FormData(this); 
            formData.append('requestType', 'addbranch');
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json", // Expect JSON response
                beforeSend: function () {
                    $("#btnAddBranches").prop("disabled", true).text("Processing...");
                },
                success: function (response) {
                    console.log(response); // Debugging
                    
                    if (response.status === 200) {
                        alertify.success(response.message);
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        $('.spinner').hide();
                        $('#btnAddBranches').prop('disabled', false);
                        alertify.error(response.message);
                    }
                },
                complete: function () {
                    $("#btnAddBranches").prop("disabled", false).text("Submit");
                }
            });
        });










        $("#updateProductForm").submit(function (e) {
            e.preventDefault();
    
            $('.spinner').show();
            $('#btnUpdateroduct').prop('disabled', true);
        
            var formData = new FormData(this);
            formData.append('requestType', 'updateProduct'); 
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json", // Expect JSON response
                beforeSend: function () {
                    $("#btnUpdateroduct").prop("disabled", true).text("Processing...");
                },
                success: function (response) {
                    console.log(response); // Debugging
                    
                    if (response.status === 200) {
                        alertify.success(response.message);
                        // setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        $('.spinner').hide();
                        $('#btnUpdateroduct').prop('disabled', false);
                        alertify.error(response.message);
                    }
                },
                complete: function () {
                    $("#btnUpdateroduct").prop("disabled", false).text("Submit");
                }
            });
        });








        $("#updatebranchForm").submit(function (e) {
            e.preventDefault();
    
            $('.spinner').show();
            $('#btnUpdateBranches').prop('disabled', true);
        
            var formData = new FormData(this);
            formData.append('requestType', 'updatebranch'); 
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json", // Expect JSON response
                beforeSend: function () {
                    $("#btnUpdateBranches").prop("disabled", true).text("Processing...");
                },
                success: function (response) {
                    console.log(response); // Debugging
                    
                    if (response.status === 200) {
                        alertify.success(response.message);
                        $('.spinner').hide();
                        $('#btnUpdateBranches').prop('disabled', false);
                        $('#updateUserModal').fadeOut();
                        // setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        $('.spinner').hide();
                        $('#btnUpdateBranches').prop('disabled', false);
                        alertify.error(response.message);
                    }
                },
                complete: function () {
                    $("#btnUpdateBranches").prop("disabled", false).text("Submit");
                }
            });
        });



       
          
        








    $("#adduserForm").submit(function (e) {
        e.preventDefault();


        $('.spinner').show();
        $('#btnAdduser').prop('disabled', true);
    
        var formData = new FormData(this); 
        formData.append('requestType', 'Adduser');
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // Expect JSON response
            beforeSend: function () {
                $("#submitBtn").prop("disabled", true).text("Processing...");
            },
            success: function (response) {
                console.log(response); // Debugging
                
                if (response.status === 200) {
                    alertify.success(response.message);
                    setTimeout(function () { location.reload(); }, 1000);
                } else {
                    $('.spinner').hide();
                    $('#btnAdduser').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Log detailed error response
                alertify.error("Something went wrong. Please try again.");
            },
            complete: function () {
                $("#submitBtn").prop("disabled", false).text("Submit");
            }
        });
    });





    $("#updateuserForm").submit(function (e) {
        e.preventDefault();


        $('.spinner').show();
        $('#btnUpdateuser').prop('disabled', true);
    
        var formData = new FormData(this); // Use FormData for better handling
        formData.append('requestType', 'Updateuser'); // Append request type
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // Expect JSON response
            beforeSend: function () {
                $("#submitBtn").prop("disabled", true).text("Processing...");
            },
            success: function (response) {
                console.log(response); // Debugging
                
                if (response.status === 200) {
                    alertify.success(response.message);
                    setTimeout(function () { location.reload(); }, 1000);
                } else {
                    $('.spinner').hide();
                    $('#btnUpdateuser').prop('disabled', false);
                    alertify.error(response.message);
                }
            },
            complete: function () {
                $("#submitBtn").prop("disabled", false).text("Submit");
            }
        });
    });
    
});
