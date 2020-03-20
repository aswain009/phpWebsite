<?php require('manage/includes/settings.php');

if($_POST['dealerSubmit']){
	$message = processDealerAccount($_POST);
}

use a3smedia\utilities\Database;

$orderObj = new regodesign\store\Orders;
$prodOrderObj = new regodesign\store\OrderProducts;
$statusObj = new regodesign\store\Statuses;
$orderFeed = $orderObj->readOrdersByConsumer($_SESSION['customer_id']);
//Database::pre_var_dump($orderFeed);

//$status = array('0' => 'Processing', '1' => 'Shipped', '2' => 'Completed');

include('includes/header.php'); ?>
<style>

</style>

<h3>ORDER HISTORY</h3>

<div class="row">

    <h3>Click on the Order ID to see details and items on the order</h3>
	<table class="order-detail-table">
        <thead>
            <tr>
                <td>Order ID</td>
                <td>PO</td>
                <td>Date</td>
                <td>Qty</td>
                <td>Shipped</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
		<?php foreach($orderFeed as $order){ ?>
			<tr>

				<td><a style="color:#5BC0E6" href="order-review.php?id=<?=$order->getID()?>"><?=$order->getID()?></a></td>
                <td></td>
				<td>
					<?php $timezone = new DateTimeZone('America/New_York');
					$dtObj = new DateTime($order->getDate(), $timezone);
					?>
					<?=$dtObj->format('m/d/Y') ?>
				</td>
				<td><?=$order->getQuantity(); ?></td>
				<td><?=$order->getShipped(); ?></td>
				<td>
					<?php $status = $statusObj->readStatusByID($order->getStatus()); ?>
					<?=$status->getName(); ?>
                </td>
			</tr><!--.orderItem-->
		<?php } ?>
	</tbody><!--#dealerBody-->
    </table>
</div>

<script>
	$(function(){
		var animate = false;

		$('.expandButton').click(function(){
			var productsDisplay = $(this).siblings('.orderProducts');
			console.log(productsDisplay.attr('class'));
			if(productsDisplay.is(':visible')){
				console.log('visible');
				productsDisplay.hide();
				$(this).text('+ Expand')
			} else {
				console.log('hidden');
				productsDisplay.show();
				$(this).text('- Collapse');
			}
		})
	});
</script>

<?php include('includes/footer.php'); ?>