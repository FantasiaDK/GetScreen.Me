(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).ready(function($) {       //wrapper
	    $("#getscreen_me").submit(function(event) {         //event
	    	event.preventDefault();
	    	//alert('Create session pressed');
	        var this2 = this;                  //use in callback
	        $(this2).hide(); // hide the form
	        $.post(getscreen_me_obj.ajax_url, {     //POST request
	           //_ajax_nonce: getscreen_me_obj.nonce, //nonce
	            security: getscreen_me_obj.security, //nonce
	            action: "getscreen_me_create_session",        //action
	            getscreenme_clientname: this.getscreenme_clientname.value              //data
	        }, function(data) {                //callback
	        	//$(this2).after(data);          //insert server response
	        	console.log(data); 
	        	var text = data;
	        	if(getscreen_me_obj.gsoverride)
	        		text = getscreen_me_obj.gslabel;
	        	$(this2).after('<p><a href="' + data + '" id="greenscreenlink" target="_blank">' + text + '</a></p>');
	        	if(getscreen_me_obj.gsoverlay){
		        document.getElementById("greenscreenlink").onclick = function(e) {
				  e.preventDefault();
				  document.getElementById("greenscreenpopupdarkbg").style.display = "block";
				  document.getElementById("greenscreenpopup").style.display = "block";
				  document.getElementById('greenscreenpopupiframe').src = data;
				  return false;
				}}    
	        });
	    });
	    document.getElementById('greenscreenpopupdarkbg').onclick = function() {
		  document.getElementById("greenscreenpopup").style.display = "none";
		  document.getElementById("greenscreenpopupdarkbg").style.display = "none";
		};		            
	});
})( jQuery );
