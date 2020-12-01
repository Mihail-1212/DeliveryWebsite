"use strict"
window.addEventListener("load", function(e){
    var add_to_basket_button = document.getElementById('add_to_basket');
    var productId_curent = productId;
    add_to_basket_button.addEventListener("click", function(e){
        var arrayBasket = getCookie('basket');
        if(arrayBasket === undefined || arrayBasket == 'undefined') {
            arrayBasket = [];
        } else {
            arrayBasket = JSON.parse(arrayBasket);
        }
        if (arrayBasket.find(function(element, index, array){return element['productId'] == productId_curent;})){
            var alreadyAddedToBasket = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("alreadyAddedToBasket")[0];
           	clone(alreadyAddedToBasket, document.getElementsByClassName("block_alert")[0]);
            //console.log("is contain!");
            // alreadyAddedToBasket
            return;
        }
        arrayBasket.push({"productId": productId_curent, "count": 1, "locality": localityId});
        var onStringify = JSON.stringify(arrayBasket);
        setCookie('basket', onStringify); // updating basket
        console.log(arrayBasket);
        var success = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("success")[0];
        clone(success, document.getElementsByClassName("block_alert")[0]);
    });
    
});