<?php 	

require_once 'core.php';

$sql = "SELECT order_id, order_date FROM orders WHERE order_status = 1";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 

 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];

 	$countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();


 	

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    

	    <li><a type="button" onclick="printOrder('.$orderId.')"> <i class="glyphicon glyphicon-print"></i> Print </a></li>
	    
	    <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 		
 		// image
 		$x,
 		// order date
 		$row[1],
 		
 				 	
 		$itemCountRow, 		 	
 		
 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);