"use strict";
window.addEventListener("load", async function(){
    var orderIdBlock = document.getElementById('orderIdInput');
    document.getElementById('takeOrderButton').addEventListener('click', async function(e){
        var orderId = orderIdBlock.value;
        if(orderId === undefined) {
            return;
        }
            
        let parameters = {
          order: orderId,
        };
        
        let response = await fetch( url + 'avaible_orders//takeOrder', {
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
            if(orderInfo){
                console.log(orderInfo);
                document.location.reload();
            } else {
                orderInfo = json['error'];
                console.log(orderInfo);
            }
            
        } else {
            console.log("Ошибка HTTP: " + response.status);
        }
    });
});
