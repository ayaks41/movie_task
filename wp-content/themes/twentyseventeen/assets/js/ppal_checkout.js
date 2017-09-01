(function( $ ) {
  console.log("work");
  $('.ajax_add_to_cart').click(function (e) {
    e.preventDefault();
    var button = $(this);
    var nonce = $('#nonce').val();
    jQuery.ajax({
          type:"POST",
          url: button.attr('href')+"?add-to-cart="+button.data('product_id'),
          data: {
              nonce: nonce,
              quantity: button.data('quantity')
          },
          success:function(data){
          window.location = 'http://wp.task/cart/?startcheckout=true';
          },
          error: function(errorThrown){
              alert(errorThrown);
          }

      });

  });

})( jQuery );
