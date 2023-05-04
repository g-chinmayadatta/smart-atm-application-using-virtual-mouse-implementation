<html>
    <head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        *{
            margin: 0;
            padding: 0;
            font-family: 'poppins',sans-serif;
        }
        section{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            color: #fff;
            background: url('img/bgi.jpg')no-repeat;
            background-position: center;
            background-size: cover;
        }
        .form-box{
            position: center;
            width: 400px;
            height: 450px;
            background: transparent;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            

        }
        h1{
            font-size: 1.5em;
            color: white;
            text-align:center;
        }

        .button{
            width: 60%;
            height: 40px;
            border-radius: 20px;
            background: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            align: center;
            display: center;
            justify-content: center;
        }
    </style>
    <script>
        var button = document.getElementById("deposit");
        button.addEventListener("click", function() {
        button.disabled = true;
        }); 
    </script>
    </head>
    <section>
        <div class="form-box">
    <h1>Please Choose Your Task!</h1><br>
        <form  method="post">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="button" id="deposit" name="deposit">Deposit</button><br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="button" id="withdraw" name="withdrawal">Withdraw</button><br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="button" id="transfer" name="transfer">Transfer</button><br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="button" id="balance" name="balance">Balance Enquiry</button>
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="button" id="deposit" name="ministatement">Mini Statement</button><br><br>
        </form>
    </section>
</html>
<?php
session_start();

if(isset($_POST['deposit'])) {
    header("location:otp.php");
    $_SESSION['option'] = 'deposit';
} elseif(isset($_POST['withdrawal'])) {
    header("location:otp.php");
    $_SESSION['option'] = 'withdrawal';
} elseif(isset($_POST['transfer'])) {
    header("location:otp.php");
    $_SESSION['option'] = 'transfer';
} elseif(isset($_POST['balance'])) {
    header("location:balance.php");
    $_SESSION['option'] = 'balance';
}else if (isset($_POST["abort"])){
    header("location:index.html");
}elseif(isset($_POST['ministatement'])) {
    header("location:ministatement.php");
    $_SESSION['option'] = 'ministatement';
}

?>



