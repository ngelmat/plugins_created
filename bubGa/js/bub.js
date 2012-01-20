/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){  
  $('.bub img').hover(function(){
      var position;
      var id;
      id = this.id;
      position = $("#" + id).position();      
      popLeft = position.left;
      $("#popDiv").css('left', popLeft + 20);      
      $("#popDiv").html($("#" + id).attr('alt'));      
      $("#popDiv").fadeIn();
  }, function() {
    $("#popDiv").fadeOut();            
  });
  $("#popDiv").css('display', 'none');
  
});


