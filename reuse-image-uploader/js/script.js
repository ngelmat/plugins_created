jQuery(document).ready(function() {
  jQuery('#uploadBtn').click(function() {    
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
  });

  window.send_to_editor = function(html) {
    imgurl = jQuery('img',html).attr('src'); 
    jQuery('#uploaded_image').val(imgurl);
    jQuery('#post_img').attr('src', imgurl);
    jQuery('#post_img').css('padding', '2px');
    tb_remove();
  }
});
