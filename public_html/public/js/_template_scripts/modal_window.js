class Modal_Window {

	constructor(modal_button, modal_window, iframe_src = null) {
		this.modal_button = modal_button;
		this.modal_window = modal_window;
		this.iframe_src = iframe_src;
		var body = document.getElementsByTagName('body')[0];
        if (this.modal_button != null) {
            this.modal_button.addEventListener("click", function(e){
                if(iframe_src != null){
                    modal_window.getElementsByTagName('iframe')[0].src = iframe_src;
                }
    		    
    			body.style.overflow = 'hidden';
    			modal_window.style.display = "block";
    		});
    	  	var close_button = this.modal_window.getElementsByClassName('close')[0];
            // static_close
    
    	  	close_button.onclick = function(e){
    	  		body.removeAttribute("style");
    	  		modal_window.style.display = "none";
    	  	}

            var static_close_button = this.modal_window.getElementsByClassName('static_close');
            for(let i = 0; i < static_close_button.length; i++){
                var currCloseButton = static_close_button[i];
                currCloseButton.addEventListener("click", function(e){
                    body.removeAttribute("style");
                    modal_window.style.display = "none";
                });
            }
        }
	}

}