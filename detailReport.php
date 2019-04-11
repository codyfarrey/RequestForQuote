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
        //Getting all of our data from the Create Report Screen and saving to local variables
        session_start();
        //$report = $_SESSION["report"];
       // $startDate = $_SESSION["startDate"];
        //$endDate = $_SESSION["endDate"];
       // $content = $_SESSION["content"];
      ?>
    </head>
    <body>
      <?php
        //Printing all of the data from Create Report Screen to show that I have it
        //Remove this on submission
        ///echo $report;
        //echo $startDate;
        //echo $endDate;
        //echo $content;
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
              <h2 class="center">RFQ Detail Report</h2>
            </div>
          </div>

          <table class="table">
          <?php
            $sql = "SELECT DISTINCT RFQ.RFQID, CustomerAccount.AccountNumber, 
            Inventory.PartID, RFQDetail.DateRequired, Inventory.Price 
	    FROM RFQ, CustomerAccount, Inventory, RFQDetail";
	    $result = $conn->query($sql);


            echo '<thead>';
            
	                //Create table with PHP HERE
	    echo '</thead>';
	    $conn = null;
	  ?>
          </table>

          <form id="rfqForm" method="POST">
          <div class="box center">
            <h4>Report</h4>
            	<div class="box">
	  <table class="striped">
            <tr class="header">
                <td>Request Id</td>
                <td>Account Number</td>
		<td>Part Id</td>
		<td>Date Required</td>
		<td>Price</td>
            </tr>
	<?php
	    while ($row = $result->fetch_assoc()) 
	    {
		echo "<tr>";
		echo "<td>".$row["RFQID"]."</td>";
		echo "<td>".$row["AccountNumber"]."</td>";
		echo "<td>".$row["PartID"]."</td>";
		echo "<td>".$row["DateRequired"]."</td>";
		echo "<td>".$row["Price"]."</td>";
		echo "</tr>";
	    }
	?>
        </table> 

		
		</div>
          </div>
          <div class="box center">
              <span class="feedback"><?php //echo $feedback;?></span>
              <span class="error"><?php //echo $error; ?></span>
              <div class="row">
                <div class="col-6 center">
                  <button type="reset" name="cancel" class="btn btn-secondary btn-lg">Cancel</button>
                </div>

                <div class="col-6 center">
                  <button type="submit" form="rfqForm" class="btn btn-primary btn-lg">Print</button>
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
