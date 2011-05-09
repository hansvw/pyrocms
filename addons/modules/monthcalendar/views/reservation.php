<div id="header">
  <?php 
  	foreach ($dayreservations as $reservation)
    {
  		echo "<div class=\"dayevents\">";
        echo $reservation['status'];
  		echo "</div>";
  	}
  ?>
</div>