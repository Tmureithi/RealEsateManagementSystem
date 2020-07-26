<?php include('include/connect.php');
include('include/session.php');
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

    <script type='text/javascript'>
function numbers(){

  //var CheckPassword = /^[A-Za-z]\w{7,14}$/; - numbers and characters and uppercase
  var letterexp = /^[a-zA-Z]+$/;
  var quanti = 32; 
  if(document.getElementById('quantity').value.match(letterexp)){
    alert('Please input numbers only');
    document.getElementById('quantity').value='';
  }
  
}


</script>

     <script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to update product status?")) {
   document.location = 'update_stat.php';
  }
}
</script>

    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
  <script src="js/incrementing.js"></script>
  
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
          <a id="logoM" href="user_index.php"><img src="" alt=""/></a>
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
            <a href="logout.php"><i class="icon-off"></i> Log Out</a>
          </li>
          </ul>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
<!-- ======================================================================================================================== --> 
<div id="mainBody" class="container"><div class="thumbnail">
<?php include ('user_header.php'); ?>
</div><font color="white">
<!-- ==================================================Header End====================================================================== -->
<?php 
$query3=mysql_query("select * from payment_details where CustomerID='$ses_id' and   PaymentID=''") or die (mysql_error());
$count2=mysql_num_rows($query3);
?>


<form method="post" action="payment_details.php">


    
  <input type="hidden" id="username" name="id" value="<?php
             $id = mysql_query("select MAX(PaymentID) as max_PaymentID from payment");                                       
           $row5 = mysql_fetch_array($id);
             echo $row5['max_PaymentID'] + 1;                                       
    ?>" class="input-xlarge" required />




  <h3>  PURCHASE SUMMARY [ <small><?php echo $count2;?> </small>]

  </h3>  
  <hr class="soft"/>
  
  <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Property</th>
                  <th>Description</th>
                  <th  width="100">Unit(s)</th>
                  <th  width="80">Price</th>
                  <th width="80">Total</th>
                  <th width="100">Action</th>
        </tr>
              </thead>
              <tbody>
                <?php 
$query=mysql_query("select * from payment_details where CustomerID='$ses_id' and  PaymentID=''") or die (mysql_error());
while($row=mysql_fetch_array($query)){
$count=mysql_num_rows($query);
$pid=$row['PropertyID'];

$query2=mysql_query("select * from tb_properties where propertyID='$pid'") or die (mysql_error());
$row2=mysql_fetch_array($query2);

?>
        <tr>


                  <td> <img width="60" src="server/ADMIN/SERVER/AS/<?php echo $row2['image'];?>" alt=""/></td>
                  <td><b><?php echo $row2['name'];?></b><br/><br/>
                    <?php $string=$row2['details'];

$string = strip_tags($string);

if (strlen($string) > 100) {

    // truncate string
    $stringCut = substr($string, 0, 100);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="user_product_details.php?id='.$pid.'"><span style="color:red">Read More</span></a>'; 
}
echo $string;

                    ?></td>
          <td>
      <div class="input-append">
        <center>
        <input class="span1" name="update" style="max-width:34px" placeholder="1" id="french-hens" size="16" type="text" value="<?php echo $row['Unit'];?>" readonly/>
        </center>
    </div>


          </td>
                  <td><?php  echo formatMoney($row2['price'],2); ?></td>
                  <td><?php echo formatMoney($row['Total'],2);
                            echo'<input type="hidden" name="price" value="'.$row['Total'].'">';
                  ?></td>


                  <td>     
   <a href="delete_order_details.php?id=<?php echo $row['Paymentdetailsid'];?>" ></a>
    </a>
  

    </td>
    <?php } ?>

                </tr>
        
              
         <tr>
       
                  <td colspan="5" align="right"><strong>TOTAL=</strong> </td>
                  <td class="label label-important"> <strong>
                     <?php
          $result5 = mysql_query("SELECT sum(total) FROM payment_details WHERE CustomerID='$ses_id' and   PaymentID=''");
          while($row5 = mysql_fetch_array($result5))
            { 
            echo "KES".formatMoney($row5['sum(total)']);
            echo '<input type="hidden" name="totas" value="'.$row5['sum(total)'].'">';
            }
          ?>
                    </strong></td>
                </tr>
        </tbody>
            </table>
    
    <?php
  if($count2==0 ){
?>

                                         <script type="text/javascript">
                                                alert("No Proprties");
                                                window.location= "user_properties.php";
                                            </script>
   <?php
  }else{
?>
           
        
  <a href="user_properties.php" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
  
  <button type="submit" id="" onclick="return confirm('Are you sure you want to pay the total amount?')" name="submit" class="btn btn-large pull-right">PAY NOW <i class="icon-arrow-right"></i></button>
<?php
  }
?>
<!--Your Address: <input type="text" name="shipaddress" placeholder="Address for delivery purpose" required/>
City:
<select size="1" name="city">
<option value="Nairobi">Nairobi</option>
<option value="Mombasa">Mombasa</option>
<option value="Nakuru">Nakuru</option>
<option value="Kisumu">Kisumu</option>
<option value="Kericho">Kericho</option>
<option value="Kiambu">Kiambu</option>
<option value="Muranga">Muranga</option>
<option value="Kisii">Kisii</option>
<option value="Kitui">Kitui</option>
<option value="Bungoma">Bungoma</option>

</select> -->
</form>
<!-- Footer ------------------------------------------------------ -->
<hr class="soft">
<div class="thumbnail" id="footerSection">
  <?php include('footer2.php');?>
</body></div></div></font>