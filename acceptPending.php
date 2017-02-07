<?php
$link = new mysqli("localhost","root", "", "stories");


if ($link->connect_errno) {
    printf("Connect failed: %s\n", $link->connect_error);
    exit();
}

if(isset($_REQUEST["action"]))
	$action = $_REQUEST["action"];
else
	$action = "none";

$message = "";

if($action == "approve")
{
    $name = $_POST["name"];
        $result = $link->query("UPDATE pending SET approved= 1 WHERE 'approved' = 0");
            if(!$result)
            {
                die('Can\'t query pending because: ' . $link->error);
                echo ("<h2> Bad </h2>");
             }
            else
                echo("<h2> updated </h2>");
}

?>

<html>
<head>
    <link href="StyleSheet.css" rel="stylesheet"/>
</head>
<body>
	<?php
			 	$result = $link->query("Select * from pending where approved='0' order by 'date' asc");
				
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					echo("<div class='t-thirds1 column' id='main'><legend>". $row["title"] . "</legend>");
					echo("<h4>Article By: ". $row["submitted_by"] . "</h4>");
					echo("<h5>" . $row["date"] . "</h5>");
					echo("<p>" . $row["story"] . "</p></div>");
				}	 
	            ?>
                <form method="POST" action="acceptPending.php" name="approve">
                    Name: <input type="text" name="name" />
                    <input type="hidden" name="action" value="approve" />
				    <input type="Submit" value="Submit"/>
                </form>
</body>    
</html>