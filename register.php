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
	<h1>New User</h1>
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
	<div id="newuser">
<table>
		<form action='register.php' method="post">
			<tr><td>First Name: <input type="text" placeholder="eg. John" name="Fname"><br></td></tr>
			<tr><td>Last Name:<input type="text" placeholder="eg. Smith" name="Lname"><br></td></tr>
			<tr><td>SSN:<input type="text" placeholder="123-45-6789" name="ssn"><br></td></tr>
			<tr><td>Email:<input type="text" placeholder="johnsmith@gmail.com" name="email"><br></td></tr>
			<tr><td>Address:<input type="text" placeholder="Street name" name="addr"><br></td></tr>
			<tr><td>City:<input type="text" placeholder="Dallas" name="city"><br></td></tr>
			<tr><td>State:<input type="text" placeholder="TX" name="state"><br></td></tr>
			<tr><td>Phone:<input type="text" placeholder="(123) 456-7890" name="phone"><br></td></tr>


			<tr><td><button type="submit"><i>SUBMIT</i></button></td></tr>
			</table>
		</form>
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

	$fname=$_POST["Fname"];
	$lname=$_POST["Lname"];
	$ssn=$_POST["ssn"];
	$email=$_POST["email"];
	$addr=$_POST["addr"];
	$city=$_POST["city"];
	$state=$_POST["state"];
	$phone=$_POST["phone"];
	if($fname!="" && $lname!="" && $ssn!="" && $email!="" && $addr!="" && $city!="" && $state!="" && $phone!="")
	{
		echo "First Name:".$fname;
		echo "<br>Last Name:".$lname;
		echo "<br>SSN:".$ssn;
		echo "<br>email:".$email;
		echo "<br>Address:".$addr;
		echo "<br>City:".$city;
		echo "<br>State:".$state;
		echo "<br>Phone:".$phone;

		$sql="select max(borrow_id) as borrow_id from borrower;";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    // output data of each row
			while($row = $result->fetch_assoc()) {
				$borrow_id=$row["borrow_id"];
			}
		} else {
			echo "0 results";
		}
		$sql="select ssn from borrower where ssn='".$ssn."';";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    // output data of each row
	 echo "<script>
window.location.href='indexv2.php';
alert('User already exists in the system');
</script>";
		}
		else
		{

			$borrow_id=$borrow_id+1;
			$sql="INSERT INTO borrower (borrow_id, ssn, first_name,last_name,email,address,city,state,phone) VALUES ('".$borrow_id."','".$ssn."','".$fname."','".$lname."','".$email."','".$addr."','".$city."','".$state."','".$phone."');";
			echo"<br>borrow_id :".$borrow_id."<br><br>";



			$result = $conn->query($sql);

			echo"user is successfully registered";




		}

	}
	else
	{
		Echo"please enter all the information and all fields are compulsory";
	}
	$conn->close();
	?>

	<br><br>
	<div class="redirect">
		<form action='indexv2.php' method="get">
			Go to book search page:
			<button type="submit"><i>Back</i></button>
		</form>
	</div>
</body>
</html>

