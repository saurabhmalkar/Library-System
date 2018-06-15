<!DOCTYPE html>
<html>
<head>
	<title>Library</title>
	  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Library</h1>
	      <div class="leftside">
            <div id="linkLeft">
              <ul>
                <li><a href="indexv2.php">Homepage</a></li>
                <li><a href="register.php">Register new borrower</a></li>
                <li><a href="Checkin.php">Checkin books</a></li>
                <li><a href="fines.php">Fines</a></li>
                </ul>
          </div>
</div>
	<div class="check">
		<h3>You are checking in</h3>
		<div class="checkin">
			<form action='checkin.php' method="get">
				Enter ISBN13 or name of the book or borrow id<input type="text" placeholder="Enter ISBN13 of the book you wish to checkin" name="check">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>  
</div>

		<?php
		$servername = "localhost";
		$username = "root";
		$password = "Taurus@07";
		$dbname = "books";

// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$check=$_GET["check"];
		$ISBN13=$_GET["ISBN13"];
		if($ISBN13=="")
		{
		echo"<table cellspacing='0' border='1'>";
    	echo "<tr>
        <th width='20%'>Loan Id</th>
       <th width='20%'>ISBN13</th> 
        <th width='20%'>Borrow Id</th>
        <th width='20%'>Check out Date</th>
        <th width='20%' >Due Date</th>
        <th width='20%'>Check In</th>
      </tr>";
}
		if($ISBN13==""){
			if($check=="")
			{

				$sql="select * from book_loans;";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
    // output data of each row
					while($row = $result->fetch_assoc()) {
						echo"<tr>";
						echo "<td width='20%'>" . $row["loan_id"]."</td><td width='20%'>" . $row["ISBN13"]. "</td><td width='20%'>" . $row["borrow_id"]. "</td><td width='20%'>".$row["date_out"] . "</td><td width='20%'>".$row["due_date"]."</td><td width='20%'>";
						echo "<form action='checkin.php' method='get'>
						Checkin:<input type='hidden' name='ISBN13' value='".$row["ISBN13"]."'/> 
						<button type='submit'><i class='fa fa-search'></i></button>
						</form></td></tr>";
		

						$con1=date_diff($row["due_date"],date("Y-m-d"));
					}
				}
			}

			else
			{
				$sql="select * from book natural join book_loans where isbn13 like '%".$check."%' or title like '%".$check."%' or borrow_id like '%".$check."%';";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
    // output data of each row
					while($row = $result->fetch_assoc()) {

						echo"<tr>";
						echo "<td width='20%'>" . $row["loan_id"]."</td><td width='20%'>" . $row["ISBN13"]. "</td><td width='20%'>" . $row["borrow_id"]. "</td><td width='20%'>".$row["date_out"] . "</td><td width='20%'>".$row["due_date"]."</td><td width='20%'>";
						echo "<form action='checkin.php' method='get'>
						Checkin:<input type='hidden' name='ISBN13' value='".$row["ISBN13"]."'/> 
						<button type='submit'><i class='fa fa-search'></i></button>
						</form></td></tr>";

						// $con1=date_diff($row["due_date"],date("Y-m-d"));
						// echo "<br>date diff:".$con1;
					
					}
				}

			}
		}


		else{
			
			$sql="UPDATE book_loans SET date_in ='".date("Y-m-d")."' WHERE ISBN13 = ".$ISBN13.";";

			$conn->query($sql);

			echo"the book is checked out";
		}
		







		?>

</body>
</html>