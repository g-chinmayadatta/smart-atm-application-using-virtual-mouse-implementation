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
    if(isset($_SESSION['option']))
    {
    $uoption=$_SESSION['option'];
    }

    $sql="SELECT card_no FROM card WHERE card_cvv=$cvv";
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();
    $ucard_no=$row["card_no"];

    $id=uniqid(mt_rand(),true);
    date_default_timezone_set('Asia/Kolkata');
    $time=date("Y-m-d H:i:s");
    $sql7="INSERT INTO transaction(TRANSACTION_ID,TRANSACTION_NAME,TRANSACTION_STATUS,TRANSACTION_TYPE,tr_time) VALUES ('$id','$uoption','FAILED','$uoption','$time')";
    $result7 = $conn->query($sql7);
    if (!$result7) {
        echo "Could not successfully run query ($sql7) from DB: " . mysql_error();
        exit;
    }
    $sql5="SELECT * FROM transaction ORDER BY tr_time DESC LIMIT 1";
    $result5=$conn->query($sql5);
    $row5=$result5->fetch_assoc();
    $sql3="SELECT cid FROM customer WHERE c_cno='$ucard_no'";
    $result3=$conn->query($sql3);
    $row3=$result3->fetch_assoc();
    if(isset($row3['cid']))
    {
        $ucard_id=$row3['cid'];
        $sql4="SELECT ac_no FROM account WHERE ac_id='$ucard_id'";
        $result4=$conn->query($sql4);
        $row4=$result4->fetch_assoc();
        $uacc_no=$row4["ac_no"];
        $utra_id=$row5['transaction_id'];
        $utra_type=$row5["Transaction_type"];
        $utra_status=$row5["Transaction_status"];
        $utime=$row5['tr_time'];
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
                height: 550px;
                background: transparent;
                border: 2px solid white;
                border-radius: 20px;
                backdrop-filter: blur(15px);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;

            }
            h2{
                font-size: 1.5em;
                color: #fff;
                text-align: left;
                position: bottom;
            }
            button{
                width: 30%;
                height: 40px;
                border-radius: 40px;
                background: #fff;
                border: none;
                outline: none;
                cursor: pointer;
                font-size: 1em;
                font-weight: 600;
            }  
            table{
            border: 1px solid white;
            border-collapse: collapse;
            text-align:center;
            color:white;
            width: 90%;
            height: 300px;
            }
            th,td{
                border: 1px solid white;
                width: 200px;
            }  
        </style>
    </head>
    <section>
        <div class="form-box" >
            <div class="container">
            <center>
            <table id="receipt">
                <tr><th colspan=2>UCEN BANK</th></tr>
                <tr>
                    <td>Account No</td>
                    <td>*********** <?php echo substr($uacc_no,-4);?></td>
                </tr>
                <tr>
                    <td>Transaction Id</td>
                    <td><?php echo $utra_id;?></td>
                </tr>
                <tr>
                    <td>Transaction type</td>
                    <td><?php echo strtoupper($utra_type);?></td>
                </tr>
                <tr>
                    <td>Transaction status</td>
                    <td><?php echo $utra_status;?></td>
                </tr>
                <tr>
                    <td>Time of Transaction</td>
                    <td><?php echo  $utime; ?></td>
                </tr>
                </table><br>
                <button type="submit" class="button" id="balance" name="submit" onclick="window.location.href='index.html'">Exit</button>
                </center>
    </div>
    </section>
</html>