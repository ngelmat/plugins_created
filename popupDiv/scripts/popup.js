//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;


//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupTesti").fadeIn("slow");
		
		/*
		var height = $("#popupTesti").css('height');
		height = height.substr(0,height.length - 2);
		alert(height);
		*/
		
			
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupTesti").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupTesti").height();
	var popupWidth = $("#popupTesti").width();
	
	
    $('#popupTesti').css("position","absolute");
    $('#popupTesti').css("top", (($(window).height() - popupHeight) / 2) + $(window).scrollTop() + "px");
    $('#popupTesti').css("left", (($(window).width() - popupWidth) / 2) + $(window).scrollLeft() + "px");


	//centering
	/*
	$("#popupTesti").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	*/		
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}


//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	initPop();
	//LOADING POPUP
	//Click the button event!
	$("#openPop").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
				
	//CLOSING POPUP
	//Click the x event!
	$("#popupTestiClose").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});


function initPop() {    
    /**
     * options:
     * dr_hugo_testi
     * anti_aging_ingredients
     * 
     */

    $('.openPopup').click(function () {        
        var name = $(this).attr('name');
        var data = {'option' : name, 'action' : 'popupDiv'};        
        $.ajax(
        {
            url : url,
            type: 'post',
            data: data,
            success: function (response) {                
                //centering with css
                $('#content_popup').html(response);
		centerPopup();
		//load popup
		loadPopup();
            } 
        });
        
    });


}