<?php

	require 'db_connect.php';

	$photo = $_FILES['photo'];
	$name = $_POST['name'];
	$code = $_POST['code'];
	$unit_price = $_POST['unit_price'];
	$discount = $_POST['discount'];
	$description = $_POST['description'];
	$brand_id = $_POST['brand_id'];
	$subcategory_id = $_POST['subcategory_id'];

	$basepath = 'photo/item/';
	$fullpath = $basepath.$photo['name'];

	move_uploaded_file($photo['tmp_name'], $fullpath);

	$sql = "INSERT INTO items (name,codeno,photo,price,discount,description,brand_id,subcategory_id) VALUES (:v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':v1',$name);
	$stmt->bindParam(':v2',$code);
	$stmt->bindParam(':v3',$fullpath);
	$stmt->bindParam(':v4',$unit_price);
	$stmt->bindParam(':v5',$discount);
	$stmt->bindParam(':v6',$description);
	$stmt->bindParam(':v7',$brand_id);
	$stmt->bindParam(':v8',$subcategory_id);

	$stmt->execute();

	header('location: item_list.php');

?>