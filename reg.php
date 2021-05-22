<?php

session_start();

require_once "config.php";
 

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
       
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = trim($_POST["username"]);
            
            
            if(mysqli_stmt_execute($stmt)){
               
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
   
   $upcase = "/(?=.*?[A-Z])/";
   $locase = "/(?=.*?[a-z])/";
   $specchar = "/(?=.*?[#?!@$%^&*-])/";
   $num = "/(?=.*?[0-9])/";
   $mail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');

    // password validation
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";        
    } 
    elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";         
     }
    elseif(!preg_match($specchar,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) special characters.";
    }
    elseif(!preg_match($num,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) number.";
    }
    elseif(!preg_match($locase,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) lowercase.";
    }
    elseif(!preg_match($upcase,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) uppercase.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    //confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";     
    }elseif(!preg_match($mail,$_POST['email'])){
        $email_err = "Please enter valid email";
    }else{
        $email = trim($_POST['email']);
    }

    
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        
        $sql = "INSERT INTO users (username, password,email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            
            
            if(mysqli_stmt_execute($stmt)){

                $sql = "SELECT id FROM users where username='$param_username'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["id"];
                        $_SESSION['id'] = $user_id;

                        $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Create Account', '$currentDate')";
                        if(mysqli_query($link, $sql1)){
                       
                        } else{
                            echo "ERROR: $sql. " . mysqli_error($link);
                        }
                    }
                }
                
                header("location: loginpage.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style type="text/css">
        body{
            background-size: cover;
        }
        label, p{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt; 
        }
        h1{ 
            font-family: Bookman Old Style; 
            font-size: 30pt; 
        }
        input[type='text']{
            font-family: 'Just Another Hand', cursive; 
            font-size: 12pt; 
            border-radius: 5px;
            border: 2px solid black;
            margin: 5px;
            padding: 3px;
        }
        input[type='password']{
            font-family: 'Just Another Hand', cursive; 
            font-size: 12pt; 
            border-radius: 5px;
            border: 2px solid black;
            margin: 5px;
            padding: 3px;
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
            width: 400px; 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            padding: 20px;
            border-radius: 50px;
            position: absolute;
            left:370px;
            top:90px; 
        }
    </style>
</head>
<body background="img/bgg1.jpg">
    <div class="login">
        <center><h1>Sign Up</h1></center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <center>
            <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username"> </br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            </br>   
            <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="E-mail"> </br>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            </br> 
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password"></br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            </br>
            <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="Re-type Password"> </br>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
        </br>
            <div>
                <input type="submit" value=" Register " style="background-color: #ffc0cb; font-size: 13pt; padding:5px 10px">
            </div>
            <p>Already have an account? <a href="loginpage.php">Login</a>.</p>
        </form> 
        </center>  
    </div>
    </body>
    </html>