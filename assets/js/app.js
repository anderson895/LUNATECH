$("#frmLogin").submit(function (e) {
    e.preventDefault();
    
    let username = $("#username").val().trim();
    let password = $("#password").val().trim();
    
    // Validate Username
    if (!username) {
        alertify.error("Username is required");    
        return;
    }
    
    // Validate Password
    if (!password) {
        alertify.error("Password is required");    
        return;
    }
    


    $('.spinner').show();
    $('#btnLoginGuidance').prop('disabled', true);

    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'Login' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: serializedData,  
        success: function (response) {
            var data = JSON.parse(response);
            console.log(response);

            if (data.status === "success") {
                alertify.success('Login Successful');

                // Redirect to the correct page dynamically
                setTimeout(function() {
                    window.location.href = data.redirect;
                }, 2000);

            } else if (data.status === "error") {
                console.log(data);
                $('.spinner').hide();
                $('#btnLoginGuidance').prop('disabled', false);
                alertify.error(data.message);
            } else {
                $('.spinner').hide();
                $('#btnLoginGuidance').prop('disabled', false);
                console.error(response);
                alertify.error('Login failed, please try again.');
            }
        },
        error: function () {
            $('.spinner').hide();
            $('#btnLoginGuidance').prop('disabled', false);
            alertify.error('Server error, please try again later.');
        }
    });
});
