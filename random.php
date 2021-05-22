<?php 
session_start();
require_once "config.php";
    if(!isset($_SESSION["code_access"]) || $_SESSION["code_access"] !== true){
        header("location: loginpage.php");
        exit;
    }else{
   

        $permitted_chars = '0123456789';

        $duration = floor(time()/(60));
        srand($duration);
        $_SESSION["codee"] = substr(str_shuffle($permitted_chars), 0, 6);
                
        date_default_timezone_set('Asia/Manila');

        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $endDate_months = strtotime("+1 minutes", $currentDate_timestamp);
        $packageEndDate = date('Y-m-d H:i:s', $endDate_months);
            
        $_SESSION["current"] = $currentDate;
        $_SESSION["expired"] = $packageEndDate;

        $user_id = $_SESSION["id"];
        $codee = $_SESSION["codee"];
        

        $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$codee', '$currentDate', '$packageEndDate')";
        
        $result = mysqli_query($link,"select * from code where code='$codee'") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($result);
        if($count == 0)
        {
            if(mysqli_query($link, $sql)){
               
            } else{
            echo "ERROR: $sql. " . mysqli_error($link);
            }
        }else{
       
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Code Generator</title>
    <style>
        label{ font-family: Palatino Linotype; font-size: 13pt; text-align: center;}
        h1{ font-family: Palatino Linotype; font-size: 25pt; text-align:center; }
       .login { 
                background-color: transparent; 
                box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.3); 
                width: 350px; 
                padding: 20px;
                text-align: center;
                left:320px;
                top:370px;
                border-radius: 50px;
                position: absolute; }
    </style>
</head>

<body background="img/bgg1.jpg">

    <div class="login">
        <h1>OTP code </h1>
            <label><?php echo $_SESSION["codee"]; ?></label>
    </div>        
              
</body>
</html>  