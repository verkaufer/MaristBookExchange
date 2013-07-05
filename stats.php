<?php 
    require_once("phpStart.php");
	require_once("header.php");

	$totalTrades = $trades->getNumAllTrades();
	$closedTrades = $trades->getNumClosedTrades();


?>



    <div class="row">
        <div class="twelve columns directions">
            <h3 class="directions">Statistics</h3>

			Total Number of Trades <li class="secondary badge"><?php echo $totalTrades; ?></li><br>
			Number of Closed Trades <li class="danger badge"><?php echo $closedTrades; ?></li>

        </div>
    </div>

	<div class="row">

	</div>



<?php
	require_once("footer.php");
?>