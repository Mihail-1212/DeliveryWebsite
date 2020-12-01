"use strict";
window.addEventListener("load", async function(){

    var save_changes_button = document.getElementById('save_changes_button');
    
    var modal_window_delete_profile = document.getElementById('modal_window_delete_profile');
    var delete_button = document.getElementById('delete_button');
    
    var modal_delete_user = new Modal_Window(delete_button, modal_window_delete_profile);
    // modal_window_delete_profile
    
    var surnameBox = document.getElementsByName('surname')[0];
    var nameBox = document.getElementsByName('name')[0];
    var patronymicBox = document.getElementsByName('patronymic')[0];
    var homeAddressBox = document.getElementsByName('homeAddress')[0];
    var rightSelectBlock = document.getElementById('current_user_rights');
    var isAdmin = document.getElementById('isAdminCheckbox');
    var loginValue = findGetParameter('edit');
    
    save_changes_button.addEventListener('click', async function(e){
        
        if(!surnameBox.value || !nameBox.value || !rightSelectBlock.value){
            var loginMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("uncorrectUserData")[0];
            clone(loginMiss_alert, document.getElementsByClassName("block_alert")[0]);
        } else {
            let parameters = {
                loginValue: loginValue,
                surnameValue: surnameBox.value,
                nameValue: nameBox.value,
                patronymicValue: patronymicBox.value,
                homeAddressValue: homeAddressBox.value,
                rightsValue: rightSelectBlock.value,
                isAdminValue: isAdmin.checked,
            };
            
            let response = await fetch( url + 'admin//saveUserEdit', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(parameters)
                });
            if (response.ok) {
                let json = await response.json();
                if(json['success']){
                    var success = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("success")[0];
                    clone(success, document.getElementsByClassName("block_alert")[0]);
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
    
    document.getElementById('deleteUserAccept').addEventListener('click', async function(e){
        let parameters = {
            loginValue: loginValue
        };
        let response = await fetch( url + 'admin//deleteUserAdmin', {
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
                window.history.back();
            } else {
                console.log("Ошибка");
            }
            
        } else {
            console.log("Ошибка HTTP: " + response.status);
            top.location.reload();
        }
    });
    //deleteUserAccept
});