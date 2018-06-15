<!DOCTYPE html>
<html>
<head>
	<title>Library</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<h1>Library</h1>
	<div class="search">
<!-- 			<form action="#nexts" method="get">
			 <input type="text" placeholder="Enter" name="search">
		 	<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		
	 
 <table border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;" >
      <thead>
        <tr>
          <th>Employee_id</th>
          <th>Employee_Name</th>
          <th>Employee_dob</th>
          <th>Employee_Adress</th>
          <th>Employee_dept</th>
          <td>Employee_salary</td>
        </tr>
      </thead>
      <tbody>
 -->

<div id="next">
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
echo "Connected successfully";

// $name=$_GET["search"]

$name=$_GET["search"];
echo "asdsadasd     ".$name;
$sql = "SELECT ISBN10, title FROM main where title like '%".$name."%' OR ISBN10 like '%".$name."%' OR ISBN13 like '%".$name."%' OR author like '%".$name."%';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ISBN10"]. " - Name: " . $row["title"]. " " . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();

?> 
</div>




</body>
</html>