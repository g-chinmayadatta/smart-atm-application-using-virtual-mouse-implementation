<?php
    $uwithdraw=$_POST["uwithdraw_amount"];
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
    $cvv=$_SESSION["cvv"];
    $sql="SELECT CARD_BALANCE,card_no FROM card WHERE card_cvv=$cvv";
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();
    if(isset($row["CARD_BALANCE"])){
        $avil=$row["CARD_BALANCE"];
        $ucard_no=$row["card_no"];
        if($avil>=$uwithdraw){
            $avil=$avil-$uwithdraw;
            $sql2="UPDATE card SET CARD_BALANCE = '$avil' WHERE CARD_CVV = '$cvv'";
            $result2 = $conn->query($sql2);
            $id=uniqid(mt_rand(),true);
            date_default_timezone_set('Asia/Kolkata');
            $time=date("Y-m-d H:i:s");
            $sql7="INSERT INTO transaction(TRANSACTION_ID,TRANSACTION_NAME,TRANSACTION_STATUS,TRANSACTION_TYPE,tr_time) VALUES ('$id','WITHDRAW','COMPLETED','WITHDRAW','$time')";
            $result7 = $conn->query($sql7);
           /* if (!$result7) {
                echo "Could not successfully run query ($sql7) from DB: " . mysql_error();
                exit;
            }*/

            $sql8="INSERT INTO temp(TRANSACTION_ID,CARD_NO,AMOUNT,tmp_time,transaction_type) VALUES ('$id','$ucard_no','$uwithdraw','$time','WITHDRAW')";
            $result8 = $conn->query($sql8);
           /* if (!$result8) {
                echo "Could not successfully run query ($sql8) from DB: " . mysql_error();
                exit;
            }*/
            header("location:receipt.php");
        }
        else{
            echo '
            <head>
            <link rel="stylesheet" href="withdrawal.css">
            </head><section>
            <div class=" form-box">
            <h1>Your balance is insufficient</h1><br><br>
            
            <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/option.php\'">Retry</button></div>
            </section>
            ';
        }
        
    }
    

    $conn->close();
?>
