  
const getDataAnalytics = () => {
    $.ajax({
      url: 'backend/end-points/getDataAnalytics.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
          console.log(response); 
          let TotalItems  = response.stockCount;
          let purchase_record_count  = response.purchase_record_count;
          let most_purchased_item  = response.most_purchased_item;
         
        
            $('.TotalItems').text(TotalItems).show(); 
            $('.purchase_record_count').text(purchase_record_count).show(); 
            $('.most_purchased_item').text(most_purchased_item).show(); 
            // $('.totalSales').text('₱' + totalSales.toLocaleString()).show();


            
      },
    });
  };
  
  getDataAnalytics();
  
  setInterval(() => {
    getDataAnalytics();
  }, 1000)
  