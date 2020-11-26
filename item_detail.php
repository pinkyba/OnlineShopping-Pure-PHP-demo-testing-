<?php 
	require 'frontendheader.php';
	require 'db_connect.php';

	$id = $_GET['id'];
    $sql = "SELECT items.*, brands.name as bname, categories.name as cname, subcategories.name as sname, items.subcategory_id as sid
    FROM items,brands,categories,subcategories
    WHERE items.brand_id=brands.id AND subcategories.category_id=categories.id AND items.subcategory_id=subcategories.id
    AND items.id=:value1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam('value1',$id);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);


    $sid = $item['sid'];

    $sql = "SELECT * FROM items WHERE subcategory_id=:value1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam('value1',$sid);
    $stmt->execute();

    $related_items = $stmt->fetchAll();
			
?>
	
	<!-- Subcategory Title -->
	<div class="jumbotron jumbotron-fluid subtitle">
  		<div class="container">
    		<h1 class="text-center text-white"> <?= $item['codeno'] ?> </h1>
  		</div>
	</div>
	
	<!-- Content -->
	<div class="container">

		<!-- Breadcrumb -->
		<nav aria-label="breadcrumb ">
		  	<ol class="breadcrumb bg-transparent">
		    	<li class="breadcrumb-item">
		    		<a href="index.php" class="text-decoration-none secondarycolor"> Home </a>
		    	</li>
		    	<li class="breadcrumb-item">
		    		<a href="#" class="text-decoration-none secondarycolor"> Category </a>
		    	</li>
		    	<li class="breadcrumb-item">
		    		<a href="#" class="text-decoration-none secondarycolor"> <?= $item['cname'] ?> </a>
		    	</li>
		    	<li class="breadcrumb-item active" aria-current="page">
					<?= $item['sname'] ?>
		    	</li>
		  	</ol>
		</nav>


		<!-- item detail -->
		<div class="row mt-5">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
				<img src="<?= $item['photo'] ?>" class="img-fluid">
			</div>	


			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
				
				<h4> <?= $item['name'] ?> </h4>

				<div class="star-rating">
					<ul class="list-inline">
						<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
						<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
						<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
						<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
						<li class="list-inline-item"><i class='bx bxs-star-half' ></i></li>
					</ul>
				</div>

				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>

				<p> 
					<span class="text-uppercase "> Current Price : </span>
					<?php
						if($item['discount']){
					?>
					<span class="maincolor ml-3 font-weight-bolder"> <?= $item['discount'] ?> Ks </span>
				<?php } else { ?>
					<span class="maincolor ml-3 font-weight-bolder"> <?= $item['price'] ?> Ks </span>
				<?php } ?>
				</p>

				<p> 
					<span class="text-uppercase "> Brand : </span>
					<span class="ml-3"> <a href="" class="text-decoration-none text-muted"> <?= $item['bname'] ?> </a> </span>
				</p>


				<a href="#" class="addtocartBtn text-decoration-none" data-id="<?= $item['id'] ?>" data-name="<?= $item['name'] ?>" data-codeno="<?= $item['codeno'] ?>" data-photo="<?= $$item['photo'] ?>" data-price="<?= $item['price'] ?>" data-discount="<?= $item['discount'] ?>">
					<i class="icofont-shopping-cart mr-2"></i> Add to Cart
				</a>
				
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-12">
				<h3> Related Item </h3>
				<hr>
			</div>
			<?php 

				foreach ($related_items as $related_item) {
					$photo = $related_item['photo'];
			?>

			<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
				<a href="">
					<img src="<?= $photo ?>" class="img-fluid">
				</a>
			</div>

			<?php } ?>
		</div>

		
	</div>
<?php
	require 'frontendfooter.php';
?>