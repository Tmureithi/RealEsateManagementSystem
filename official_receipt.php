<?php include('include/connect.php');

function formatMoney($number, $fractional=false) {
                if ($fractional) {
                  $number = sprintf('%.2f', $number);
                }
                while (true) {
                  $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
                  if ($replaced != $number) {
                    $number = $replaced;
                  } else {
                    break;
                  }
                }
                return $number;
              }  

?>
<!DOCTYPE html>
<html lang="en">


    <title>JERSEY DEVELOPERS LTD.</title>
	
	<head>
   <link rel="shortcut icon" href="img/aalogo.jpg">
		
		<link href="receipt.css" media="all" rel="stylesheet" type="text/css" />


<script>
function myFunction()
{
        var printButton = document.getElementById("printpagebutton");
        var back = document.getElementById("back");
        printButton.style.visibility = 'hidden';
        back.style.visibility = 'hidden';
        printButton.style.visibility = 'hidden';
        window.print()
}

</script>
	</head>


	<body >
		<a id="back" href="user_order.php">Back</a>
        <div id="print">
<a href="" id="printpagebutton" onclick="myFunction()"><B>Print</B></a>
		
		<h3 class="one"><img src="img/images.png"  /><h3 class="one"><br/>JERSEY DEVELOPERS LTD. OFFICIAL BILL OF SALE<br/><font color="blue"><U>PAID</U></font></h3>
		
		<div class="printtitle">
			<hr>
<b> The company is located at 1 Ololoua lane <Br>
, Ngong Town, Kajiado County, Kenya</b><hr></div>
		
		<table>
			<?php
			$id=$_GET['id'];
			$query=mysql_query("select * from payment where PaymentID='$id'") or die(mysql_error());
			while($row=mysql_fetch_array($query)){
				$CID=$row['customerID'];
                $tax=$row['tax'];
			$query2=mysql_query("select * from customers where CustomerID='$CID'") or die(mysql_error());
			$row2=mysql_fetch_array($query2);
			?>
				<font color="black"><U>

	<b>PRINTED ON: <?php echo date("m/d/Y");?></b></U>
			<tr><td>Transaction No.: <u><?php echo $row['Transaction_code'];?></u>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td>Date: <u><?php echo date("F j, Y", strtotime( $row['paymentdate']));?></u></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td>Client Name: <u><?php echo $row2['Firstname'].' '.$row2['Lastname'];?></u></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
	
            <tr><td></td></tr>
			<?php } ?>
		</table>
		
		<br/><br/>	
		<table border="" color="black">
			<thead>
				<th>Description</th>
				<th>Price</th>
				<th>Unit/Plot</th>
				<th>Total</th>
			</thead>
			<tbody>
			<tr>
				<?php
				$id=$_GET['id'];
			$query3=mysql_query("select * from payment_details where PaymentID='$id'") or die(mysql_error());
			while($row3=mysql_fetch_array($query3)){
				$pid=$row3['PropertyID'];
			$query4=mysql_query("select * from tb_properties where propertyID='$pid'") or die(mysql_error());
			$row4=mysql_fetch_array($query4);

				echo '<tr><td><div align="center">'.$row4['name'].'</div></td>';
				echo '<td><div align="center">KES '.formatMoney($row4['price'],2).'</div></td>';
				echo '<td><div align="center">'.$row3['Unit'].'</div></td>';
				echo '<td><div align="center">KES '.formatMoney($row3['Total'],2).'</div></td></tr>';

				} ?>
			</tr>
            <tr>
            <td><div align="center"><strong>Payment Method</strong></div></td>
            <td><div align="center" ><strong>Document Propcessing Fee</strong></div></td>
          
            </tr>
            <tr>
           <td align='center'>CASH SALE</td>
            <td >KES 150.00</td>
            <!--<td ><?php echo 'KES '.formatMoney($tax,2); ?></td>-->
            </tr>
            <tr>
            <td colspan="3" style="text-align:right;"><b>TOTAL AMOUNT:</b></td>
				<td style="text-align:center;"> <?php
				$id=$_GET['id'];
          $result5 = mysql_query("SELECT sum(total) FROM payment_details WHERE PaymentID='$id'");
          while($row5 = mysql_fetch_array($result5))
            { 
             $total=150+$row5['sum(total)'];   
            echo 'KES '.formatMoney($total,2);
            }
          ?></td>
            </tr>

		</tbody>
		</table>
		<br>
		<br>
		<br/><br/>	
		</div>	

	</body>
</html>
