/* Look for any elements with the class "custom-select": */

window.addEventListener("load", function(){
	mapboxgl.accessToken = 'pk.eyJ1IjoiYXNzYXNzaW44NDEyIiwiYSI6ImNraDRsODkzdzA1OGsycm1uanZla2wzdDIifQ.N1fc9zLRo2wLXOnPdbg2hQ';
	var map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v10',
		center: localityCoord,
		zoom: 10,
	});
	map.addControl(new mapboxgl.FullscreenControl());
	var GeoCoder = new MapboxGeocoder({
			accessToken: mapboxgl.accessToken,
			mapboxgl: mapboxgl,
			marker: false, 
	});
	map.addControl(GeoCoder, 'top-left');

	GeoCoder.on('result', function(ev) {
		addMarker(ev.result.geometry.coordinates);
      	// map.getSource('single-point').setData(ev.result.geometry);
    });

	map.on('load', function () {
		map.getStyle().layers.forEach(function(thisLayer){
		  if(thisLayer.type == 'symbol'){
		    map.setLayoutProperty(thisLayer.id, 'text-field', ['get','name_ru'])
		  }
		});

		map.on('click', function(e){
			addMarker(e.lngLat.wrap());
		});
	});

	var circleMarker;

	function addMarker(coordinates){
		if(circleMarker !== undefined){
			circleMarker.remove();
		}
		circleMarker = new mapboxgl.Marker().setLngLat(coordinates).addTo(map); 
	}

	var checkoutButton = document.getElementById("checkoutButton");
	var checkoutButtonAccept = document.getElementById("checkoutButtonAccept");
	
	var modal_window_save_order = document.getElementById('modal_window_save_order');

    var saveOrder = new Modal_Window(checkoutButton, modal_window_save_order);
    
    var textarea_additional_notes = document.getElementsByName('additional_notes')[0];
	
	checkoutButton.addEventListener('click', function(e){topFunction();});
	
	checkoutButtonAccept.addEventListener('click', async function(e){
		if(circleMarker === undefined){
			console.log("error");
			var unFindedPlace = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("unFindedPlace")[0];
           	clone(unFindedPlace, document.getElementsByClassName("block_alert")[0]);
			return;
		}
		//basket_product_item
		var basket_product_items = document.getElementsByClassName('basket_product_item');
		var countTotalSum = 0;
		for (var i = 0; i < basket_product_items.length; i++){
		    var curItem = basket_product_items[i];
		    var curCountBlock = curItem.getElementsByClassName('change_count_basket')[0];
		    countTotalSum += curCountBlock.value;
		}
		if(basket_product_items.length == 0 
		    || countTotalSum == 0
		){
		    console.log("error");
			var unFindedBasket = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("unFindedBasket")[0];
           	clone(unFindedBasket, document.getElementsByClassName("block_alert")[0]);
		    return;
		}
		var lngLat = circleMarker._lngLat;
		console.log(lngLat);
		
		// ajax -> success
		let product_array = [];
		for (var i = 0; i < basket_product_items.length; i++){
		    var curItem = basket_product_items[i];
		    var curCountValue = curItem.getElementsByClassName('change_count_basket')[0].value;
		    console.log(curItem.dataset.productid);
		    if(curCountValue != 0) {
		         product_array.push({
        	        productId: curItem.dataset.productid,
        	        productCount: curCountValue
        	    });
		    }
		}
		
		let parameters = {
          products: product_array,
          coords: [lngLat.lat, lngLat.lng],
          additional_notes: textarea_additional_notes.value
        };
        let response = await fetch( url + 'basket//saveOrder', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(parameters)
            });
        if (response.ok) {
            
            let json = await response.json();
            console.log(json['userToken']);
            var userToken = json['userToken'];
            if(userToken != null){
                deleteCookie('basket');
        		var curURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
        		window.location.href = curURL + '?success=1';
                // top.location.reload();
            } else {
                var uncorrectUserData_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("uncorrectUserData")[0];
                clone(uncorrectUserData_alert, document.getElementsByClassName("block_alert")[0]);
            }
            
            
            
        } else {
            console.log("Ошибка HTTP: " + response.status);
        }
		

	});
});