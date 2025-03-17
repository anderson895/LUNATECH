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

  $('.togglerUpdateUserClose').click(function (e) { 
    e.preventDefault();
    $('#updateUserModal').fadeOut();
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
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Log detailed error response
                alertify.error("Something went wrong. Please try again.");
            },
            complete: function () {
                $("#btnAddBranches").prop("disabled", false).text("Submit");
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
