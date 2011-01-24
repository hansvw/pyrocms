<div id="header">
  <?php 
  	foreach ($dayevents as $dayevent){
  		echo "<div class=\"dayevents\">";
  		echo "<h3>Event date: </h3>";
  		echo $dayevent['eventDate'];
  		echo "<br />\n";
  		echo "<h3>Event Title: </h3>";
  		echo $dayevent['eventTitle'];
  		echo "<br />\n";
  		echo "<h3>Event Content: </h3>";
  		echo $dayevent['eventContent'];
  		echo "</div>";
  	}
  ?>	
 </div>
  
 
