<?php
    date_default_timezone_set('Asia/Kolkata');
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
    if(isset($_SESSION['card_no'])){

        $cardno=$_SESSION["card_no"];
    }
    $sql="SELECT * FROM temp WHERE CARD_NO = $cardno ORDER BY tmp_time DESC LIMIT 10";
    $result = $conn->query($sql);
    if (!$result) {
        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
        exit;
    }
    $sql2="SELECT CARD_BALANCE,card_no FROM card WHERE card_no=$cardno";
    $result2 = $conn->query($sql2);
    $row2=$result2->fetch_assoc();
    if(isset($row2["CARD_BALANCE"])){
        $avil=$row2["CARD_BALANCE"];
    }
    
    $sql3="SELECT cid FROM customer WHERE c_cno=$cardno";
    $result3 = $conn->query($sql3);
    $row3=$result3->fetch_assoc();
    if(isset($row3["cid"])){
        $cid=$row3["cid"];
    }
    //echo $cid;
    $sql4="SELECT ac_no FROM account WHERE ac_id='$cid'";
    $result4 = $conn->query($sql4);
    $row4=$result4->fetch_assoc();
    if(isset($row4["ac_no"])){
        $accno=$row4["ac_no"];
    }
    //echo $accno;
    date_default_timezone_set('Asia/Kolkata');
    $time=date("Y-m-d H:i:s");
    
?>
<html>
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
        height: 800px;
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
        width: 100px;
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

    .submit p a:hover{
        text-decoration: underline;
    }
    table{
    border: 1px solid white;
    border-collapse: collapse;
    text-align:center;
    color:white;
    width: 95%;
    height: 300px;
    }
    th,td{
        border: 1px solid white;
        width: 200px;
    }
</style>
    <body>
        <section>
        <div class="form-box">
            <div class="container">
            <center>
                <table id="mini">
                <tr>
                    <th colspan=3>UCEN BANK</th>
                </tr>
                <tr>
                    <th colspan=3>Card No <?php echo $cardno;?> </th>
                </tr>
                <tr>
                    <th colspan=3>Time <?php echo $time?></th>
                </tr>
                <tr>
                    <th colspan=3>MINI STATEMENT FOR ACCOUNT NO <br>**********<?php echo substr($accno,-4);?></th>
                </tr>
                <tr>
                    <th>TIME</th>
                    <th>AMOUNT</th>
                    <th>TYPE</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['tmp_time']; ?></td>
                    <td><?php 
                    if($row["AMOUNT"]>0){
                        echo $row["AMOUNT"];
                    }
                    else{
                        echo "FAILED";
                    } ?></td>
                    <td><?php echo $row['transaction_type']; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th colspan=3>Avilable amount: <?php echo $avil?></th>
                </tr>
                </table></center>
            </div><br>
            <button name="download" class="button" onclick="exportTableToExcel('mini', 'mini')">Download</button><br>
            <button class="button" type="submit" name="abort" onclick="window.location.href='index.html'">Exit</button>
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