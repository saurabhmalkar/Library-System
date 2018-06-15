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
	<h2> Fines</h2>
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


		<?php
		$servername = "localhost";
		$username = "root";
		$password = "Taurus@07";
		$dbname = "books";

// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
echo"<table cellspacing='0' border='1'>";
    echo "<tr>
        <th width='25%'>LOAN_ID</th>
       <th width='25%'>ISBN13</th> 
        <th width='25%'>Title</th>
       <th width='25%'>paid</th>
      </tr>";

// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$loan_id=$_GET["loan_id"];
		if($loan_id=="")
		{
			$sql="SELECT Loan_ID,ISBN13, IFNULL(DATEDIFF(date_in, due_date), DATEDIFF(curdate(),due_date)) as Days FROM BOOK_LOANS WHERE Due_date < curdate();";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
    // output data of each row
				while($row = $result->fetch_assoc()) {

					$fine=$row["Days"]*0.25;
					$ze="0";
					$sql1="INSERT INTO FINES (LOAN_ID,FINE_AMT,PAID) VALUES (".$row["Loan_ID"].",".$fine.",".$ze.");";
						// $sql1="INSERT INTO FINES (LOAN_ID,FINE_AMT,PAID) VALUES ("+$row["Loan_ID"]+","+$fine+","+0+");"
					$result1= $conn->query($sql1);
					// 	if (!$result1) {
					// 	throw new Exception($mysqli->error);
					// }

					$sql2="UPDATE FINES SET FINE_AMT = CASE WHEN PAID <> '1' THEN ".$fine." ELSE FINE_AMT END WHERE LOAN_ID = ".$row["Loan_ID"].";";
					$result2= $conn->query($sql1);
					$sql3="SELECT PAID from FINES where Loan_id=".$row["Loan_ID"].";";
					$result3=$conn->query($sql3);
					$row_no=$result3->num_rows;
					if($result3->num_rows>0){
						while($row3=$result3->fetch_assoc()){
							$paid=$row3["PAID"];

						}
					}

					// 	if (!$result2) {
					// 	throw new Exception($mysqli->error);
					// }


					echo "<tr><td width='25%'>" . $row["Loan_ID"]."</td><td width='25%'>" . $row["ISBN13"]. "</td><td width='25%'> ". $fine."</td>";
					if($paid!='1')
					{
					echo "<td width='25%'><form action='fines.php' method='get'>
					Pay fine:<input type='hidden' name='loan_id' value='".$row["Loan_ID"]."'/> 
					<button type='submit'><i class='fa fa-search'></i></button>
					</form></td></tr>";
				}
				else
				{
					echo"<td width='25%'> PAID</td></tr>";
				}

				}
			}
		}


		else
		{

			$sql="UPDATE FINES SET paid ='1' WHERE LOAN_ID = ".$loan_id.";";
			$conn->query($sql);
echo"Fine paid";
		}


		?>

</body>
</html>