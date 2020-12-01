"use strict"
window.addEventListener("load", function(){
    var loginButton = document.getElementById('loginButton');
    var userLoginBox = document.getElementsByName('login')[0];
    var userPasswordBox = document.getElementsByName('password')[0];
    
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
    
    loginButton.addEventListener("click", async function(){
        if(!userLoginBox.value || !userPasswordBox.value){
            if(!userLoginBox.value){
                var loginMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("loginMiss")[0];
                clone(loginMiss_alert, document.getElementsByClassName("block_alert")[0]);
            }
            
            if(!userPasswordBox.value) {
                var passwordMiss_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("passwordMiss")[0];
                clone(passwordMiss_alert, document.getElementsByClassName("block_alert")[0]);
            }
        } else {
            let parameters = {
              loginValue: userLoginBox.value,
              passwordValue: userPasswordBox.value,
            };
            let response = await fetch( url + 'authorization//loginTry', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(parameters)
                });
            if (response.ok) {
                let json = await response.json();
                var userToken = json['userToken'];
                if(userToken != null){
                    top.location.reload();
                } else {
                    var uncorrectUserData_alert = document.getElementsByClassName("block_hidden_alert")[0].getElementsByClassName("uncorrectUserData")[0];
                    clone(uncorrectUserData_alert, document.getElementsByClassName("block_alert")[0]);
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
        loginButton.click();
      }
    }
    
    userLoginBox.addEventListener("keyup", ExecuteEnter);
    userPasswordBox.addEventListener("keyup", ExecuteEnter);
});
