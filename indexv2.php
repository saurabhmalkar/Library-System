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
  <div class="search">
      <form action='indexv2.php' method="get">
       <input type="text" placeholder="Enter" name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
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
echo "Connected successfully";

// $name=$_GET["search"]

$name=$_GET["search"];
echo"<table cellspacing='0' border='1'>";
    echo "<tr>
        <th width='10%'>ISBN10</th>
       <th width='10%'>ISBN13</th> 
        <th width='60%'>Title</th>
        <th width='20%'>Authors</th>
        <th width='10%' >availability</th>
      </tr>";

if($name!="")
{
echo "<br><h3>The result for search ( ".$name." ):</h3>";
$sql = "SELECT ISBN10,ISBN13, title,available,authors FROM books_view where title like '%".$name."%' OR ISBN10 like '%".$name."%' OR ISBN13 like '%".$name."%' OR authors like '%".$name."%';";
$result = $conn->query($sql);


print json_encode($result);
// echo $result;
// <table style="width:100%">
//   <tr>
//     <th>Firstname</th>
//     <th>Lastname</th> 
//     <th>Age</th>
//   </tr>
//   <tr>
//     <td>Jill</td>
//     <td>Smith</td> 
//     <td>50</td>
//   </tr>
//   <tr>
//     <td>Eve</td>
//     <td>Jackson</td> 
//     <td>94</td>
//   </tr>
// </table>

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      if($row["available"])
      {
        $available="available";
        echo"<tr>";
        echo "<td width='10%'>" . $row["ISBN10"]."</td><td width='10%'>" . $row["ISBN13"]. "</td><td width='60%'>" . $row["title"]. "</td><td width='20%'>".$row["authors"]."</td>";
        echo "<td width='10%'>";
           echo " ".$available."<form action='checkoutv2.php' method='get'>
        checkout:<input type='hidden' name='check' value='".$row["ISBN13"]."'/> 
    <button type='submit'><i class='fa fa-search'></i></button>
      </form><td></tr>";
   
      }
      else
      {
        $available="Not available";
        echo"<tr>";

        echo "<td width='10%'>" . $row["ISBN10"]."</td><td width='10%'>" . $row["ISBN13"]. "</td><td width='60%'>" . $row["title"]. " </td><td width='20%'>".$row["authors"]. "</td>";
         echo "<td width='10%'>";
        echo $available."</td></tr>";

      }
        ;
      
    }
} else {
    echo "0 results";
}}
$conn->close();

?> 
</table>
</div>

<


</body>
</html>