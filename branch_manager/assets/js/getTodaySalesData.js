  
const getTodaySalesData = () => {
    $.ajax({
      url: 'backend/end-points/getTodaySalesData.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
          console.log(response); 
          let TodaySales  = response.TodaySales;
        
        //  $('.TodaySales').text('₱' + TodaySales.toLocaleString()).show();
         $('.TodaySales').text(TodaySales);


            
      },
    });
  };
  
  getTodaySalesData();
  
  setInterval(() => {
    getTodaySalesData();
  }, 1000)
  