<!DOCTYPE html>
<html>
<head>
  <title>Library</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <h1>Library</h1>
  <div class="check">
    <h3>You are checking out</h3>

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

// $name=$_GET["search"]

$check=$_GET["check"];
$sql = "SELECT title FROM books_view where ISBN13 like '%".$check."%';";

$result = $conn->query($sql);
$borrowid=$_GET["borrowid"];

if($borrowid!=""){
$sql1= "SELECT borrow_id,first_name,last_name FROM borrower where borrow_id=".$borrowid.";";
$result_bor=$conn->query($sql1);

if ($result_bor->num_rows > 0) {
    // output data of each row
    while($row = $result_bor->fetch_assoc()) {
        echo "Name: " . $row["first_name"]. " " . "<br>";

        $borrow_id=$row["borrow_id"];
    }
} else {
    echo "borrower is not registered in system";
    $borrow_id=0;
}
}


if($borrowid==""){
     echo" <div class='borrow'>
      <form action='checkoutv2.php' method='get'>
       Enter borrow id :<input type='text' placeholder='Enter' name='borrowid'>
       <input type='hidden' name='check' value='".$check."'/> 
      <button type='submit'><i class='fa fa-search'></i></button>
      </form>
  </div> "; 
}
   




if($borrow_id!=0){
   echo"borrowid is ".$borrowid."<br> the book you are checking out is :";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["title"]. " " . "<br>";
    }
} else {
    echo "0 results";
}


$sql = "UPDATE book SET available=0 WHERE ISBN13='".$check."';";

$conn->query($sql);

echo"<br>the checking date for this book is :".date("Y-m-d")."<br>";

$d=strtotime("+14 Days");
echo"the return date fr this book is :".date("Y-m-d", $d) . "<br>";
}

else
{
  echo "<br><br>Do you wish register?<br><br>";
    echo" <div class='register'>
      <form action='register.php' method='get'>
       Click on the button if you wish to register :
       <input type='hidden' name='check' value='".$check."'/> 
      <button type='submit'><i class='fa fa-search'></i></button>
      </form>
  </div> ";




}
$conn->close();
?> 






</body>
</html>