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
<title>Manager Login</title>
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
  $userEmail = $userPassword = "";
  $emailErr = $passwordErr = "";
  $error = $feedback = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
      $emailErr = "Email is required.";
    } else {
      $userEmail = test_input($_POST["email"]);
    }

    if (empty($_POST["password"])) {
      $passwordErr = "Password is required.";
    } else {
      $userPassword = test_input($_POST["password"]);
    }
    
    /***************** SQL CODE *****************/	
    if(empty($emailErr) && empty($passwordErr)) {

      // Search in Manager table for email matching email from form.
      // If found email
      // set $email and $password

      $sql = "SELECT ManagerID, Email, Password FROM Manager WHERE Email LIKE ('$userEmail')";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if ($userEmail == $row["Email"] && $userPassword == $row["Password"]) {
            session_start();
            $_SESSION['managerId'] = $row['ManagerID'];
            $_SESSION['managerEmail'] = $row['Email'];
            header("Location: /~z1819675/RequestForQuote/createCustomer.php");
          } else {
            echo "Invalid Password.";
          }
        }
      } else {
        echo "Invalid Email";
      }

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
          <a class="nav-link" href="#">Log In<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./createCustomer.php">Create Customer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./createPart.php">Create Part</a>
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
          <h2 class="center">Manager Login</h2>
        </div>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="box">
          <div class="form-group">
            <label for="companyName">Manager E-Mail</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $userEmail;?>" placeholder="dudeguy@email.com">
            <span class="error"><?php echo $emailErr;?></span>
          </div>
          <div class="form-group">
            <label for="companyName">Manager Password</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $userPassword;?>" placeholder="********">
            <span class="error"><?php echo $passwordErr;?></span>
          </div>
        </div>
        <div class="box center">
          <span class="feedback"><?php echo $feedback;?></span>
          <span class="error"><?php echo $error; ?></span>
          <div class="row">
            <div class="col-6 center">
              <button type="reset" name="cancel" class="btn btn-secondary btn-lg">Reset</button>
            </div>

            <div class="col-6 center">
              <button type="submit" class="btn btn-primary btn-lg">Login</button>
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
