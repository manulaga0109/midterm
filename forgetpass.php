<?php
session_start();
require_once "config.php";

$email = "";
$email_err = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['email'] = "";

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a Email.";
    }
    else{
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
        }

        if(mysqli_stmt_execute($stmt)){
       
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){

                $sql = "SELECT id FROM users where email='$param_email'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["id"];
                        $_SESSION['id'] = $user_id;

                        $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Forget Password', '$currentDate')";
                        if(mysqli_query($link, $sql1)){
                       
                        } else{
                            echo "ERROR: $sql. " . mysqli_error($link);
                        }
                    }
                }

                header("location:changepass.php");
    
            }
        else if(mysqli_stmt_num_rows($stmt) != 1){
            $email_err = "This email is not exist.";
        } else{
            $email = trim($_POST["email"]);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
    mysqli_close($link);
}
if(isset($_POST['back'])){
    header("location:loginpage.php");
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<center>
    <meta charset="UTF-8">
    <title>Forget Password</title>
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
            font-size: 20pt; 
            text-align: center;
        }
        input[type='email']{
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
            width: 100px;
            border-radius: 10px;
            position: relative;
            border: 2px solid black;
            margin-top: 20px;
        }
       .login { 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            width: 400px;
            height: 250px;
            padding: 20px;
            border-radius: 50px;
            position: absolute;
            left:370px;
            top:220px;
        }
    </style>
</head>  
<body background="img/bgg1.jpg">
    <div class="login"> 
        <br/>  
        <h1>Forget Password ?</h1>
        <br/>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder=" Enter email address"></br>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            </br> 

            <div>
                <input type="submit" value=" Next " name="next" id="next">
                <input type="submit" value=" Back " name="back" id="back">
            </div>

        </form> 
    </div>
</body>
</html>