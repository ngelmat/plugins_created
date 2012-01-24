jQuery(document).ready(function() {
  var id;
  jQuery('.uploadBtn').click(function() { 
    id = jQuery(this).attr('id');
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
  });

  window.send_to_editor = function(html) {
    imgurl = jQuery('img',html).attr('src'); 
    jQuery('#uploaded_image-' + id).val(imgurl);    
    tb_remove();
  }
  
  jQuery('.savesend input[class="button"]').attr('value', 'Attach to Tag icon');
  
});
