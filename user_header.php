<header id="header">
<div class="row">
<div class="span11">
	<a href="user_index.php"><img src="img/muju.jpg" alt=""/></a>
<div class="pull-right"> <br/>
	<a title="Click to view your properties!" href="property_summary.php"> <span class="btn btn-mini btn-warning"> 
		 [<?php



   $count_query = mysql_query("select * from payment_details where CustomerID='$ses_id' and PaymentID=''") or die(mysql_error());
     $count = mysql_num_rows($count_query);
                    echo $count;
                    ?>] </span> </a>
	<a title="Click to view your properties!" href="property_summary.php">
		<span class="btn btn-mini active">KES<?php
	
				  $result5 = mysql_query("SELECT sum(total) FROM payment_details WHERE CustomerID='$ses_id' and PaymentID=''");
					while($row5 = mysql_fetch_array($result5))
					  { 

						echo formatMoney($row5['sum(total)'],2);
					  }
				  ?></span></a>
</div>
</div>
</div>
<div class="clr"></div>
</header>