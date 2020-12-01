window.addEventListener("load", async function(){
    var circleMarker;
    
	mapboxgl.accessToken = 'pk.eyJ1IjoiYXNzYXNzaW44NDEyIiwiYSI6ImNraDRsODkzdzA1OGsycm1uanZla2wzdDIifQ.N1fc9zLRo2wLXOnPdbg2hQ';
	var map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v10',
		center: localityCoord,
		zoom: 12,
	});
	map.addControl(new mapboxgl.FullscreenControl());

	map.on('load', function () {
		map.getStyle().layers.forEach(function(thisLayer){
		  if(thisLayer.type == 'symbol'){
		    map.setLayoutProperty(thisLayer.id, 'text-field', ['get','name_ru'])
		  }
		});
		// circleMarker = new mapboxgl.Marker().setLngLat(localityCoord).addTo(map); 
	});

	var button_show_additional_noted = document.getElementById('button_show_additional_noted');
    var button_show_basket = document.getElementById('button_show_basket');
    var orderTake_show_button = document.getElementById('orderTake');

    var modal_window_show_additional_noted = document.getElementById('modal_window_show_additional_noted');
    var modal_window_show_basket = document.getElementById('modal_window_show_basket');
    var modal_window_take_order = document.getElementById('modal_window_take_order');

    var additional_noted = new Modal_Window(button_show_additional_noted, modal_window_show_additional_noted);
    var basket = new Modal_Window(button_show_basket, modal_window_show_basket);
    var takeOrder = new Modal_Window(orderTake_show_button, modal_window_take_order);
    
    //modal_window_take_order

    async function FetchGetOrder(parameters){
        let response = await fetch( url + 'avaible_orders//getOrderInfoFull', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(parameters)
        });
        if (response.ok) {
            let json = await response.json();
            // json['orderInfo']
            var orderInfo = json['orderInfo'];
            document.getElementById('additional_noted_block').innerHTML = orderInfo['additional_notes'];
            document.getElementById('info_body_sum').innerHTML = orderInfo['sum'] + ' ₽';
            var date = Date.parse(orderInfo['create_date']);
            date = await getDateTime(date);
            document.getElementById('info_body_create_date').innerHTML = date;
            document.getElementById('orderIdInput').value = orderInfo['logId'];
            
            document.getElementById('info_body_client').innerHTML = orderInfo['surname'] + ' ' + orderInfo['name'] + ' ' + orderInfo['patronymic'];
            // orderIdInput
            var coords = orderInfo['coordinates'].split(", ");
            var new_coord = coords[0];
            coords[0] = coords[1];
            coords[1] = new_coord;
            if(circleMarker !== undefined){
                circleMarker.remove();
            }
            circleMarker = new mapboxgl.Marker().setLngLat(coords).addTo(map); 
            map.flyTo({
                center: circleMarker._lngLat,
                });
                
            var basket = json['basketInfo'];
            
            var basket_block = document.getElementById('basket_block');
            
            while (basket_block.firstChild) {
                basket_block.removeChild(basket_block.lastChild);
            }
            
            for(var i = 0; i < basket.length; i++){
                var basket_item = basket[i];
                var div_main = document.createElement("div");
                div_main.classList.add("order_item");
                
                var name_div = document.createElement("div");
                name_div.innerHTML = basket_item['name'];
                name_div.classList.add("order_item__value");
                div_main.appendChild(name_div);
                
                var count_div = document.createElement("div");
                count_div.innerHTML = basket_item['count'];
                count_div.classList.add("order_item__value");
                div_main.appendChild(count_div);
                
                var price_div = document.createElement("div");
                price_div.innerHTML = basket_item['price'] + ' ₽';
                price_div.classList.add("order_item__value");
                div_main.appendChild(price_div);
                
                //  setAttribute('onclick','writeLED(1,1)')
                
                div_main.setAttribute('onclick', "document.location.href='" + url + basket_item['category_name'] +'/' + basket_item['productId'] + "';");
                
                basket_block.appendChild(div_main);
            }
            orderTake_show_button.style.visibility = "visible";
            //basket_block
            
        } else {
            console.log("Ошибка HTTP: " + response.status);
        }
    }
    
    var order_items = document.getElementById('order_list_group').querySelectorAll('.order_item:not(.title_item)');
    for(let i = 0; i < order_items.length; i++){
        var order_item = order_items[i];
        order_item.addEventListener('click', async function(e){
            var closestOrderItem = e.target.closest('.order_item');
            var orderId = closestOrderItem.dataset.order;                //  setAttribute('onclick','writeLED(1,1)')
    		let parameters = {
              order: orderId,
            };
            FetchGetOrder(parameters);
    	});
    }
});