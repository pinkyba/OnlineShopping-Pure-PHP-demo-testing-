<?php
    require 'db_connect.php';
    require 'backendheader.php';

    $sql = "SELECT items.*, subcategories.name as sname, brands.name as bname
            FROM items,subcategories,brands
            WHERE items.subcategory_id = subcategories.id AND items.brand_id = brands.id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $items = $stmt->fetchAll();

    //var_dump($categories);


?>

            <div class="app-title">
                <div>
                    <h1> <i class="icofont-list"></i> Item </h1>
                </div>
                <ul class="app-breadcrumb breadcrumb side">
                    <a href="item_new.php" class="btn btn-outline-primary">
                        <i class="icofont-plus"></i>
                    </a>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Name</th>
                                          <th>Brand</th>
                                          <th>Sub Category</th>
                                          <th>Price</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($items as $item){
                                            $id=$item['id'];
                                            $code = $item['codeno'];
                                            $name=$item['name'];
                                            $brand = $item['bname'];
                                            $subcategory = $item['sname'];
                                            $photo = $item['photo'];
                                            $price = $item['price'];
                                            $discount = $item['discount'];
                                        
                                        ?>
                                        <tr>
                                            <td> <?= $i++ ?> </td>
                                            <td> 

                                                <img src="<?= $photo ?>" style="width: 100px;height: 100px; float: left; margin-right: 10px;">
                                                <div>
                                                <?= $code ?><br>
                                                <?= $name ?>
                                                <div>
                                             </td>
                                            <td><?= $brand ?></td>
                                            <td><?= $subcategory ?></td>

                                            <?php
                                                if($discount == ""){
                                            ?>

                                            <td><?= $price ?> MMK</td>

                                        <?php } else { ?>

                                            <td>
                                            <?= $discount ?> MMK <br>
                                            <del><?= $price ?> MMK</del>
                                            </td>

                                             <?php } ?>
                                            <td>
                                                <a href="item_edit.php?id=<?= $id ?>" class="btn btn-warning">
                                                    <i class="icofont-ui-settings"></i>
                                                </a>

                                                <form class="d-inline-block" onsubmit="return confirm(
                                                'Are you sure you want to delete?')" method="POST" action="item_delete.php">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <button href="" class="btn btn-outline-danger" >
                                                <i class="icofont-close"></i>
                                                </button>
                                                </form>
                                            </td>
                                        </tr>
                                       <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
<?php
    require 'backendfooter.php';
?>