<?php

	require 'db_connect.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$oldphoto = $_POST['oldphoto'];

	$newphoto = $_FILES['photo'];

	// echo "$id";
	// echo "$name";
	// var_dump($oldphoto);
	// var_dump($newphoto);

	if($newphoto['size'] > 0){
		$basepath = "photo/category/";
		$fullpath = $basepath.$newphoto['name'];
		move_uploaded_file($newphoto['tmp_name'], $fullpath);
	}
	else{
		$fullpath = $oldphoto;
	}

	$sql = "UPDATE categories SET name=:value1, logo=:value2 WHERE id=:value3";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam('value1',$name);
	$stmt->bindParam('value2',$fullpath);
	$stmt->bindParam('value3',$id);
	$stmt->execute();

	header('location:category_list.php');

	

?>