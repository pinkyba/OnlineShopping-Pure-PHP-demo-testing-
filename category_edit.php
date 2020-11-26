<?php
    require 'db_connect.php';
    require 'backendheader.php';

    // get id from address bar
    $id = $_GET['id'];

    $sql = "SELECT * FROM categories WHERE id = :value1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':value1',$id);
    $stmt->execute();
    
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    <div class="app-title">
        <div>
            <h1> <i class="icofont-list"></i> Category Form </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <a href="category_list.php" class="btn btn-outline-primary">
                <i class="icofont-double-left"></i>
            </a>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="category_update.php" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                        <input type="hidden" name="oldphoto" value="<?= $category['logo'] ?>">
                        
                        <div class="form-group row">
                            <label for="name_id" class="col-sm-2 col-form-label"> Name </label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="name_id" name="name" value="<?= $category['name']?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo_id" class="col-sm-2 col-form-label"> Photo </label>
                            <div class="col-sm-10">

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
                                <img src="<?= $category['logo'] ?>" style="width: 80px;height: 80px;">
                              </div>
                              <div class="tab-pane fade mt-3" id="newphoto" role="tabpanel" aria-labelledby="profile-tab">
                                <input type="file" name="photo">
                              </div>
                              
                            </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icofont-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
    require 'backendfooter.php';
?>