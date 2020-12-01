"use strict"
window.addEventListener("load", async function(){
    //  orderCancle
    var orderIdBlock = document.getElementById('orderIdInput');
    document.getElementById('cancelOrderButtonSubmit').addEventListener('click', async function(e){

        let parameters = {
            order: orderIdBlock.value,
        };
        
        let response = await fetch( url + 'your_orders//setOrderStatusCancel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(parameters)
        });
        if (response.ok) {
            let json = await response.json();
            console.log(json);
            if(json['success']){
                document.location.reload();
            } else {
                console.log(json['error']);
            }
        } else {
            console.log("Ошибка HTTP: " + response.status);
        }
    });
    
});