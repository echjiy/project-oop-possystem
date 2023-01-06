<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');


check_login();
if (isset($_POST['decQuantity'])) {
  //Prevent Posting Blank Values
  if (empty($_POST['prod_quan'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $decrease = $_GET['decrease'];
    $prod_code  = $_POST['prod_code'];
    $prod_name = $_POST['prod_name'];
    $prod_quan = $_POST['prod_quan'];
  

    //Insert Captured information to a database table
    $postQuery = "UPDATE rpos_products SET prod_quan = prod_quan - ? WHERE prod_id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ss', $prod_quan, $decrease);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Quantity Decrease" && header("refresh:1; url=inventory.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    $decrease = $_GET['decrease'];
    $ret = "SELECT * FROM  rpos_products WHERE prod_id = '$decrease' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div style="background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
          <div class="header-body">
          </div>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--8">
        <!-- Table -->
        <div class="row">
          <div class="col">
            <div class="card shadow">
              <div class="card-header border-0">
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Product Name</label>
                      <input type="text" readonly value="<?php echo $prod->prod_name; ?>" name="prod_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Product Code</label>
                      <input type="text" readonly name="prod_code" value="<?php echo $prod->prod_code; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Product Quantity</label>
                      <input type="number" name="prod_quan" class="form-control" value="<?php echo $prod->prod_quan; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="decQuantity" value="Decrease Quantity" class="btn btn-danger" value="">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>