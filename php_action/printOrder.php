<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, sub_total,total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$subTotal = $orderData[1];
$totalAmount = $orderData[2]; 
$discount = $orderData[3];
$grandTotal = $orderData[4];
$paid = $orderData[5];
$due = $orderData[6];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '

<table border="0" width="100%;" cellpadding="5" style="border:1px solid black;border-top-style:1px solid black;border-bottom-style:1px solid black;">

	<tbody>
		<tr>
			<th>S.no</th>
			<th>Product</th>
			<th>Rate</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<th>'.$x.'</th>
				<th>'.$row[4].'</th>
				<th>'.$row[1].'</th>
				<th>'.$row[2].'</th>
				<th>'.$row[3].'</th>
			</tr>
			';
		$x++;
		} // /while

		$table .= '<tr>
			<th></th>
		</tr>

		<tr>
			<th></th>
		</tr>

		<tr>
			<th>Sub Amount</th>
			<th>'.$subTotal.'</th>			
		</tr>

	

		<tr>
			<th>Total Amount</th>
			<th>'.$totalAmount.'</th>			
		</tr>	

		<tr>
			<th>Discount</th>
			<th>'.$discount.'</th>			
		</tr>

		<tr>
			<th>Grand Total</th>
			<th>'.$grandTotal.'</th>			
		</tr>

		<tr>
			<th>Paid Amount</th>
			<th>'.$paid.'</th>			
		</tr>

		<tr>
		<th>Due Amount</th>
		<th>'.number_format($due, 2).'</th>			
	</tr>
	</tbody>
</table>
 ';


$connect->close();

echo $table;