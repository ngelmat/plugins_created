<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xhtml="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
      <script type="text/javascript" src="cvi_tip_lib.js"></script>      
	<script type="text/javascript" src="maputil.js"></script>
	<script type="text/javascript" src="mapper.js"></script>
  <link rel="stylesheet" type="text/css" href="tooltip.css" />
      <title></title>
  </head>
  <body>  
    <div style="width:300; height:350; 
         background-color: white;" class="demo">
      <div style="width: 300px; height: 350px; margin: 35px; 
           position: relative; padding: 0px; -moz-user-select: none;">
        <img src="drawing.png" id="gmipam_1_image" 
             style="position: absolute; height: 350px; width: 300px; left: 0px; top: 0px;"/>
        <canvas id="gmipam_1_canvas" style="height: 350px; width: 300px; position: absolute; left: 0px; top: 0px; opacity: 1;" height="350" width="300">

        </canvas>
        <div id="map_of_usa_blind" class="blind_area" style="position: absolute; height: 350px; width: 300px; left: 0px; top: 0px;"> 
        </div><img height="350" border="0" width="300" alt="" usemap="#map_of_usa2" 
                   src="drawing.png" class="" id="gmipam_1" style="position: absolute; 
                   height: 275px; width: 432px; left: 0px; top: 0px; -moz-user-select: none; opacity: 0;">
      </div>
    </div>

    <map name="map_use_drawing">

    </map>    


    <map name="map_of_usa2">            
                                                                            
        
     <area coords="222,195,196,206,168,233,169,238,159,239,164,273,151,294,119,305,107,322,109,335,100,348,273,349,267,345,260,332,261,318,262,317,264,314,264,308,261,302,253,297,253,293,248,287,242,283,234,275,234,263,233,257,228,247,225,243,221,238,219,234,219,230,220,222,221,216,223,211,224,207,224,205,225,201,221,201,217,200,217,199"  
            
            href="http://google.com" id="TX" 
            shape="poly"
            tooltip="Antarctica" onmouseover="setAreaOver(this,'gmipam_1_canvas','255, 251, 206','74, 74, 74','0.8', 0,1,0); cvi_tip._show(event);" 
            onmouseout="setAreaOut(this,'gmipam_1_canvas'); cvi_tip._hide(event);" onmousemove="cvi_tip._move(event);">  
       
       
     <area coords="37,139,40,145,41,162,38,165,36,173,34,174,34,194,31,199,32,209,33,211,33,217,36,220,35,230,38,235,37,238,37,240,37,267,40,270,44,270,45,274,50,278,51,281,51,285,50,293,55,301,57,307,57,308,50,307,46,307,45,311,43,312,42,316,41,321,40,325,39,328,37,330,31,336,30,336,27,337,21,344,19,347,19,349,35,350,37,357,44,359,48,365,51,367,99,347,110,336,107,323,118,305,149,293,164,272,159,239,169,237,166,230,165,227,157,233,153,233,149,240,132,241,132,180,135,178,135,174,132,175,123,170,119,151,117,146,115,140,115,139"              
            href="#" alt="Texas2" title="Texas2" id="TX2" 
            shape="poly" 
            onmouseover="setAreaOver(this,'gmipam_1_canvas','255, 251, 206','74, 74, 74','0.8', 0,1,0);" 
            onmouseout="setAreaOut(this,'gmipam_1_canvas');">    
       
       
    </map>

  </body>
</html>
