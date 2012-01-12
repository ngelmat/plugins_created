<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Responsive Image Gallery</title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> 
        <meta name="description" content="Responsive Image Gallery with jQuery" />
        <meta name="keywords" content="jquery, carousel, image gallery, slider, responsive, flexible, fluid, resize, css3" />
		<meta name="author" content="Codrops" />		
		<link rel="stylesheet" type="text/css" href="css/elastislide.css" />	
    
    <!-- start fancybox-->    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript">
		$(document).ready(function() {      
      $("a#fbox").fancybox();
      $("a[rel=fbox]").fancybox({
        'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'        
      });
    });
  </script>
  <!-- end fancybox-->
		</script>
    </head>
    <body>      
				<div id="rg-gallery" class="rg-gallery">					
						<!-- Elastislide Carousel Thumbnail Viewer -->           
						<div class="es-carousel-wrapper">
							<div class="es-nav">
								<span class="es-nav-prev">Previous</span>
								<span class="es-nav-next">Next</span>
							</div>              
							<div class="es-carousel">
								<ul>
                  <li><a rel="fbox" href="images/1.jpg" title="From off a hill whose concave womb reworded"><img src="images/thumbs/1.jpg" data-large="images/1.jpg" alt="From off a hill whose concave womb reworded" data-description="From off a hill whose concave womb reworded" /></a></li>
									<li><a rel="fbox" href="images/2.jpg" title="A plaintful story from a sistering vale" ><img src="images/thumbs/2.jpg" data-large="images/2.jpg" alt="image02" /></a></li>
									<li><a rel="fbox" href="images/3.jpg"><img src="images/thumbs/3.jpg" data-large="images/3.jpg" alt="image03" data-description="A plaintful story from a sistering vale" /></a></li>
									<li><a rel="fbox" href="images/4.jpg"><img src="images/thumbs/4.jpg" data-large="images/4.jpg" alt="image04" data-description="My spirits to attend this double voice accorded" /></a></li>
									<li><a rel="fbox" href="images/5.jpg"><img src="images/thumbs/5.jpg" data-large="images/5.jpg" alt="image05" data-description="And down I laid to list the sad-tuned tale" /></a></li>
									<li><a rel="fbox" href="images/6.jpg"><img src="images/thumbs/6.jpg" data-large="images/6.jpg" alt="image06" data-description="Ere long espied a fickle maid full pale" /></a></li>
									<li><a rel="fbox" href="images/7.jpg"><img src="images/thumbs/7.jpg" data-large="images/7.jpg" alt="image07" data-description="Tearing of papers, breaking rings a-twain" /></a></li>
									<li><a rel="fbox" href="images/8.jpg"><img src="images/thumbs/8.jpg" data-large="images/8.jpg" alt="image08" data-description="Storming her world with sorrow's wind and rain" /></a></li>
									<li><a rel="fbox" href="images/9.jpg"><img src="images/thumbs/9.jpg" data-large="images/9.jpg" alt="image09" data-description="Upon her head a platted hive of straw" /></a></li>
									<li><a rel="fbox" href="images/10.jpg"><img src="images/thumbs/10.jpg" data-large="images/10.jpg" alt="image10" data-description="Which fortified her visage from the sun" /></a></li>
									<li><a rel="fbox" href="images/11.jpg"><img src="images/thumbs/11.jpg" data-large="images/11.jpg" alt="image11" data-description="Whereon the thought might think sometime it saw" /></a></li>
									<li><a rel="fbox" href="images/12.jpg"><img src="images/thumbs/12.jpg" data-large="images/12.jpg" alt="image12" data-description="The carcass of beauty spent and done" /></a></li>
									<li><a rel="fbox" href="images/13.jpg"><img src="images/thumbs/13.jpg" data-large="images/13.jpg" alt="image13" data-description="Time had not scythed all that youth begun" /></a></li>
									<li><a rel="fbox" href="images/14.jpg"><img src="images/thumbs/14.jpg" data-large="images/14.jpg" alt="image14" data-description="Nor youth all quit; but, spite of heaven's fell rage" /></a></li>
									<li><a rel="fbox" href="images/15.jpg"><img src="images/thumbs/15.jpg" data-large="images/15.jpg" alt="image15" data-description="Some beauty peep'd through lattice of sear'd age" /></a></li>
									<li><a rel="fbox" href="images/16.jpg"><img src="images/thumbs/16.jpg" data-large="images/16.jpg" alt="image16" data-description="Oft did she heave her napkin to her eyne" /></a></li>
									<li><a rel="fbox" href="images/17.jpg"><img src="images/thumbs/17.jpg" data-large="images/17.jpg" alt="image17" data-description="Which on it had conceited characters" /></a></li>
									<li><a rel="fbox" href="images/19.jpg"><img src="images/thumbs/18.jpg" data-large="images/18.jpg" alt="image18" data-description="Laundering the silken figures in the brine" /></a></li>
									<li><a rel="fbox" href="images/20.jpg"><img src="images/thumbs/19.jpg" data-large="images/19.jpg" alt="image191" data-description="That season'd woe had pelleted in tears" /></a></li>
									<li><a rel="fbox" href="images/21.jpg"><img src="images/thumbs/20.jpg" data-large="images/20.jpg" alt="image20" data-description="And often reading what contents it bears" /></a></li>
									<li><a rel="fbox" href="images/22.jpg"><img src="images/thumbs/21.jpg" data-large="images/21.jpg" alt="image21" data-description="As often shrieking undistinguish'd woe" /></a></li>
									<li><a rel="fbox" href="images/23.jpg"><img src="images/thumbs/22.jpg" data-large="images/22.jpg" alt="image22" data-description="In clamours of all size, both high and low" /></a></li>
									<li><a rel="fbox" href="images/24.jpg"><img src="images/thumbs/23.jpg" data-large="images/23.jpg" alt="image23" data-description="Sometimes her levell'd eyes their carriage ride" /></a></li>									
								</ul>
							</div>
						</div>
          
       </div>     
		<script type="text/javascript" src="js/jquery.tmpl.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="js/jquery.elastislide.js"></script>
		<script type="text/javascript" src="js/gallery.js"></script>
   
    </body>
</html>