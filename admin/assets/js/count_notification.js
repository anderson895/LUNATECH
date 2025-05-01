$(document).ready(function () {

    const getCount = () => {
        $.ajax({
        url: "backend/end-points/count_notification.php",
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            //   console.log(response.PendingCounts);
    
              let ListOfRequestCounts = response.ListOfRequestCounts;
              $('#ListOfRequestCounts').text(ListOfRequestCounts);
    
              if (ListOfRequestCounts > 0) {
                  $('#ListOfRequestCounts').show();
              } else {
                  $('#ListOfRequestCounts').hide();
              }
       
          
       
              
              
          },
          error: function(xhr, status, error) {
              console.error("Error fetching order status counts:", error);
          }
      });
    };
    
    setInterval(() => {
        getCount();
      }, 3000);
    
    
      getCount();
    });