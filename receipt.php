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
    $sql="SELECT * from temp ORDER BY tmp_time DESC LIMIT 1";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $utra_id=$row["TRANSACTION_ID"];
    $sql2="SELECT CARD_BALANCE,card_no FROM card WHERE card_cvv='$cvv'";
    $result2=$conn->query($sql2);
    $row2=$result2->fetch_assoc();
    if(isset($row2['card_no'])){
        $ucard_no=$row2['card_no'];
        $sql3="SELECT cid FROM customer WHERE c_cno='$ucard_no'";
        $result3=$conn->query($sql3);
        $row3=$result3->fetch_assoc();
        if(isset($row3['cid']))
        {
            $ucard_id=$row3['cid'];
            $sql4="SELECT ac_no FROM account WHERE ac_id='$ucard_id'";
            $result4=$conn->query($sql4);
            $row4=$result4->fetch_assoc();
        }
        $sql5="SELECT * FROM transaction where transaction_id=$utra_id";
        $result5=$conn->query($sql5);
        $row5=$result5->fetch_assoc();
    }
    if ($result->num_rows > 0){
        $utra_id=$row['TRANSACTION_ID'];
        $utra_type=$row5["Transaction_type"];
        $utra_status=$row5["Transaction_status"];
        $uamount=$row['AMOUNT'];
        $utime=$row['tmp_time'];
        $avil=$row2['CARD_BALANCE'];
        $uacc_no=$row4['ac_no'];
    }
?>
<html>
    <head>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
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
            width: 550px;
            height: 670px;
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
        .submit{
            font-size: .9em;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }
        .submit p a{
            text-decoration: none;
            color: #fff;
            font-weight: 600;
        }
        table{
          border: 1px solid white;
          border-collapse: collapse;
          text-align:center;
          color:white;
          width: 75%;
          height: 300px;
        }
        th,td{
            border: 1px solid white;
            width: 200px;
        }
        .submit p a:hover{
            text-decoration: underline;
        }
      </style>
    <head>
    <body>
    <section>
<div class="form-box" >
<table id="receipt">
    <tr><th colspan=2>UCEN BANK</th></tr>
  <tr>
    <td>Account No</td>
    <td>*********** <?php echo substr($uacc_no,-4)?></td>
  </tr>
  <tr>
    <td>Transaction Id</td>
    <td><?php echo $row['TRANSACTION_ID'];?></td>
  </tr>
  <tr>
    <td>Transaction type</td>
    <td><?php echo $utra_type?></td>
  </tr>
  <tr>
    <td>Transaction status</td>
    <td><?php echo $utra_status?></td>
  </tr>
  <tr>
    <td>Transaction Amount</td>
    <td><?php echo $uamount?></td>
  </tr>
  <tr>
    <td>Time of Transaction</td>
    <td><?php echo $utime?></td>
  </tr>
  <tr>
    <td>Available Amount</td>
    <td><?php echo $avil?></td>
  </tr>
</table><br>
    <button name="download" class="button"  type="submit" onclick="exportTableToExcel('receipt', 'receipt')">Download</button><br><br>
    <button type="submit" class="button" onclick="window.location.href='index.html'">Exit</button>
  <br><br><br>
</div>
</section>
<script>
    function exportTableToExcel(tableID, filename = '') {
			var downloadLink;
			var dataType = 'application/vnd.ms-excel';
			var tableSelect = document.getElementById(tableID);
			var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
			filename = filename ? filename + '.xls' : 'excel_data.xls';
			downloadLink = document.createElement('a');
			document.body.appendChild(downloadLink);
			if (navigator.msSaveOrOpenBlob) {
				var blob = new Blob(['\ufeff', tableHTML], {type: dataType});
				navigator.msSaveOrOpenBlob(blob, filename);
			} else {
				downloadLink.href = 'data:' + dataType + ',' + tableHTML;
				downloadLink.download = filename;
				downloadLink.click();
			}
		}
        </script>
    </body>
</html>