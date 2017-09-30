function updateCartPage() {
	var total_price;
	total_price = parseFloat($('#cart_total_price').val());
	$('#order_total_price').html(formatPrice(total_price));
}

$(function(){
  $('.cart .prod-count-input').blur(function() {
    var id = parseInt($(this).attr('product-id'));
    if (Number.isInteger(id)) {
      var cnt = parseInt($(this).val());
      if (!Number.isInteger(cnt)) {
          cnt = 0;
      }
      setItemCount(id, cnt);
      updateProductInCart(id);
      updateCartPage();
    }
  });
	updateCartPage();
});
