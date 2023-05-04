<?php
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
$sql = "SELECT otp FROM otp ORDER BY time DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Get the most recent OTP value
  $row = mysqli_fetch_assoc($result);
  $most_recent_otp = $row["otp"];

  
}

if(isset($_POST["uotp_verify"]))
{
	$uotp=$_POST["verify_otp"];
    if ($uotp == $most_recent_otp){
        session_start();
        $option=$_SESSION['option'];
        $url=$option.".html";
        header("location:".$url);
        
    }
    else{
        echo '
            <head>
            <link rel="stylesheet" href="withdrawal.css">
            </head><section>
            <div class=" form-box">
            <h1>Please Enter Correct OTP</h1><br><br>
            
            <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/option.php\'">Retry</button></div>
            </section>
            ';
    }

}
?>