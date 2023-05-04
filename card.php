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
    if(isset($_POST['card_cvv'])){
    $ucard_no=$_POST["card_no"];
    $ucvv=$_POST["card_cvv"];
    $sql="SELECT card_no,CARD_BALANCE FROM card WHERE card_cvv=$ucvv";
    $result = $conn->query($sql);
    if (!$result) {
        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
        exit;
    }
    $row=$result->fetch_assoc();
    session_start();
    $_SESSION['cvv']=$_POST['card_cvv'];
    if(isset($row["card_no"])){
        $_SESSION['card_no']=$_POST['card_no'];
        if($row["card_no"]==$ucard_no){
            header("location:option.php");
        }
        if($row["card_no"]!=$ucard_no){
            echo '
            <head>
            <link rel="stylesheet" href="withdrawal.css">
            </head><section>
            <div class=" form-box">
            <h1>Please Enter correct card details</h1><br>
            <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/index.html\'">retry</button></div>
            </section>
            ';
        }
    }
    else{
        echo'
        <head>
        <link rel="stylesheet" href="withdrawal.css">
        </head><section>
        <div class=" form-box">
        <h1>Please Enter correct CVV </h1><br>
        <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/index.html\'">retry</button></div>
        </section>
        ';
    }
    }
    $conn->close();
?>