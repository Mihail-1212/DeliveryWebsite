"use strict"
window.addEventListener("load", function(){
	var scroll_button = document.getElementsByClassName('button_to_top')[0];
    scroll_button.onclick = function(){
 		topFunction();
 	};

    window.onscroll = function() {scrollFunction()};
	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			scroll_button.style.display = "inline-flex";
		} else {
			scroll_button.style.display = "none";
		}
	}
});

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
	if (window.pageYOffset > 0) {
		window.scrollBy(0, -30);
		setTimeout(topFunction, 0);
	}
}
