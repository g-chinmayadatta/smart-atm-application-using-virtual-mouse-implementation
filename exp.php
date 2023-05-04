<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <style>
         *{
    margin: 0;
    padding: 0;
    font-family: 'poppins',sans-serif;
}
h2{
    font-size: 1.5em;
    color: white;
    text-align:center;
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
.button{
    width: 180%;
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
</head>

    <body>
<section>
    <div class="form-box">
 <br>
 <h2> Please Enter Correct Details</h2>
        
<br><br><br>

<form method="post" action="index.html">
    <center><button type="submit" name="exit" id="submit" class="button" >Exit</button></center>  
</form>
</div>
</section>

    </body>

</html>
