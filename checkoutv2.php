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
	<div class="check">
    <h3>You are checking out</h3>
  </div>
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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $name=$_GET["search"]

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}



function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}


$check=$_GET["check"];
$ISBN13=$check;
$sql = "SELECT title,available FROM books_view where ISBN13 like '%".$check."%';";

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

        $sql2="SELECT count(*) as c from book_loans where borrow_id=".$borrow_id.";";
        $result2=$conn->query($sql2);
        if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {
        $no_times=$row2["c"];
    }
} else {
    echo "0 results";
}
    }
} else {
  echo"<div id='not_reg'>";
    echo "borrower is not registered in system";
    echo"</div>";
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
  if($no_times<3)
{
   echo"borrowid is ".$borrowid."<br> the book you are trying checking out is :";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["title"]. " " . "<br>";
        $avai=$row["available"];

    }
} else {
    echo "0 results";
}
if($avai!=0){
$d1=strtotime("+14 Days");
$date_out=date("Y-m-d");
$due_date=date("Y-m-d", $d1);
$sql = "UPDATE book SET available=0 WHERE ISBN13='".$check."';";



$conn->query($sql);

$sql="insert into book_loans (ISBN13,borrow_id,date_out,due_date) values (".$ISBN13.",".$borrow_id.",'".$date_out."','".$due_date."');";
$conn->query($sql);

echo"<br>the checking date for this book is :".date("Y-m-d")."<br>";

$d=strtotime("+14 Days");
echo"the return date for this book is :".date("Y-m-d", $d) . "<br>";
}
else
{
  // phpAlert(   "The book is already checked out"   );

  // Redirect('indexv2.php', false);

  echo "<script>
window.location.href='indexv2.php';
alert('The book is already checked out');
</script>";


}
}
else{

    echo "<script>
window.location.href='indexv2.php';
alert('You have already borrowed 3 books and you cannot borrow anymore');
</script>";
}
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