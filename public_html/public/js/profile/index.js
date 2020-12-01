"use strict"
window.addEventListener("load", function(){
    var is_success = findGetParameter('success');
    if (is_success == '1'){
        var success = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("success")[0];
        clone(success, document.getElementsByClassName("block_alert")[0]);
    }
    
    var save_changes_button = document.getElementById('save_changes_button');
    var delete_button = document.getElementById('delete_button');
    var surnameBox = document.getElementsByName('surname')[0];
    var nameBox = document.getElementsByName('name')[0];
    var patronymicBox = document.getElementsByName('patronymic')[0];
    var homeAddressBox = document.getElementsByName('homeAddress')[0];

    var modal_window_delete_profile = document.getElementById('modal_window_delete_profile');

    var deleteUser = new Modal_Window(delete_button, modal_window_delete_profile);
    
    save_changes_button.addEventListener("click", async function(){
        
        if(!surnameBox.value || !nameBox.value){
            if(!surnameBox.value){
                var loginMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("surnameMiss")[0];
                clone(loginMiss_alert, document.getElementsByClassName("block_alert")[0]);
            }
            
            if(!nameBox.value) {
                var passwordMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("nameMiss")[0];
                clone(passwordMiss_alert, document.getElementsByClassName("block_alert")[0]);
            }
        } else {
            let parameters = {
              surnameValue: surnameBox.value,
              nameValue: nameBox.value,
              patronymicValue: patronymicBox.value,
              homeAddressValue: homeAddressBox.value,
            };
            let response = await fetch( url + 'profile//saveChanges', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(parameters)
                });
            if (response.ok) {
                let json = await response.json();
                var userToken = json['userToken'];
                var is_success = json['is_success'];
                if(is_success){
                    var curURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    window.location.replace(curURL + '?success=1');
                } else {
                    var uncorrectUserData_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("uncorrectUserData")[0];
                    clone(uncorrectUserData_alert, document.getElementsByClassName("block_alert")[0]);
                }
                
            } else {
                console.log("Ошибка HTTP: " + response.status);
                top.location.reload();
            }
        }
    });

    var deleteUserAccept = document.getElementById('deleteUserAccept');
    deleteUserAccept.addEventListener("click", async function(e){
        let response = await fetch( url + 'profile//deleteProfile', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                    }
                });
        if (response.ok) {
            let json = await response.json();
            var userToken = json['userToken'];
            var is_success = json['is_success'];
            if(is_success){
                top.location.href=url + 'authorization//logout';
            } else {
                var uncorrectUserData_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("uncorrectUserData")[0];
                clone(uncorrectUserData_alert, document.getElementsByClassName("block_alert")[0]);
            }
            
        } else {
            console.log("Ошибка HTTP: " + response.status);
            top.location.reload();
        }
    });
});
