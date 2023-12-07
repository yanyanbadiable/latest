<?php require_once 'includes/header.php'; ?>

<?php

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = "";
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue = $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$connect->close();

?>


<style type="text/css">
	
	.ui-datepicker-calendar {
		display: none;
	}
	._dashboard-card{
		margin-bottom:25px;
	}
	.cardContainer{
		background-color: #fff;
	}
	.card1{
		background-color: #54B4D3!important;
	}
	.card2{
		background-color: #3B71CA!important;
	}
	.card3{
		background-color: #FFA500!important;
	}
	.card4{
		background-color: #14A44D!important;
	}
	.card5{
		background-color: #DC4C64!important;
	}
	main{
		display: flex;
		justify-content: center;
		align-items: center;
		height: calc(100svh - 100px);
	
	}
	.card{
		min-width: 300px!important;
	}
</style>

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">

<main>
<div class="row">

<div class="col-sm-6 _dashboard-card">
		<div class="card">
			<div class="cardHeader card1">
				<h1>
					<?php echo date('d'); ?>
				</h1>
			</div>

			<div class="cardContainer">
				<p>
					<?php echo date('l') . ' ' . date('d') . ', ' . date('Y'); ?>
				</p>
			</div>
		</div>
	</div>

	<div class="col-sm-6 _dashboard-card">
		<div class="card">
			<div class="cardHeader card2" style="background-color:#245580;">
				<h1>
					<?php if ($totalRevenue) {
						echo $totalRevenue;
					} else {
						echo '0';
					} ?>
				</h1>
			</div>

			<div class="cardContainer">
				<p> <!--<i class="glyphicon glyphicon-usd"></i>--> Total Revenue</p>
			</div>
		</div>
	</div>

	<div class="col-sm-4 _dashboard-card">
	<div class="card">
		<a href="product.php" style="text-decoration:none;color:black;">
			<div class="cardHeader card3">
				<h1>

					<span>
					<?php echo $countProduct; ?>
					</span>

				</h1>
			</div>

			<div class="cardContainer bg-primary">
				<p>
						Total Products
					</a></p>
			</div>

		</div>

	</div> <!--/col-md-4-->

	<div class="col-sm-4 _dashboard-card">
		<div class="card" >
		<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
			<div class="cardHeader card4">
				<h1>

					<span>
					<?php echo $countOrder; ?>
					</span>

				</h1>
			</div>

			<div class="cardContainer">
				<p>
						Total Orders</p>
			</div>
		</a>
		</div>
	</div> <!--/col-md-4-->

	<div class="col-sm-4 _dashboard-card">
		<div class="card">
		<a href="product.php" style="text-decoration:none;color:black;">
			<div class="cardHeader card5">
				<h1>

					<span>
						<?php echo $countLowStock; ?>
					</span>

				</h1>
			</div>

			<div class="cardContainer">
				<p>
						Low Stock
					</p>
			</div>
			</a>
		</div>
	</div>

</div>
</main>




<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
		// top bar active
		$('#navDashboard').addClass('active');

		//Date for the calendar events (dummy data)
		var date = new Date();
		var d = date.getDate(),
			m = date.getMonth(),
			y = date.getFullYear();

		$('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title'
			},
			buttonText: {
				today: 'today',
				month: 'month'
			}
		});


	});
</script>

<?php require_once 'includes/footer.php'; ?>