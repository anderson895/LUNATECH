  
const getDataAnalytics = () => {
    $.ajax({
      url: 'backend/end-points/getDataAnalytics.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
          console.log(response); 
          let totalUser  = response.totalUser;
          let totalBranches  = response.totalBranches;
          let totalProduct  = response.totalProduct;
         
        
            $('.totalUser').text(totalUser).show(); 
            $('.totalBranches').text(totalBranches).show(); 
            $('.totalProduct').text(totalProduct).show(); 
            // $('.totalSales').text('₱' + totalSales.toLocaleString()).show();


            
      },
    });
  };
  
  getDataAnalytics();
  
  setInterval(() => {
    getDataAnalytics();
  }, 1000)
  