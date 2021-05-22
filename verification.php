<?php 

session_start(); 

if(!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true){
    header("location: loginpage.php");
    exit;
}
 
require_once "config.php";


$code_err = "";
$_SESSION["code_access"] = true;



if(isset($_POST['login']))
{ 
    if(empty(trim($_POST["code"]))){
        echo "<script>alert('PLEASE ENTER CODE');</script>";
    } else{ 

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        $user_id = $_SESSION["id"];
        

        $id_code = mysqli_query($link,"SELECT * FROM code WHERE code='$code' AND id_code=id_code") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($id_code);


        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'demo';

        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT expiration FROM code where code='$code'";
        $result = $conn->query($sql);

        

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div style='display: none;'>"."Expiration: " . $row["expiration"]. "<br>";
                echo $currentDate."<br></div>";
                if(($row["expiration"]) >($currentDate)){

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username; 
                    $codee = $_SESSION["codee"];

                    $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Authentication', '$currentDate')";
                    if(mysqli_query($link, $sql1)){
               
                    } else{
                    echo "ERROR: $sql. " . mysqli_error($link);
                    }

                    header("location: indexpage.php");
                }
                else{
                    echo "<script>
                        alert('EXPIRED CODE ERROR');
                        window.location.href='loginpage.php';
                    </script>";
                }
            }
          } else {
            echo "<script>
                    alert('WRONG CODE ERROR');
                    window.location.href='loginpage.php';
            </script>";
          }

          $conn->close();
    }
    
    mysqli_close($link);
}
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
    <title>autheticator</title>
    <style type="text/css">
        body{
            background-size: cover;
        }
        label{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt; 
        }
        h1{ 
            font-family: Bookman Old Style; 
            font-size: 25pt; 
        }
        input[type='text']{
            font-family: 'Just Another Hand', cursive; 
            font-size: 12pt; 
            border-radius: 5px;
            border: 2px solid black;
            margin: 5px;
            padding: 3px;
        }
        button{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt;
            background-color: #ffc0cb;
            padding: 5px;
            margin: 5px;
            width: 150px;
            border-radius: 10px;
            position: relative;
            border: 2px solid black;
            margin-top: 40px;
        }
       .login { 
            width: 400px; 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            margin: 100px auto; 
            padding: 20px; 
            font-family: Palatino Linotype; font-size: 11pt;
            border-radius: 50px;
            position: absolute;
            text-align:center;
            opacity:0.9;
            left:370px;
            top:150px;
        }

                
    </style>
</head> 
<body background="img/bgg1.jpg">
    
    <div class="login">
        <h1>Verification</h1>
        <form role="form" method="post">
            <br/>
            <label>Enter Code </label>
            <input type="text" name="code">
            <button type="submit" name="login">Submit</button><BR>
            </br>   

        </form>
    </div> 
</body>
</html>


