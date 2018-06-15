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



$sql = "SELECT ISBN10, title FROM main where title like '%T'";
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