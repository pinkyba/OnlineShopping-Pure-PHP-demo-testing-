<?php

	//connect database
	require "db_connect.php";

	$name = $_POST['name'];
	$categoryid = $_POST['categoryid'];

	echo "$name";
	echo "$categoryid";


	$sql = "INSERT INTO subcategories(name,category_id) VALUES (:value1, :value2)";

	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':value1',$name);
	$stmt->bindParam(':value2',$categoryid);
	$stmt->execute();

	header('location: subcategory_list.php');
?>