<?php

	require 'db_connect.php';

	$id = $_POST['id'];
	
	$sql = "DELETE FROM orders WHERE id=:value1";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':value1',$id);
	$stmt->execute();

	header('location: order_list.php');
?>