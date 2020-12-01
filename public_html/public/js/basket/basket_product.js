"use strict"
window.addEventListener("load", function(e){
    var is_success = findGetParameter('success');
    if (is_success == '1'){
        var success = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("success")[0];
        clone(success, document.getElementsByClassName("block_alert")[0]);
    }
    
	var total_sum_block = document.getElementById('total');

	function setTotal_sum_block(new_total){
		total_sum_block.innerHTML = 'Итого: ' + new_total + ' ₽';
	}

	function updateSum(){
		var change_count_basket_inputs = document.getElementsByClassName("change_count_basket");
		var total_sum = 0;
		for(var i = 0; i < change_count_basket_inputs.length; i++){
			var curInput = change_count_basket_inputs[i];
			var sumProduct = curInput.closest('.basket_product_item').getElementsByClassName('basket_product_item_product_price_sum')[0];
			sumProduct = sumProduct.innerHTML.replace('₽', '').trim();
			sumProduct = sumProduct.replace(',', '.');
			total_sum += curInput.value * sumProduct;
		}
		setTotal_sum_block(total_sum);
		// change_count_basket
	}

	document.addEventListener('input',function(e){
	    if(e.target && e.target.classList.contains('change_count_basket')){
	         	updateSum();
	     }
	 });

	document.addEventListener('click', function(e){
		if(e.target && e.target.classList.contains('delete_product_click')){
		    var product_item = e.target.closest('.basket_product_item');
		    product_item.remove();
	        updateSum();
		    var productid = product_item.dataset.productid;
		    // productid
		    var basket_cookie = getCookie('basket');    // получаем корзину
		    //  $basket_items = json_decode($cookie_items, true);
		    basket_cookie = JSON.parse(basket_cookie);
		    basket_cookie.forEach((item, index, object) => {
		        if(productid == item.productId)
		            object.splice(index, 1);
		    });
		    var onStringify = JSON.stringify(basket_cookie);
            setCookie('basket', onStringify);
		    // getCookie
	     }
	});
	updateSum();
});