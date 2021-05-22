<?php

session_start();
 
require_once "config.php";
 
    $codee = $_SESSION["codee"];

    $sql = "SELECT user_id FROM code where code='$codee'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["user_id"];
                        $_SESSION['user_id'] = $user_id;
                    }
                }


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <style type="text/css">
        body{ 
            text-align: center;
            background-size: cover;
        }
        h1{
            font-family: Bookman Old Style;
            font-size: 30pt;
        }
        img {
            width: 300px;
            border-radius: 40%;
        }
       .login { 
            background-color: transparent; 
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3); 
            width: 600px;
            height: 440px; 
            padding: 30px;
            border-radius: 50px;
            margin: 90px auto;
        }
        p, a{
            color: black;
            font-size: 14pt;
            font-family: 'Just Another Hand', cursive;
        }
        button{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt;
            background-color: #ffc0cb;
            padding: 5px;
            margin: 10px;
            width: 150px;
            border-radius: 10px;
            position: relative;
            border: 2px solid #4169e1;
        }
        input[type="submit"]{ 
            font-family: 'Just Another Hand', cursive; 
            font-size: 13pt;
            background-color: #ffc0cb;
            padding: 5px;
            margin: 10px;
            width: 150px;
            border-radius: 10px;
            position: relative;
            border: 2px solid #4169e1;
        }
    </style>
    <script>
        function logout(){
            if(confirm("Are you sure you want to exit?")){
                window.location.href='logoutpage.php';
            }
        }
        function proceed(){
                window.location.href='eventlog.php';
        }
    </script>
</head>
<body background="img/bc.jpg">
    
<div class="login">
        <h1> Welcome to Animay !</h1>
        
        <img src="img/naruto.gif">
    <div>
        <button id="event" name="event" onclick="proceed()"> Event Log </button>
        <input type="submit" id="submit" name="submit" value=" Logout " onclick="logout()">
    </div>
    </div>
    
</body>
</html>