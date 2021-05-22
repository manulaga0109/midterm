<?php

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: indexpage.php");
    exit;
}
require_once "config.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }



    
    if(empty($username_err) && empty($password_err)){
        
         if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            $_SESSION["username"] = $username;
                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            $_SESSION["id"] = $id;
                           // header("location: verification.php");

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

                           // $user_id = $_SESSION["id"];
                            $codee = $_SESSION["codee"];
                            
                            //authentication code
                            $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$id', '$codee', '$currentDate', '$packageEndDate')";
                            
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

                            //event_log
                            $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$id', 'Login', '$currentDate')";
                                if(mysqli_query($link, $sql1)){
                           
                                } else{
                                echo "ERROR: $sql. " . mysqli_error($link);
                                }

                            echo "<script> alert('This is your code:    $codee');
                                    window.location.href='verification.php';
                            </script>";
                        } else{ 
                             
                            echo "<script>alert('PASSWORD ERROR');</script>";
                        } 
                    }
                } else{ 
                    echo "<script>alert('USERNAME IS NOT EXIST');</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
}
?>


  
<!DOCTYPE html>
<html lang="en">
<head>
<center>
    <meta charset="UTF-8">
    <title>Login</title>
    <style type="text/css">
        body{
            background-size: cover;
        }
        label{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt; 
        }
        p{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 12pt; 
        }
        h1{ 
            font-family: Bookman Old Style; 
            font-size: 35pt; 
        }
        input{
            font-family: 'Just Another Hand', cursive; 
            font-size: 11pt; 
        }
        input[type='submit']{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt;
            background-color: #ffc0cb;
            padding: 5px;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            position: relative;
            border: 2px solid black;
        }
       .login { 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            width: 400px; 
            padding: 20px;
            border-radius: 50px;
            position: absolute;
            left:370px;
            top:150px;
        }
    </style>
</head>  
<body background="bgg1.jpg">
    <div class="login">   
        <h1>Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label><b>Username</b></label>
                <input type="text" name="username" value="<?php echo $username; ?>"></br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            </br>  
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label><b>Password</b></label>
                <input type="password" name="password"></br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>  
            </br>
            <div>
                <input type="submit" value=" Login " name="login" id="login">
            </div>
            <p>Create an account. <a href="reg.php">Sign up now</a>.</p>
            <p><a href="forgetpass.php">Forget Password</a>.</p>
        </form> 
    </div>
</body>
</html>