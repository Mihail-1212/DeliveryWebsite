
window.addEventListener("load", function(){
	var registration_button = document.getElementById('registration_button');
	var authorization_button = document.getElementById('authorization_button');

	var modal_window = document.getElementById('modal_window');

	var registration = new Modal_Window(registration_button, modal_window, link_registration);
	var authorization = new Modal_Window(authorization_button, modal_window, link_login);

});