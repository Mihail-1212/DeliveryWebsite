"use strict";
window.addEventListener("load", async function(){
    var userRows = document.getElementsByClassName('userRow');
    for(let i = 0; i < userRows.length; i++) {
        userRows[i].addEventListener('click', function(e){
            var currentRow = e.target.closest('.userRow');
            var login = currentRow.dataset.login;
            var url = window.location.href;    
            if (url.indexOf('?') > -1){
               url += '&edit=' + login;
            }else{
               url += '?edit=' + login;
            }
            window.location.href = url;
        });
    }
});