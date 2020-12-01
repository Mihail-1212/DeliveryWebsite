"use strict"
window.addEventListener("load", function(){
	document.addEventListener('click',function(e){
	    if(e.target && e.target.classList.contains("closebtn")){
			var div = e.target.closest('div');
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
	     }
	 });

	/*
	// Copy the <li> element and its child nodes
	var cln = document.getElementsByClassName("error")[0].cloneNode(true);
	// Append the cloned <li> element to <ul> with id="myList1"
	document.getElementsByClassName("block_alert")[0].appendChild(cln);
	*/
});