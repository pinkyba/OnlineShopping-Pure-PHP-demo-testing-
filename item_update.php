<?php

	require 'db_connect.php';

	$id = $_POST['id'];
	$oldphoto = $_POST['oldphoto'];

	$newphoto = $_FILES['photo'];
	$code = $_POST['code'];
	$name = $_POST['name'];
	$unit_price = $_POST['unit_price'];
	$discount = $_POST['discount'];
	$description = $_POST['description'];
	$brand_id = $_POST['brandid'];
	$subcategory_id = $_POST['subcategoryid'];


	if($newphoto['size'] > 0){
		$basepath = "photo/item/";
		$fullpath = $basepath.$newphoto['name'];
		move_uploaded_file($newphoto['tmp_name'], $fullpath);
	}
	else{
		$fullpath = $oldphoto;
	}

	$sql = "UPDATE items SET codeno=:value1, name=:value2, photo=:value3, price=:value4, discount=:value5, description=:value6, brand_id=:value7, subcategory_id=:value8 WHERE id=:value9";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam('value1',$code);
	$stmt->bindParam('value2',$name);
	$stmt->bindParam('value3',$fullpath);
	$stmt->bindParam('value4',$unit_price);
	$stmt->bindParam('value5',$discount);
	$stmt->bindParam('value6',$description);
	$stmt->bindParam('value7',$brand_id);
	$stmt->bindParam('value8',$subcategory_id);
	$stmt->bindParam('value9',$id);
	$stmt->execute();

	header('location:item_list.php');

	

?>