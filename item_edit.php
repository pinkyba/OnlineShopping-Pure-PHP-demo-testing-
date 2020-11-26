<?php
    require 'db_connect.php';
    require 'backendheader.php';

    $id = $_GET['id'];

    $sql = "SELECT * FROM items WHERE id=:value1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam('value1',$id);
    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);


    $sql = "SELECT * FROM subcategories ORDER BY name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $subcategories = $stmt->fetchAll();


    $sql1 = "SELECT * FROM brands ORDER BY name";
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $brands = $stmt->fetchAll();
?>

            <div class="app-title">
                <div>
                    <h1> <i class="icofont-list"></i> Item Form </h1>
                </div>
                <ul class="app-breadcrumb breadcrumb side">
                    <a href="item_list.php" class="btn btn-outline-primary">
                        <i class="icofont-double-left"></i>
                    </a>
                </ul>
            </div>
            
    <div class="row">
         <div class="col-md-12">
          <div class="tile">
            
            <div class="tile-body">
              <form class="form-horizontal" action="item_update.php" method="POST" enctype="multipart/form-data">

              	<input type="hidden" name="id" value="<?= $item['id'] ?>">
              	<input type="hidden" name="oldphoto" value="<?= $item['photo'] ?>">

                <div class="form-group row">
                  <label class="control-label col-md-3">Photo</label>
                  <div class="col-md-8">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#oldphoto" role="tab" aria-controls="oldphoto" aria-selected="true">Old Photo</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#newphoto" role="tab" aria-controls="newphoto" aria-selected="false">New Photo</a>
                      </li>
                      
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active mt-3" id="oldphoto" role="tabpanel" aria-labelledby="home-tab">
                        <img src="<?= $item['photo'] ?>" style="width: 120px;height: 120px;">
                      </div>
                      <div class="tab-pane fade mt-3" id="newphoto" role="tabpanel" aria-labelledby="profile-tab">
                        <input type="file" name="photo">
                    </div>
                      
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Code No</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Enter code" name="code" value="<?= $item['codeno'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Name</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Enter name" name="name" value="<?= $item['name'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Price</label>
                  <div class="col-md-8">
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" id="nav-unit-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Unit Price </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="nav-discount-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Discount</a>
                      </li>
                      
                    </ul><br>
                    
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-unit-tab">
                            <input class="form-control" type="text" placeholder="Enter unit price" name="unit_price" value="<?= $item['price'] ?>">
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-discount-tab">
                            <input class="form-control" type="text" placeholder="Enter discount" name="discount" value="<?= $item['discount'] ?>">                                    
                        </div>
                    </div>
                    
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Description</label>
                  <div class="col-md-8">
                    <textarea class="form-control" rows="4" name="description"><?= $item['description'] ?></textarea>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3">Brand</label>
                    <div class="col-md-8">
                        <select class="form-control" name="brandid">
                          <?php
                            foreach ($brands as $brand) {
                              $bid = $brand['id'];
                              $bname = $brand['name'];
                              if($bid == $item['brand_id']){
                          ?>
                          	<option value="<?= $bid ?>" selected="selected"><?= $bname ?></option>
                          <?php }else{ ?>

                            <option value="<?= $bid ?>"><?= $bname ?></option>

                          <?php 
                          		}
                      		} ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3">Category</label>
                    <div class="col-md-8">
                        <select class="form-control" name="subcategoryid">
                          <?php
                            foreach ($subcategories as $subcategory) {
                              $sid = $subcategory['id'];
                              $sname = $subcategory['name'];
                              if($sid == $item['subcategory_id']){
                          ?>
                          	<option value="<?= $sid ?>" selected="selected"><?= $sname ?></option>
                          <?php }else{ ?>
                            <option value="<?= $sid ?>"><?= $sname ?></option>

                          <?php 
                          		}
                      		} ?>
                        </select>
                    </div>
                </div>
              

            </div>
            <div class="tile-footer">
              <div class="row">
                <div class="col-md-8 col-md-offset-3">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
        
    </div>

<?php
    require 'backendfooter.php';
?>