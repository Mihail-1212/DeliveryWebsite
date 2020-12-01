"use strict"

class MenuDropDown {

	constructor(dropdownButton, drropdownMenu) {
		this.dropdownButton = dropdownButton;
		this.drropdownMenu = drropdownMenu;
		if (NodeList.prototype.isPrototypeOf(this.drropdownMenu)){
			this.drropdownMenu = this.drropdownMenu[0];
		}
		var menu = this.drropdownMenu;
		var cb = function () {
		      menu.classList.remove("show");
		      menu.classList.remove("hiding");
		      menu.removeEventListener("transitionend", cb, false);
		    };
		this.dropdownButton.addEventListener("click", function(evt) {
		  evt.preventDefault();
		  if (menu.classList.contains("show") && !menu.classList.contains("hiding")) {
		    menu.classList.add("hiding");
		    menu.addEventListener("transitionend", cb, false);
		  } else {
		    menu.classList.add("show");
		    menu.classList.remove("hiding");
		  }
		});

		document.addEventListener("click", function(evt){
			evt = evt || window.event;
		    var target = evt.target || evt.srcElement, text = target.textContent || target.innerText;  
		    var target_parent = target.closest(".menu_container");
		    var menu_parent = menu.closest(".menu_container");
			if(!menu_parent.isEqualNode(target_parent)) {
				menu.classList.add("hiding");
				menu.removeEventListener("transitionend", cb, false);
			}
		});

	}

}


window.addEventListener("load", function(){
	var dropdown_buttons = document.getElementsByClassName('dropdown_button');
	for(var i = 0; i < dropdown_buttons.length; i++){
		var dropdown_button = dropdown_buttons[i];
		var menu_for_button = document.querySelectorAll("[data-for='"+dropdown_button.id+"']");
		if(menu_for_button !== undefined){
			var dropDownProdfile = new MenuDropDown(dropdown_button, menu_for_button);
		}
	}
	// var scroll_button = document.getElementsByClassName('button_to_top')[0];
 //    scroll_button.onclick = function(){
 // 		topFunction();
 // 	};



 //    window.onscroll = function() {scrollFunction()};
	// function scrollFunction() {
	// 	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
	// 		scroll_button.style.display = "inline-flex";
	// 	} else {
	// 		scroll_button.style.display = "none";
	// 	}
	// }

	// // When the user clicks on the button, scroll to the top of the document
	// function topFunction() {
	// 	if (window.pageYOffset > 0) {
	// 		window.scrollBy(0, -30);
	// 		setTimeout(topFunction, 0);
	// 	}
	// }
	/*
		

	*/


});