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
session_start();
$cvv=$_SESSION['cvv'];
$sql="SELECT CARD_BALANCE FROM card WHERE card_cvv='$cvv'";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
if(isset($row["CARD_BALANCE"])){
    $bal=$row["CARD_BALANCE"];
}
else{
    echo"error";
}
?>
<html>
    <head>
        <style>
            section{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%;
    background: url('img/bgi.jpg')no-repeat;
    background-position: center;
    background-size: cover;
}
*{
    margin: 0;
    padding: 0;
    font-family: 'poppins',sans-serif;
}
.form-box{
    position: center;
    width: 500px;
    height: 500px;
    background: transparent;
    border: 2px solid white;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;}
button{
    width: 100%;
    height: 40px;
    border-radius: 40px;
    background: #fff;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 1em;
    font-weight: 600;
}
h1{
    font-size: 1.5em;
    color: #fff;
    text-align: center;
    position: bottom;
}
h2{
    font-size: 1.5em;
    color: #fff;
    text-align: center;
    position: bottom;
}
        </style>
    </head>
    <body>
    <section>
<div class="form-box" >
    <h2>
        Thank you for Banking with us <br>
         
    </h2><br><br>
  <h1>Your Account Balance is: <br><br> <?php echo $bal?></h1><br>
  <form action="index.html" method="post">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
  <center><button type="submit" class="button" id="balance" name="submit">Exit</button></center>
  </form>
  <br><br><br>
</div>
</section></body>
</html>