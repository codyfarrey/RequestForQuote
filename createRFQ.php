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
      <?php
        require 'auth.php';

        $conn = new mysqli($servername, $username, $password, $username);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
      ?>
    </head>
    <body>
      <?php 
        $repEmail = $repPassword = $repEmailErr = $repPasswordErr = "";
        $feedback = $error = $accountNumber = "";

        $partId = $partIdErr = $quantity = $quantityErr = $date = $dateErr = "";

        $parts = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          /*************** Form Validation and Populating Variables **************/
          if (empty($_POST["repEmail"])) {
            $repEmailErr = "Email is required.";
          } else {
            $repEmail = test_input($_POST["repEmail"]);
	        }

          if (empty($_POST["repPassword"])) {
            $repPasswordErr = "Password is required.";
          } else {
            $repPassword = test_input($_POST["repPassword"]);
          }

          
          /*************** SQL CODE **************/
          if(empty($repEmailErr) && empty($repPasswordErr)) {
            $sql = "SELECT AccountNumber, Email, Password FROM Rep WHERE Email LIKE ('$repEmail')";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                if ($repEmail == $row["Email"] && $repPassword == $row["Password"]) {
                  $accountNumber = $row["AccountNumber"];
                } else {
                  echo "Invalid Password.";
                }
              }
            } else {
              echo "Invalid Email";
            }
          }
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
        <a class="navbar-brand" href="#">RFQ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="./index.php">Log Out</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./createCustomer.php">Create Customer</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="./createPart.php">Create Part</a><span class="sr-only">(current)</span></a>
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
              <h2 class="center">Create Request For Quote</h2>
            </div>
          </div>

          <?php if (empty($accountNumber)): ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="box">
              <h4 class="center">Customer</h4>
              <div class="box">
                <div class="form-group">
                  <label for="repEmail">Customer Representative Email</label>
                  <input type="text" class="form-control" id="repEmail" name="repEmail" value="<?php echo $repEmail;?>" placeholder="rep@email.com">
                  <span class="error"><?php echo $repEmailErr;?></span>
                </div>

                <div class="form-group">
                  <label for="repPassword">Password</label>
                  <input type="text" class="form-control" id="repPassword" name="repPassword" value="<?php echo $repPassword;?>" placeholder="********">
                  <span class="error"><?php echo $repPasswordErr;?></span>
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
            </div>
          </form>
          <?php else: ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="box">
              <h4 class="center">RFQ</h4>
              <div class="box">
                <div class="form-group">

                  <label for="partId">Part</label>
                  <?php
                    $sql = "SELECT PartID, Name FROM Inventory";
                    $result = $conn->query($sql);

                    echo '<select class="form-control" name="partId">';
                    
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo '<option value="' .$row['PartID'].'">'.$row['Name'].'</option>';
                      }
                    }

                    echo '</select>';
        
                    $conn = null;
                  ?>
                  <span class="error"><?php echo $partIdErr;?></span>
                </div>

                <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity;?>">
                  <span class="error"><?php echo $quantityErr;?></span>
                </div>

                <div class="form-group">
                  <label for="date">Date Required</label>
                  <input type="date" class="form-control" id="date" name="date" value="<?php echo $date;?>" min="<?php echo date("d/m/Y") ?>">
                  <span class="error"><?php echo $dateErr;?></span>
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
            </div>
          </form>
          <?php endif; ?>
        </div>
	    </main>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" 
    integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" 
    crossorigin="anonymous"></script>
    </body>
</html>
