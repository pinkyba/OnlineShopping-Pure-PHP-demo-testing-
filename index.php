<?php
	require 'frontendheader.php';

	$sql = "SELECT * FROM categories ORDER BY name LIMIT 8";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();


    $sql = "SELECT * FROM brands ORDER BY name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $brands = $stmt->fetchAll();

    //discount item
    $sql = "SELECT * FROM items WHERE discount != '' LIMIT 8";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $discount_items = $stmt->fetchAll();


    //flash_sale
    $sql = "SELECT * FROM items ORDER BY created_at DESC LIMIT 8";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $hot_items = $stmt->fetchAll();


    //fresh pick 
    $sid = 10;
    $sql = "SELECT * FROM items WHERE subcategory_id=:value1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam('value1',$sid);
    $stmt->execute();
    $random_items = $stmt->fetchAll();


?>
<!-- Carousel -->
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  		<ol class="carousel-indicators">
    		<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    		<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    		<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  		</ol>
  		
  		<div class="carousel-inner">
    		<div class="carousel-item active">
		      	<img src="frontend/image/banner/ac.jpg" class="d-block w-100 bannerImg" alt="...">
		    </div>
		    <div class="carousel-item">
		      	<img src="frontend/image/banner/giordano.jpg" class="d-block w-100 bannerImg" alt="...">
		    </div>
		    <div class="carousel-item">
		      	<img src="frontend/image/banner/garnier.jpg" class="d-block w-100 bannerImg" alt="...">
		    </div>
  		</div>
	</div>


	<!-- Content -->
	<div class="container mt-5 px-5">
		<!-- Category -->
		<div class="row">
			<?php
				foreach ($categories as $category){
					$cid = $category['id'];
					$cname = $category['name'];
					$clogo = $category['logo'];
			?>

			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 ">
				<div class="card categoryCard border-0 shadow-sm p-3 mb-5 rounded text-center">
				  	<img src="<?= $clogo ?>" class="card-img-top" alt="..." style="width: 200px; height: 160px;">
				  	<div class="card-body">
				    	<p class="card-text font-weight-bold text-truncate"> <?= $cname ?> </p>
				  	</div>
				</div>
			</div>
			<?php } ?>
			
		</div>

		<div class="whitespace d-xl-block d-lg-block d-md-none d-sm-none d-none"></div>
		
		<!-- Discount Item -->
		<div class="row mt-5">
			<h1> Discount Item </h1>
		</div>

	    <!-- Disocunt Item -->
		<div class="row">
			<div class="col-12">
				<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
		            <div class="MultiCarousel-inner">
		            	<?php
                            $i = 1;
                            foreach ($discount_items as $discount_item){
                                $did=$discount_item['id'];
                                $dcode = $discount_item['codeno'];
                                $dname=$discount_item['name'];
                                $dphoto = $discount_item['photo'];
                                $dprice = $discount_item['price'];
                                $ddiscount = $discount_item['discount'];
                            
                        ?>
		                <div class="item">
		                    <div class="pad15">
		                    	<a href="item_detail.php?id=<?= $did ?>">
		                    	<img src="<?= $dphoto ?>" class="img-fluid">
		                    	</a>
		                        <p class="text-truncate"><?= $dname ?></p>
		                        <p class="item-price">
		                        	<strike><?= $dprice ?> Ks </strike> 
		                        	<span class="d-block" style="color: red;"><?= $ddiscount ?> Ks</span>
		                      
		                        </p>

		                        <div class="star-rating">
									<ul class="list-inline">
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star-half' ></i></li>
									</ul>
								</div>

								<a href="" class="addtocartBtn text-decoration-none" data-id="<?= $did ?>" data-name="<?= $dname ?>" data-codeno="<?= $dcode ?>" data-photo="<?= $dphoto ?>" data-price="<?= $dprice ?>" data-discount="<?= $ddiscount ?>">Add to Cart</a>

		                    </div>
		                </div>
		                <?php } ?>
		                
		            </div>
		            <button class="btn btnMain leftLst"><</button>
		            <button class="btn btnMain rightLst">></button>
		        </div>
		    </div>
		</div>

		<!-- Flash Sale Item -->
		<div class="row mt-5">
			<h1> Flash Sale </h1>
		</div>

	    <!-- Flash Sale Item -->
		<div class="row">
			<div class="col-12">
				<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
		            <div class="MultiCarousel-inner">
		            	<?php
                            $i = 1;
                            foreach ($hot_items as $hot_item){
                                $hid=$hot_item['id'];
                                $hname=$hot_item['name'];
                                $hphoto = $hot_item['photo'];
                                $hprice = $hot_item['price'];
                                $hdiscount = $hot_item['discount'];
                            
                        ?>
		                <div class="item">
		                    <div class="pad15">
		                    	<a href="item_detail.php?id=<?= $hid ?>">
		                    	<img src="<?= $hphoto ?>" class="img-fluid">
		                    	</a>
		                        <p class="text-truncate"><?= $hname ?></p>

		                        <?php 
		                        	if($hdiscount == ""){
		                        ?>

		                        <p class="item-price">	
		                        	<span class="d-block"><?= $hprice ?> Ks</span>
		                        </p>

		                    	<?php }else{ ?>

		                    		<p class="item-price">
			                        	<strike><?= $hprice ?> Ks </strike> 
			                        	<span class="d-block"><?= $hdiscount ?> Ks</span>
		                        	</p>

		                        <?php } ?>

		                        <div class="star-rating">
									<ul class="list-inline">
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star-half' ></i></li>
									</ul>
								</div>

								<a href="#" class="addtocartBtn text-decoration-none" data-id="<?= $hid ?>" data-name="<?= $hname ?>" data-codeno="<?= $dcode ?>" data-photo="<?= $hphoto ?>" data-price="<?= $hprice ?>" data-discount="<?= $hdiscount ?>">Add to Cart</a>

		                    </div>		                    
		                </div>
		             	<?php } ?>		                
		            </div>
		            <button class="btn btnMain leftLst"><</button>
		            <button class="btn btnMain rightLst">></button>
		        </div>
		    </div>
		</div>

		<!-- Random Catgory ~ Item -->
		<div class="row mt-5">
			<h1> Fresh Picks </h1>
		</div>

	    <!-- Random Item -->
		<div class="row">
			<div class="col-12">
				<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
		            <div class="MultiCarousel-inner">
		            	<?php
                            $i = 1;
                            foreach ($random_items as $random_item){
                                $rid=$random_item['id'];
                                $rcode = $random_item['codeno'];
                                $rname=$random_item['name'];
                                $rphoto = $random_item['photo'];
                                $rprice = $random_item['price'];
                                $rdiscount = $random_item['discount'];
                            
                        ?>
		                <div class="item">
		                    <div class="pad15">
		                    	<a href="item_detail.php?id=<?= $rid ?>">
		                    	<img src="<?= $rphoto ?>" class="img-fluid">
		                    	</a>
		                        <p class="text-truncate"><?= $rname ?></p>

		                        <?php 
		                        		if($rdiscount == ""){
		                        ?>

		                        <p class="item-price">	
		                        	<span class="d-block"><?= $rprice ?> Ks</span>
		                        </p>

		                    	<?php }else{ ?>

		                    		<p class="item-price">
			                        	<strike><?= $rprice ?> Ks </strike> 
			                        	<span class="d-block"><?= $rdiscount ?> Ks</span>
		                        	</p>

		                        <?php } ?>

		                        <div class="star-rating">
									<ul class="list-inline">
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star' ></i></li>
										<li class="list-inline-item"><i class='bx bxs-star-half' ></i></li>
									</ul>
								</div>

								<a href="#" class="addtocartBtn text-decoration-none" data-id="<?= $rid ?>" data-name="<?= $rname ?>" data-codeno="<?= $rcode ?>" data-photo="<?= $rphoto ?>" data-price="<?= $rprice ?>" data-discount="<?= $rdiscount ?>">Add to Cart</a>
		                    </div>
		                </div>
		            	<?php } ?> 
		            </div>
		            <button class="btn btnMain leftLst"><</button>
		            <button class="btn btnMain rightLst">></button>
		        </div>
		    </div>
		</div>

		
		<div class="whitespace d-xl-block d-lg-block d-md-none d-sm-none d-none"></div>

	    <!-- Brand Store -->
	    <div class="row mt-5">
			<h1> Top Brand Stores </h1>
	    </div>

	    <!-- Brand Store Item -->
	    <section class="customer-logos slider mt-5">
	    	<?php
				foreach ($brands as $brand){
					$bid - $brand['id'];
					$bphoto = $brand['photo'];
			?>
	      	<div class="slide">
	      		<a href="">
		      		<img src="<?= $bphoto ?>">
		      	</a>
	      	</div>
	      	<?php } ?>
	      	
	   	</section>

	    <div class="whitespace d-xl-block d-lg-block d-md-none d-sm-none d-none"></div>

	</div>


<?php
	require 'frontendfooter.php';
?>