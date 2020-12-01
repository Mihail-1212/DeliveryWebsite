"use strict";
window.addEventListener("load", async function(){
    var current_user_rights = document.getElementById('current_user_rights');
    // initialize
    
    if (current_user_rights !== undefined && current_user_rights.dataset.initialize !== undefined ){
        current_user_rights.value = current_user_rights.dataset.initialize;
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("change", false, true);
        current_user_rights.dispatchEvent(evt);
    }
});