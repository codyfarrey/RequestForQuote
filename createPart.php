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
    </head>
    <body>
      <?php 
        $companyName = $shippingStreet = $shippingCity = $shippingState = $shippingZip = "";
        $matched = $billingStreet = $billingCity = $billingState = $billingZip = $quote = $comment = "";

        $nameErr = $shippingStreetErr = $shippingCityErr = $shippingStateErr = $shippingZipErr = "";
        $billingStreetErr = $billingCityErr = $billingStateErr = $billingZipErr = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["companyName"])) {
            $nameErr = "Company Name is required.";
          } else {
            $companyName = test_input($_POST["companyName"]);
          }

          if (empty($_POST["shippingStreet"])) {
            $shippingStreetErr = "Shipping street is required.";
          } else {
            $shippingStreet = test_input($_POST["shippingStreet"]);
          }

          if (empty($_POST["shippingCity"])) {
            $shippingCityErr = "Shipping city is required.";
          } else {
            $shippingCity = test_input($_POST["shippingCity"]);
          }

          if (empty($_POST["shippingState"])) {
            $shippingStateErr = "Shipping state is required.";
          } else {
            $shippingState = test_input($_POST["shippingState"]);
          }

          if (empty($_POST["shippingZip"])) {
            $shippingZipErr = "Shipping zip is required.";
          } else {
            $shippingZip = test_input($_POST["shippingZip"]);
          }

          if (empty($_POST["billingStreet"])) {
            $billingStreetErr = "Billing street is required.";
          } else {
            $billingStreet = test_input($_POST["billingStreet"]);
          }

          if (empty($_POST["billingCity"])) {
            $billingCityErr = "Billing city is required.";
          } else {
            $billingCity = test_input($_POST["billingCity"]);
          }

          if (empty($_POST["billingState"])) {
            $billingStateErr = "Billing state is required.";
          } else {
            $billingState = test_input($_POST["billingState"]);
          }

          if (empty($_POST["billingZip"])) {
            $billingZipErr = "Billing zip is required.";
          } else {
            $billingZip = test_input($_POST["billingZip"]);
          }

          if (empty($_POST["comment"])) {
            $comment = "";
          } else {
            $comment = test_input($_POST["comment"]);
          }

          if (empty($_POST["quote"])) {
            $quote = "";
          } else {
            $quote = test_input($_POST["quote"]);
          }

          if (empty($_POST["matched"])) {
            $matched = "";
          } else {
            $matched = test_input($_POST["matched"]);
	  }

        }

	
	if (isset($_POST["cancel"])) {
     	    $companyName = $shippingStreet = $shippingCity = ""; 
	    $shippingState = $shippingZip = $billingStreet =  "";
	    $billingCity = $billingState = $billingZip = "";
	    $quote = $comment = $matched = "";
            $nameErr = $shippingStreetErr = $shippingCityErr = "";
	    $shippingStateErr = $shippingZipErr = $billingStreetErr = "";
	    $billingCityErr = $billingStateErr = $billingZipErr = "";
	}

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
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
                <input type="text" class="form-control" id="partName" name="partName" placeholder="Part Name">
              </div>

              <div class="form-group">
                <label for="manufacturerName">Manufacturer Name</label>
                <input type="text" class="form-control" id="manufacturerName" name="manufacturerName" value="<?php echo $companyName;?>" placeholder="Manufacturer's Name">
                <span class="error">* <?php echo $nameErr;?></span>
              </div>

              <div class="form-group">
                <label for="listingPrice">Listing Price</label>
                <input type="number" class="form-control" step="any" id="listingPrice" name="listingPrice" placeholder="0.00">
              </div>

              <div class="form-group">
                <label for="partQuantity">Part Quantity</label>
                <input type="number" class="form-control" id="partQuantity" name="partQuantity" placeholder="0-255">
              </div>


              <div class="form-group">
                <label for="partDescription">Part Description</label>
                <textarea name="partDescription" id="partDescription" class="form-control" value="<?php echo $comment;?>"  rows="3"></textarea>
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

            <div class="box">
              <div class="row">
                <div class="col-6 center">
                  <button type="button" name="cancel" class="btn btn-secondary btn-lg">Cancel</button>
                </div>

                <div class="col-6 center">
                  <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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
