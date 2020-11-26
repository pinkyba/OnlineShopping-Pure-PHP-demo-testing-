<?php
	session_start();
	require 'db_connect.php';

	$carts = $_POST['value1'];
	$notes = $_POST['value2'];
	$total = $_POST['value3'];

	// var_dump($carts); die();

	date_default_timezone_set('Asia/Rangoon');

	$orderdate = date('Y-m-d');
	
	$voucherno = strtotime(date('h:i:s'));

	$status = "Order";

	$user_id = $_SESSION['login_user']['user_id'];
	// echo $user_id;die();

	$sql = "INSERT INTO orders(orderdate, voucherno, total, note, status, user_id)
		VALUES (:value1, :value2, :value3, :value4, :value5, :value6)";

	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':value1',$orderdate);
	$stmt->bindParam(':value2',$voucherno);
	$stmt->bindParam(':value3',$total);
	$stmt->bindParam(':value4',$notes);
	$stmt->bindParam(':value5',$status);
	$stmt->bindParam(':value6',$user_id);
	$stmt->execute();

	// last order id
	$order_id = $conn->lastInsertId();

	// insert item_order table
	foreach($carts as $cart){
		$item_id = $cart['id'];
		$qty = $cart['qty'];

		$sql = "INSERT INTO item_order (qty, item_id, order_id)
			VALUES (:value1, :value2, :value3)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':value1',$qty);
		$stmt->bindParam(':value2',$item_id);
		$stmt->bindParam(':value3',$order_id);	
		$stmt->execute();
	}

?>