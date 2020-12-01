"use strict"
window.addEventListener("load", function(){
	function resizeHandler(){
		var result = (window.innerHeight - (header.offsetHeight + footer.offsetHeight)) + "px";
		main.style.minHeight = result;
	}
	var main = document.getElementsByTagName('main')[0];
	var header = document.getElementsByTagName('header')[0];
	var footer = document.getElementsByTagName('footer')[0];
	window.addEventListener("resize", function() {
	    resizeHandler();
	});
	resizeHandler();
});