"use strict"
window.addEventListener("load", function(){
    var authorizationButton = document.getElementById('registrationButton');
    var userLoginBox = document.getElementsByName('login')[0];
    var userPasswordBox = document.getElementsByName('password')[0];
    var userPasswordBoxRepeat = document.getElementsByName('password_repeat')[0];
    
    const checkNormalChar = event => {
        return (event.charCode >= 65 && event.charCode <= 90) 
            || (event.charCode >= 97 && event.charCode <= 122) 
            || (event.charCode >= 48 && event.charCode <= 57);
    };
    
    userLoginBox.addEventListener('keypress', function(event){
        if (!checkNormalChar(event))
            event.preventDefault();
    });
    
    userPasswordBox.addEventListener('keypress', function(event){
        if (!checkNormalChar(event))
            event.preventDefault();
    });
    
    userPasswordBoxRepeat.addEventListener('keypress', function(event){
        if (!checkNormalChar(event))
            event.preventDefault();
    });
    
    
    authorizationButton.addEventListener("click", async function(){
        if(!userLoginBox.value || !userPasswordBox.value || !userPasswordBoxRepeat.value){
            if(!userLoginBox.value){
                var loginMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("loginMiss")[0];
                clone(loginMiss_alert, document.getElementsByClassName("block_alert")[0]);
                return;
            }
            
            if(!userPasswordBox.value || !userPasswordBoxRepeat.value) {
                var passwordMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("passwordMiss")[0];
                clone(passwordMiss_alert, document.getElementsByClassName("block_alert")[0]);
                return;
            }
        } else {
            if(userPasswordBox.value != userPasswordBoxRepeat.value){
                var differentPasswords = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("differentPasswords")[0];
                clone(differentPasswords, document.getElementsByClassName("block_alert")[0]);
                return;
            }
            if(userLoginBox.value.length < 8 || userPasswordBox.value.length < 8){
                var loginMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("shortUserDatas")[0];
                clone(loginMiss_alert, document.getElementsByClassName("block_alert")[0]);
                return;
            }
            
            let parameters = {
              loginValue: userLoginBox.value,
              passwordValue: userPasswordBox.value,
              passwordValueRepeat: userPasswordBoxRepeat.value,
            };
            let response = await fetch( url + 'authorization//registrationTry', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(parameters)
                });
            if (response.ok) {
                let json = await response.json();
                var answer = json['answer'];
                if (answer != null){
                    let parameters = {
                      loginValue: answer,
                      passwordValue: userPasswordBox.value,
                    };
                    let response = await fetch( url + 'authorization//loginTry', {
                            method: 'POST',
                            headers: {
                            'Content-Type': 'application/json;charset=utf-8'
                            },
                            body: JSON.stringify(parameters)
                        });
                    let json = await response.json();
                    top.location.replace(url + 'profile');
                } else {
                    var error = json['error'];
                    var alert = undefined;
                    switch(error){
                        // code of primary key db
                        case '23000':
                            alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("existLogin")[0];
                            break;
                    }
                    if(alert !== undefined)
                        clone(alert, document.getElementsByClassName("block_alert")[0]);
                }
            } else {
                console.log("Ошибка HTTP: " + response.status);
            }
        }
    });
    
    function ExecuteEnter(event){
        // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        authorizationButton.click();
      }
    }
    
    userLoginBox.addEventListener("keyup", ExecuteEnter);
    userPasswordBox.addEventListener("keyup", ExecuteEnter);
    userPasswordBoxRepeat.addEventListener("keyup", ExecuteEnter);
});
