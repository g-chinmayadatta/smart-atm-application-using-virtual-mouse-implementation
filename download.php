<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$servername = "localhost";
    $username = "root";
    $password = "";
    $database="atm";
    // Create connection
    $conn = new mysqli($servername, $username, $password,$database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    session_start();
    if(isset($_SESSION['card_no'])){
        $cardno=$_SESSION["card_no"];
    }
$sql="SELECT * FROM temp WHERE CARD_NO = $cardno ORDER BY tmp_time DESC LIMIT 10 OUTPUT TO 'mini.txt' ";
mysqli_query($conn,$sql);
?>