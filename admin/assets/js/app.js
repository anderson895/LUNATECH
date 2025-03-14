$('#adduserButton').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeIn();
  });  


  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeOut();
  });  




  $("#adduserForm").submit(function (e) {
    e.preventDefault();
    
    var formData = $(this).serializeArray();
    formData.push({ name: 'requestType', value: 'Adduser' });
    var serializedData = $.param(formData);
  
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {
        if (response == "200") {
          alertify.success('Added Successful');
          $('#addUserModal').fadeOut();
          setTimeout(function () {
            location.reload(); 
          }, 1000); 
        } else {
          console.log(response);
          alertify.error('Added Failed. Please check the details.');
        }
      },
    });
    
  });