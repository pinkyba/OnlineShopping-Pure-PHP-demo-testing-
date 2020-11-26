<?php
  require 'backendheader.php';
  require 'db_connect.php';
  //var_dump($_SESSION['login_user']);

  $id = $_GET['id'];
  $sql = "SELECT orders.*, users.name as uname, users.address as uaddress, users.email as uemail,
          users.phone as uphone
          FROM orders,users
          WHERE orders.user_id = users.id AND orders.id = :value1";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':value1',$id);
  $stmt->execute();

  $order = $stmt->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT items.*, item_order.qty as item_qty 
          FROM item_order,items
          WHERE item_order.order_id = :value1 AND item_order.item_id = items.id";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':value1',$id);
  $stmt->execute();

  $orderdetails = $stmt->fetchAll();


?>
  <div class="app-title">
  <div>
    <h1><i class="fa fa-file-text-o"></i> Invoice</h1>
    <p>A Printable Invoice Format</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item"><a href="#">Invoice</a></li>
  </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <section class="invoice">
          <div class="row mb-4">
            <div class="col-6">
              <h2 class="page-header"> <img src="logo/logo_med.jpg"></h2>
            </div>
            <div class="col-6">
              <h5 class="text-right">Date: <?= $order['orderdate'] ?> </h5>
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-4">From
              <address><strong>Shopules Inc.</strong>
                <?php 
                  if(isset($_SESSION['login_user'])){


                ?>
                <br><?= $_SESSION['login_user']['address'] ?>
                <br><?= $_SESSION['login_user']['name'] ?>
                <br><?= $_SESSION['login_user']['email'] ?>

              <?php } ?>
              </address>
            </div>
            <div class="col-4">To
              <address><strong> <?= $order['uname'] ?> </strong><br> <?= $order['uaddress'] ?> <br>Phone: <?= $order['uphone'] ?><br>Email: <?= $order['uemail'] ?></address>
            </div>
            <div class="col-4"><b>Invoice:  <?= $order['voucherno'] ?></b><br><br><b>Total:</b> <?= $order['total'] ?> Ks</div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Qty</th>
                    <th>Product</th>
                    <th>Serial #</th>
                    <th>Unit Price</th>                    
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($orderdetails as $orderdetail){
                      $qty =  $orderdetail['item_qty'];
                      $name = $orderdetail['name'];
                      $codeno = $orderdetail['codeno'];
                      $price = $orderdetail['price'];
                      $discount = $orderdetail['discount'];
                    

                  ?>
                  <tr>
                    <td> <?= $qty ?> </td>
                    <td> <?= $name ?> </td>
                    <td> <?= $codeno ?> </td>
                  <?php 
                    if($discount){
                      $subtotal = $discount*$qty;
                  ?>
                    <td> <?= $discount ?> Ks</td>
                    <td> <?= $subtotal ?> Ks</td>

                  <?php }else{

                    $subtotal = $price*$qty;
                  ?>

                    <td> <?= $price ?> Ks</td>
                    <td> <?= $subtotal ?> Ks</td>

                  <?php } ?> 

                  </tr>

                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Print</a></div>
          </div>
        </section>
      </div>
    </div>
  </div>
<?php
  require 'backendfooter.php';
?>