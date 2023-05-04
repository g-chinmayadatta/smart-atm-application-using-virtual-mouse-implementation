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
    if(isset($_SESSION['cvv']))
    {
    $cvv=$_SESSION['cvv'];
    }
    if(isset($_POST["utransfer_account"]))
    {
        $uacc_no=$_POST["utransfer_account"];
    }
    //echo $uacc_no."<br>";
    if(isset($_POST["utransfer_amount"]))
    {
        $utransfer_amount=$_POST["utransfer_amount"];   
    }
    if(isset($_SESSION['card_no'])){

        $cardno=$_SESSION["card_no"];
    }
    $sql="SELECT ac_id FROM account WHERE ac_no='$uacc_no'";
    $result = mysqli_query($conn, $sql);
    $row=$result->fetch_assoc();
    if(!isset($row["ac_id"])){
        $message="please enter correct account no";
        echo "<script>alert('$message')</script>";
        echo '
        <head>
        <link rel="stylesheet" href="withdrawal.css">
        </head><section>
        <div class=" form-box">
        <h1>please enter correct details</h1><br>
        <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/option.php\'">retry</button></div>
        </section>
        ';
    }
    if(isset($row["ac_id"]))
    {
        $cid=$row["ac_id"];
        //echo"<br> c_id is $cid<hr>";
        $sql2="SELECT * FROM customer WHERE cid='$cid'";
        $result2 = $conn->query($sql2);
        $row2=$result2->fetch_assoc();
        if(isset($row2["c_cno"])){
            $cno=$row2["c_cno"];
            $_SESSION["rename"]=$row2["fname"];
            //echo $row2['fname'];
            //echo"<br>card no is  $cid<hr>";
            if($cardno==$row2["c_cno"]){
                echo '
                <head>
                <link rel="stylesheet" href="withdrawal.css">
                </head><section>
                <div class=" form-box">
                <h1>Self Transfer is not supported</h1><br>
                <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/option.php\'">retry</button></div>
                </section>
                ';
                exit();
            }
            else{
                $sql3="SELECT CARD_BALANCE FROM card WHERE card_no='$cno'";
                $result3 = $conn->query($sql3);
                $row3=$result3->fetch_assoc();
                $bal=$row3["CARD_BALANCE"];
                $sql4="SELECT CARD_BALANCE,card_no FROM card WHERE card_cvv='$cvv'";
                $result4=$conn->query($sql4);
                $row4=$result4->fetch_assoc();
                $ubal=$row4["CARD_BALANCE"];
                $ucard_no=$row4["card_no"];
            }
            //echo"<br>amount in the account is $bal<hr>";
            //echo"<br>amount in the user account is $ubal<hr>";
            if($utransfer_amount<=$ubal){
                $ubal-=$utransfer_amount;
                $bal+=$utransfer_amount;
                //echo" updated balance is $bal<br><hr>";
                //echo "updated user balance is $ubal";
                $sql5="UPDATE card SET CARD_BALANCE ='$ubal' WHERE card_cvv='$cvv'";
                $result5 = $conn->query($sql5);
                if (!$result5) {
                    echo "Could not successfully run query ($sql5) from DB: " . mysql_error();
                    exit;
                }
                $sql6="UPDATE card SET CARD_BALANCE='$bal' WHERE card_no='$cid'";
                $result6 = $conn->query($sql6);
                if (!$result6) {
                    echo "Could not successfully run query ($sql6) from DB: " . mysql_error();
                    exit;
                }
                //echo "<br>updated and inserted into database";
                $id=uniqid(mt_rand(),true);
                date_default_timezone_set('Asia/Kolkata');
                $time=date("Y-m-d H:i:s");
                $sql7="INSERT INTO transaction(TRANSACTION_ID,TRANSACTION_NAME,TRANSACTION_STATUS,TRANSACTION_TYPE,tr_time) VALUES ('$id','transfer','COMPLETED','TRANSFER','$time')";
                $result7 = $conn->query($sql7);
                if (!$result7) {
                    echo "Could not successfully run query ($sql7) from DB: " . mysql_error();
                    exit;
                }
                $sql8="INSERT INTO temp(TRANSACTION_ID,CARD_NO,AMOUNT,tmp_time,transaction_type) VALUES ('$id','$ucard_no','$utransfer_amount','$time','TRANSFER')";
                $result8 = $conn->query($sql8);
                if (!$result8) {
                    echo "Could not successfully run query ($sql8) from DB: " . mysql_error();
                    exit;
                }
               header("location:tr_receipt.php");
            }
            else{
                
                echo '
                <head>
                <link rel="stylesheet" href="withdrawal.css">
                </head><section>
                <div class=" form-box">
                <h1>You have insufficient balance in your Account</h1><br>
                <button class="button" onclick="window.location.href=\'http://127.0.0.1/project/option.php\'">retry</button></div>
                </section>
                ';
            }

        }
    }else{
        $message="please enter correct account number";
        echo"<script>alert('$message')</sctipt>";
    }
?>