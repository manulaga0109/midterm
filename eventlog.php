<?php

$link = mysqli_connect("localhost", "root", "", "demo");
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 

$sql = "SELECT * FROM event_log";
if($result = mysqli_query($link, $sql)){

    if(mysqli_num_rows($result) > 0){
    	echo "<h1> Event Log </h1>";
        echo "<table>";
            echo "<tr>";
                echo "<th>UserID</th>";
                echo "<th>Activty</th>";
                echo "<th>Date&Time</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['userID'] . "</td>";
                echo "<td>" . $row['Activity'] . "</td>";
                echo "<td>" . $row['date_time'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 


mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Event Log</title>
<link rel="stylesheet" href="mycss.css">
<style>
	body{ 
        text-align: center;
        background-size: cover;
    }
    h1{
        font-family: 'Just Another Hand', cursive;
        font-size: 30pt;
    }
	table, th, td {
		font-family: 'Just Another Hand', cursive; 
        font-size: 12pt;
    	border: 2px solid black;
    	text-align:center;
    	margin-bottom:5px;
    	margin-left: 270px;
	}
	table{
		width:750px; 
    	overflow: scroll;
	}
    button{ 
        font-family: 'Just Another Hand', cursive; 
        font-size: 13pt;
        background-color: #ffc0cb;
        padding: 5px;
        margin: 10px;
        width: 150px;
        border-radius: 10px;
        border: 2px solid #4169e1;
        float: center;
    }
</style>
<script>
	function back(){
                window.location.href='indexpage.php';
        }
</script>
</head>
<body background="img/bg.jpg">
	<p>    
        <button onclick="back()" name="back" id="back"> Back </button>
    </p>
</body>
</html>