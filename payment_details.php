<?php include('include/connect.php');
 include('include/session.php'); 
 include('formatMoney.php');
include('function.php');
      $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
      $limit = 8;
      $startpoint = ($page * $limit) - $limit;
        
        //to make pagination
        $statement = "`tb_properties`";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/aalogo.jpg">

    <title>JERSEY DEVELOPERS LTD.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<!-- Less styles  
	<link rel="stylesheet/less" type="text/css" href="less/bootsshop.less">
	<script src="less.js" type="text/javascript"></script>
	 -->
	 
    <!-- Le styles  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet"/>
	<link href="assets/css/docs.css" rel="stylesheet"/>
	 
    <link href="assets/style.css" rel="stylesheet"/>
	<link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet"/>

	
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
 <style>
   body {
    background-image: url("background1.JPG");
    background-repeat: no-repeat;
}
</style>
    <!-- Le fav and touch icons -->
 </head>
<body>
  <!-- Navbar
    ================================================== -->
<div class="navbar navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container">
					
                  <a data-target="#sidebar" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <div class="nav-collapse">
                    <ul class="nav">
					 <li class=""><a href="user_index.php"><i class="icon-home icon-large"></i> Home</a></li>
					  <li class=""><a href="user_properties.php"><i class=" icon-th-large icon-large"></i> Properties</a></li>
					  <li class=""><a href="user_contact.php"><i class="icon-signal"></i> Contact Us</a></li>
                      <li class=""><a href="user_aboutus.php"><i class="icon-flag"></i> About Us</a></li>
					  <li class=""><a href="user_purchase.php"><i class="icon-shopping-cart"></i> Paid/Pending</a></li>
               <li class=""><a href="Email.php"><i class="icon-envelope"></i> Email</a></li>
					</ul>
                   
                    <ul class="nav pull-right">
					<li>
						<a href="user_account2.php"><?php $query = mysql_query("select * from customers where CustomerID='$ses_id'") or die(mysql_error());
                $row = mysql_fetch_array($query);
                $id = $row['CustomerID']; ?> <b>Welcome!  </b> <?php echo $row['Firstname'];?> <?php echo $row['Lastname'];?> <span class="badge badge-info"> <?Php include('announce.php');?></span></a>
					</li>
					<li>
						<a href="logout.php"><i class="icon-cog"></i> Log Out</a>
					</li>
					</ul>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
<!-- ======================================================================================================================== -->	
<div id="mainBody" class="container">
<div class="thumbnail">
<?php include ('user_header.php'); ?></div>
<!-- ==================================================Header End====================================================================== -->
<br />
<div class="well">
				
      <center>
	
    <?php
    $ses_id = $_SESSION['id'];

	
						$id = mysql_query("select MAX(notifID) as max_notifID from notif");										
						$row = mysql_fetch_array($id);
						$orders=$row['max_notifID'] + 1; 

									$id = mysql_query("select MAX(PaymentID) as max_PaymentID from payment");										
						$row = mysql_fetch_array($id);
						$notifID=$row['max_PaymentID'] + 1; 
                        
                        
                
                        
$query=mysql_query("select * from payment_details where CustomerID='$ses_id' and PaymentID=''") or die (mysql_error());
while($row3=mysql_fetch_array($query)){
$count=mysql_num_rows($query);
$pid=$row3['PropertyID'];
$qty= $row3['Unit'];

$query2=mysql_query("select * from tb_properties where propertyID='$pid'") or die (mysql_error());
$row2=mysql_fetch_array($query2);
$unit=$row2['unit'];


 mysql_query ("UPDATE tb_properties SET unit = unit - $qty 
            WHERE propertyID ='$pid' and unit='$unit' ");
            
 

//date_default_timezone_set('US/Canada'); // CDT
  //date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d');

			
		
			
				$cart_table = mysql_query("select  sum(total) from payment_details where CustomerID='$ses_id' and PaymentID=''") or die(mysql_error());
       $cart_count = mysql_num_rows($cart_table);
       
        while ($cart_row = mysql_fetch_array($cart_table)) {
            
            

		   $total = $cart_row['sum(total)'];
		   
           
		 
mysql_query("INSERT INTO payment (customerID, PaymentID, paymentdate,total,status) 
	VALUES('$ses_id','$orders', '$current_date','$total','Pending')");

mysql_query("INSERT INTO notif (notifID, paymentID,date_paid) 
	VALUES('$notifID','$orders','$current_date')");	

mysql_query("update payment_details set PaymentID='$orders' where customerID='$ses_id' and PaymentID=''")or die(mysql_error());
mysql_query ("UPDATE payment_details SET Total_unit =$unit - $qty WHERE ProductID ='$pid' and Total_unit='' ");
}
}
?>
            
        
        
        <?php
                        
$total1=$_POST['totas'];
$tax=$total1 * 0.12;
$transaction_code= "JD00".$orders.$ses_id;
mysql_query("update payment set Transaction_code='$transaction_code' where customerID='$ses_id' and Transaction_code=''")or die(mysql_error());
mysql_query("update payment set tax='$tax' where customerID='$ses_id' and tax='0'");
$code=mysql_query("select * from payment where customerID='$ses_id' and total='$total1' and paymentdate='$current_date' and Date_paid=''");
$row4=mysql_fetch_array($code);
/*
$shipaddress=$_POST['shipaddress'];
$city=$_POST['city'];
$ADDRESS=$shipaddress .' '. $city;               
mysql_query("update orders set shipping_address='$ADDRESS' where customerID='$ses_id' and Transaction_code='$transaction_code'"); */  					  
  
?>


<form action="https://www.sandbox.paypal.com/cgi-bin/webscr"  method="post">
<input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="sabellorichmon-facilitator@yahoo.com" />
        <input type="hidden" name="item_name" value="<?php echo $row4['Transaction_code']; ?>" />
        <input type="hidden" name="item_number" value="<?php echo $count; ?>"/>
        <input type="hidden" name="amount" value="<?php echo $total1; ?>" />
        <input type="hidden" name="quantity" value="1" />
        <input type="hidden" name="currency_code" value="KSH" />
        <input type="hidden" name="lc" value="GB" />
        <input type="hidden" name="bn" value="PP-BuyNowBF" /><br />
       <input type="hidden" name="shipping" value="150.00">
        <input type="hidden" name="shipping2" value="">
        <input type="hidden" name="tax" value="">
        <input type="hidden" name="handling_cart" value="">
        
        <div class="container">

          
        <input type="image" src="paypal.jpg" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"  />
        
      
    </div>
        <!-- Payment confirmed -->
        <input type="hidden" name="return" value="" />
        <!-- Payment cancelled -->
        <input type="hidden" name="cancel_return" value="" />
        <input type="hidden" name="rm" value="2" />
        <input type="hidden" name="notify_url" value="" />
        <input type="hidden" name="custom" value="any other custom field you want to pass" />
    </form>
        
        
        
        
        
		<img  class="pull-left" src="paypalverified.jpg" /> 
        <h3>Payment through Paypal</h3>
        <h3>Jersey Developers Ltd.</br></h3>
        <h3>Thanks!</h3>
     
     <a href="user_properties.php"><button type="button"  class="btn btn-success"><span class="icon-off"></span> Back</button></a> 
      </center>
</div>
<?php
	
    
?>

<!-- Footer ------------------------------------------------------ -->
<hr class="soft">
<div  id="footerSection" class="thumbnail">
	<?php include('footer2.php');?>
</div></div></body>