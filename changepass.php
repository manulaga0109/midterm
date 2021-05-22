<?php

session_start();

 
require_once "config.php";
 
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['email'] = "";
    $user_id = $_SESSION['id'];

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');
    
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($new_password_err) && empty($confirm_password_err)){
        
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_email);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email= $_SESSION["email"];    
            
            if(mysqli_stmt_execute($stmt)){

                $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Change Password', '$currentDate')";
                if(mysqli_query($link, $sql1)){
                       
                } else{
                    echo "ERROR: $sql. " . mysqli_error($link);
                }
    
                session_destroy();
                header("location: loginpage.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
if(isset($_POST['cancel'])){
    header("location:loginpage.php");
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<center>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style type="text/css">
        body{
            background-size: cover;
        }
        label, p, span{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt; 
        }
        h1{ 
            font-family: Bookman Old Style; 
            font-size: 20pt; 
            text-align: center;
            padding-bottom: 10px;
        }
        input[type='password']{
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt; 
            border-radius: 5px;
            border: 2px solid black;
            margin: 10px;
            padding: 5px;
        }
        input[type='submit']{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt;
            background-color: #ffc0cb;
            padding: 5px;
            margin: 5px;
            width: 130px;
            border-radius: 10px;
            position: relative;
            border: 2px solid black;
            margin-top: 30px;
        }
       .login { 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            width: 400px; 
            padding: 20px;
            border-radius: 50px;
            position: absolute;
            left:370px;
            top:170px;
        }
    </style>
</head>  
<body background="img/bgg1.jpg">
    <div class="login">
        <br/>   
        <h1>Reset Password <h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="new_password" value="<?php echo $new_password; ?>" placeholder="New Password"></br>
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password"> </br>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div>
                <input type="submit" value=" Reset ">
                <input type="submit" name="cancel" value=" Cancel ">
            </div>

        </form> 
    </div>
</body>
</html>