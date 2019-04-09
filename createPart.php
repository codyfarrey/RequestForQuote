<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" 
      integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" 
      crossorigin="anonymous">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
      <link rel="stylesheet" href="./index.css" />
      <title>Request for Quote</title>
      <?php require 'auth.php'; ?>
    </head>
    <body>
      <?php 
        $partName = $manufacturerName = $listingPrice = $partQuantity = $partDescription = $comment = "";
        $partNameErr = $manufacturerNameErr = $listingPriceErr = $partQuantityErr = "";

        $feedback = $error = "";
      
        try 
        {
            $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
          $error = "Connection failed: " . $e->getMessage();
        }

        if (isset($_POST["cancel"])) {
          $partName = $manufacturerName = $listingPrice = $partQuantity = $partDescription = $comment = "";
          $partNameErr = $manufacturerNameErr = $listingPriceErr = $partQuantityErr = "";

          echo "CANCEL CLICKED";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          /*************** Form Validation and Populating Variables **************/
          if (empty($_POST["partName"])) {
            $partNameErr = "Part name is required.";
          } else {
            $partName = test_input($_POST["partName"]);
	        }

          if (empty($_POST["manufacturerName"])) {
            $manufacturerNameErr = "Manufacturer name is required.";
          } else {
            $manufacturerName = test_input($_POST["manufacturerName"]);
          }

          if (empty($_POST["listingPrice"])) {
            $listingPriceErr = "Listing price is required.";
          } else {
            $listingPrice = test_input($_POST["listingPrice"]);
          }

          if (empty($_POST["partQuantity"])) {
            $partQuantityErr = "Part quantity is required.";
          } else {
            $partQuantity = test_input($_POST["partQuantity"]);
          }

          if (empty($_POST["partDescription"])) {
            $partDescription = "";
          } else {
            $partDescription = test_input($_POST["partDescription"]);
          }

          if (empty($_POST["comment"])) {
            $comment = "";
          } else {
            $comment = test_input($_POST["comment"]);
          }
	
        /*************** SQL CODE **************/
        if($partNameErr == "" && $manufacturerNameErr == "" && $listingPriceErr == "" && $partQuantityErr == "") {
          $sql ="INSERT INTO inventory(name, price, quantity, description, manufacturer, comments)
          VALUES ('$partName', '$listingPrice', '$partQuantity', '$partDescription', '$manufacturerName', '$comment')";

          //$partName, $listingPrice, $partQuantity, $partDescription, $manufacturerName, $comment)
          $conn->exec($sql);
          $feedback = "New record created successfully.";
          $error = "";
          $partName = $manufacturerName = $listingPrice = $partQuantity = $partDescription = $comment = "";
          $partNameErr = $manufacturerNameErr = $listingPriceErr = $partQuantityErr = "";

          $conn = null;
        } else {
          $error = "* Please fill out all required fields.";
          $feedback = "";
        }

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          $data = str_replace("'", '', $data);
          return $data;
        }

      ?>
      <noscript>You need to enable Javascript to run this app.</noscript>

      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Request For Quote</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>

      <!-- Form -->
      <main>
        <div class="container">

          <div class="row">
            <div class="col-12">
              <h2 class="center">Create New Part</h2>
            </div>
          </div>

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="box">
              <h4 class="center">Part</h4>
              <div class="form-group">
                <label for="partName">Part Name</label>
                <input type="text" class="form-control" id="partName" name="partName" value="<?php echo $partName;?>" placeholder="Part Name">
                <span class="error"><?php echo $partNameErr;?></span>
              </div>

              <div class="form-group">
                <label for="manufacturerName">Manufacturer Name</label>
                <input type="text" class="form-control" id="manufacturerName" name="manufacturerName" value="<?php echo $manufacturerName;?>" placeholder="Manufacturer's Name">
                <span class="error"><?php echo $manufacturerNameErr;?></span>
              </div>

              <div class="form-group">
                <label for="listingPrice">Listing Price</label>
                <input type="number" class="form-control" step="any" id="listingPrice" name="listingPrice" value="<?php echo $listingPrice;?>"  placeholder="0.00">
                <span class="error"><?php echo $listingPriceErr;?></span>
              </div>

              <div class="form-group">
                <label for="partQuantity">Part Quantity</label>
                <input type="number" class="form-control" id="partQuantity" name="partQuantity" value="<?php echo $partQuantity;?>"  placeholder="0-255">
                <span class="error"><?php echo $partQuantityErr;?></span>
              </div>


              <div class="form-group">
                <label for="partDescription">Part Description</label>
                <textarea name="partDescription" id="partDescription" class="form-control" value="<?php echo $partDescription;?>"  rows="3"></textarea>
              </div>
            </div>

            <div class="box">
              <h4 class="center">Comments</h4>

              <div class="box">
                  <div class="form-group">
                    <textarea name="comment" class="form-control" value="<?php echo $comment;?>"  rows="3"></textarea>
                  </div>
              </div>

            </div>

            <div class="box center">
              <span class="feedback"><?php echo $feedback;?></span>
              <span class="error"><?php echo $error; ?></span>
              <div class="row">
                <div class="col-6 center">
                  <button type="reset" name="cancel" class="btn btn-secondary btn-lg">Cancel</button>
                </div>

                <div class="col-6 center">
                  <button type="submit" class="btn btn-primary btn-lg">Create</button>
                </div>
              </div>
            </div>
          </form>

        </div>
	    </main>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" 
    integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" 
    crossorigin="anonymous"></script>
    </body>
</html>
