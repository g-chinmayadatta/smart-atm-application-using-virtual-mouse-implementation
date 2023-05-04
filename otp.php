<html>
<?php
// Include the PHPMailer library
require_once "PHPMailer-master/src/PHPMailer.php";
require_once "PHPMailer-master/src/SMTP.php";
require_once "PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('Asia/Kolkata');

// Generate a random 4-digit OTP
$otp = rand(1000, 9999);
$time=date("Y-m-d H:i:s");
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
if(isset($_SESSION['cvv'])){
    $cvv=$_SESSION['cvv'];
}
$sql="SELECT email FROM card  WHERE  card_cvv='$cvv'";
$result = $conn->query($sql);
if (!$result) 
{
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}
$row=$result->fetch_assoc();
$email=$row['email'];
echo $time;
$sql2="INSERT INTO otp (otp,time) VALUES ('$otp','$time')";
$result2=$conn->query($sql2);
if (!$result2) {
    echo "Could not successfully run query ($sql2) from DB: " . mysql_error();
    exit;
}
// User's email address

// SMTP settings for Gmail
$smtpHost = "smtp.gmail.com";
$smtpUsername = "ucen.atm@gmail.com";
$smtpPassword = "hbzxakencsisfdhq";
$smtpPort = 587;

// Create a new PHPMailer instance
$mail = new PHPMailer();

try {
    // Configure PHPMailer with SMTP settings
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $smtpPort;

    // Set email message data
    $mail->setFrom($smtpUsername, 'UCEN-ATM');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Hello user';
    $mail->Body = 'Your OTP is: ' . $otp;

    // Send email
    if ($mail->send()) {
        header("Location:u_otp.html");

    } else {
        echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
}
?>
</html>