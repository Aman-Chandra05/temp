<?php

require 'header.php';
require_once 'classes/Order.php';
require_once 'classes/dbcon.php';
require_once 'classes/Order.php';
$conn = new Dbcon();
$order=new Order();
$totalprice=0;
$res=$order->fetchorder($_GET['id'],$conn->conn());
$details=json_decode($res['details'], true);
$tax=json_decode($res['tax_amt'], true);

//  foreach ($_SESSION['cart'] as $key)  {
//  	//$taxammount=$taxammount+$key['taxammount'];
//  	$totalprice=$totalprice+$key['totalprice'];
//  }




?>
<div class="container">
			<h2>Customer Name: <?php echo $_SESSION['username'];   ?></h2>
			<h3><br>Items Purchased</h3>
			<div>
				<?php
		    	// foreach ($_SESSION['cart'] as $key) 
		    	// {
		    	// ?>
			     	<!-- <p><strong>Product Name:</strong> <?php //echo $key['prod_name'];?></p>
			    // 	<p><strong>Plan:</strong> <?php //echo $key['billingcycle'];?></p>
			    // 	<p><strong>Amount:</strong> &#36;<?php //echo $key['ammount'];?></p><br> -->
		    	 <?php
				// }
					for ($i=0; $i <count($details) ; $i++) { 
						if(is_array($details[$i]))
						{
							echo "<p><strong>Product Name:</strong> ".$details[$i]['productname'].'</p>';
							echo "<p><strong>Plan:</strong> ".$details[$i]['plan'].'</p>';
							echo "<p><strong>Amount:</strong> &#36;".$details[$i]['price'].'</p><br>';
						}
					}

				?>
			</div>
			<h3>Payment details</h3>

				<p><strong>Total amount: </strong>&#36; <?php $len=count($details)-1; echo $details[$len];?></p>
				
				<p><?php if(count($tax)==2)
					{
						echo "<p><strong>IGST: </strong>&#36; ".$tax['igst'];
					}
					elseif(count($tax)==3)
					{
						echo "<p><strong>CGST:</strong>&#36; ".$tax['cgst'];
						echo "<p><strong>SGST:</strong>&#36; ".$tax['sgst'];
					}

				?>
				<p><strong>Total Tax amount: </strong>&#36; <?php echo $tax['tax'];?></p>
				<p><strong>Final amount: </strong>&#36; <?php echo $res['final_invoice_amt'];?></p>		
		<?php
		if ($res['status']==0) 
		{
			?>
			<div class="failure">
				<strong><?php echo "Payment Status: Pending";?></strong>
			</div>
		<?php
		}
		elseif ($res['status']==1) {?>
			<div class="success">
				<strong><?php echo "Payment Status: Success";?></strong>
			</div>
		<?php
		}
	?>

</div>






<?php
require_once 'footer.php';
?>

