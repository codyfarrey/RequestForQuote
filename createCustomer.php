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

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } 
  catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
  }
?>
</head>

<body>
<?php 
  $companyName = $shippingStreet = $shippingCity = $shippingState = $shippingZip = "";
  $matched = $billingStreet = $billingCity = $billingState = $billingZip = $quote = $comment = "";

  $firstName = $lastName = $email = $phone = "";
  $firstNameErr = $lastNameErr = $emailErr = $phoneErr = "";

  $nameErr = $shippingStreetErr = $shippingCityErr = $shippingStateErr = $shippingZipErr = "";
  $billingStreetErr = $billingCityErr = $billingStateErr = $billingZipErr = $password = "";

  $error = $feedback = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = test_input(date("U"));

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

    if (empty($_POST["firstName"])) {
      $firstNameErr = "First name is required.";
    } else {
      $firstName = test_input($_POST["firstName"]);
    }

    if (empty($_POST["lastName"])) {
      $lastNameErr = "Last name is required.";
    } else {
      $lastName = test_input($_POST["lastName"]);
    }

    if (empty($_POST["email"])) {
      $emailErr = "Email is required.";
    } else {
      $email = test_input($_POST["email"]);
    }

    if (empty($_POST["phone"])) {
      $phoneErr = "Phone number is required.";
    } else {
      $phone = test_input($_POST["phone"]);
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

    /***************** SQL CODE *****************/	
    if($firstNameErr == "" && $lastNameErr == "" && $emailErr == "" && $phoneErr == ""&& $nameErr == "" 
    && $shippingStreetErr == "" && $shippingCityErr == "" && $shippingStateErr == ""
    && $shippingZipErr == "" && $billingStreetErr == "" && $billingCityErr == "" && $billingStateErr == "" 
    && $billingZipErr == "") {

      $sql = "INSERT INTO CustomerAccount(CompanyName, QuoteType, Comments) VALUES 
      ('$companyName', '$quote', '$comment') ON DUPLICATE KEY UPDATE QuoteType = '$quote'";

      $conn->exec($sql);

      $myAccount = $conn->query("SELECT CustomerAccount.AccountNumber 
      FROM CustomerAccount WHERE CompanyName='".$companyName."'");

      $myAccount->execute();
      $val = $myAccount->fetch(PDO::FETCH_BOTH);

      $sql = "INSERT INTO ShippingAddress(AccountNumber, Street, City, State, Zip)
      VALUES ('$val[0]', '$shippingStreet', '$shippingCity', '$shippingState', '$shippingZip')";

      $conn->exec($sql);

      $sql = "INSERT INTO BillingAddress(AccountNumber, Street, City, State, Zip)
      VALUES ('$val[0]', '$billingStreet', '$billingCity', '$billingState', '$billingZip')";

      $conn->exec($sql);

      $sql = "INSERT INTO Rep(FirstName, LastName, Email, Password, Phone, AccountNumber)
      VALUES ('$firstName', '$lastName', '$email', '$password', '$phone', '$val[0]')";
      
      $conn->exec($sql);

      $feedback = "Data succesfully added.";
      $error = "";

      $companyName = $shippingStreet = $shippingCity = $shippingState = $shippingZip = "";
      $matched = $billingStreet = $billingCity = $billingState = $billingZip = $quote = $comment = "";

      $firstName = $lastName = $email = $phone = "";
      $firstNameErr = $lastNameErr = $emailErr = $phoneErr = "";

      $nameErr = $shippingStreetErr = $shippingCityErr = $shippingStateErr = $shippingZipErr = "";
      $billingStreetErr = $billingCityErr = $billingStateErr = $billingZipErr = "";

      $conn = null;
    } else {
      $error = "Please fill out all required fields.";
      $feedback = "";
    }
  }

  /* Function to trim all the crap out of the string */
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
          <h2 class="center">Create Customer Account</h2>
        </div>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="box">
          <h4 class="center">Company</h4>

          <div class="form-group">
            <label for="companyName">Company Name</label>
            <input type="text" class="form-control" id="companyName" name="companyName" value="<?php echo $companyName;?>" placeholder="Title of Company">
            <span class="error"><?php echo $nameErr;?></span>
          </div>
        </div>
        
        <div class="box">
          <h4 class="center">Address</h4>

          <div class="row">
            <div class="col box">
              <h4 class="center">Shipping</h4>
                <div class="form-group">
                  <label for="shippingStreet">Street</label>
                  <input type="text" class="form-control" id="shippingStreet" name="shippingStreet" value="<?php echo $shippingStreet;?>" placeholder="123 Shipping St.">
                  <span class="error"><?php echo $shippingStreetErr;?></span>
                </div>

                <div class="form-group">
                  <label for="shippingCity">City</label>
                  <input type="text" class="form-control" id="shippingCity" name="shippingCity" value="<?php echo $shippingCity;?>" placeholder="Ship City">
                  <span class="error"><?php echo $shippingCityErr;?></span>
                </div>

                <div class="form-group">
                  <label for="shippingState">State</label>
                  <input type="text" class="form-control" id="shippingState" name="shippingState" value="<?php echo $shippingState;?>" placeholder="Ship State">
                  <span class="error"><?php echo $shippingStateErr;?></span>
                </div>

                <div class="form-group">
                  <label for="shippingZip">Zip Code</label>
                  <input type="text" class="form-control" id="shippingZip" name="shippingZip" value="<?php echo $shippingZip;?>" placeholder="12345">
                  <span class="error"><?php echo $shippingZipErr;?></span>                    
                </div>
            </div>

            <div class="col box">
              <h4 class="center">Billing</h4>

              <div class="form-group">
                <label for="billingStreet">Street</label>
                <input type="text" class="form-control" id="billingStreet" name="billingStreet" value="<?php echo $billingStreet;?>" placeholder="123 Billing St.">
                <span class="error"><?php echo $billingStreetErr;?></span>
              </div>

              <div class="form-group">
                <label for="billingCity">City</label>
                <input type="text" class="form-control" id="billingCity" name="billingCity" value="<?php echo $billingCity;?>" placeholder="Billing City">
                <span class="error"><?php echo $billingCityErr;?></span>
              </div>

              <div class="form-group">
                <label for="billingState">State</label>
                <input type="text" class="form-control" id="billingState" name="billingState" value="<?php echo $billingState;?>" placeholder="Billing State">
                <span class="error"><?php echo $billingStateErr;?></span>
              </div>

              <div class="form-group">
                <label for="billingZip">Zip Code</label>
                <input type="text" class="form-control" id="billingZip" name="billingZip" value="<?php echo $billingZip;?>" placeholder="12345">
                <span class="error"><?php echo $billingZipErr;?></span>
              </div>

              <div class="form-check center">
                <input type="checkbox" class="form-check-input" id="copyshipping" name="matched"  <?php if (isset($matched) && $quote == true) echo "checked";?>>
                <label class="form-check-label" for="copyshipping">Same as shipping Address</label>
              </div>
            </div>
          </div>
        </div>

        <div class="box">
          <div class="row">
            <div class="col box">
              <h4 class="center">Representative</h4>
              <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName;?>" placeholder="John">
                <span class="error"><?php echo $firstNameErr;?></span>
              </div>

              <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName;?>" placeholder="Smith">
                <span class="error"><?php echo $lastNameErr;?></span>
              </div>

              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" placeholder="johnsmith@email.com">
                <span class="error"><?php echo $emailErr;?></span>
              </div>

              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone;?>" placeholder="987-654-3210">
                <span class="error"><?php echo $phoneErr;?></span>
              </div>
            </div>

            <div class="col center box">
            <h4 class="center">Comments</h4>

          <div class="box">
              <div class="form-group">
                <textarea name="comment" class="form-control" value="<?php echo $comment;?>"  rows="14"></textarea>
              </div>
          </div>
              
            </div>
          </div>
        </div>

        <div class="box center">
        <h4>Quote Type</h4>
            <div class="row">
              <div class="col">
              <input type="radio" class="form-radio" name="quote" <?php if (isset($quote) && $quote =="auto") echo "checked";?> value="auto" id="auto" autocomplete="off" checked> 
              <label for="auto" class="form-radio-label">Auto</label>
              </div>
              <div class="col">
              <input type="radio" class="form-radio" name="quote" <?php if (isset($quote) && $quote =="manual") echo "checked";?> value="manual" id="manual" autocomplete="off"> 
              <label for="manual" class="form-radio-label">Manual</label>
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
