<?php
$link = new mysqli("localhost","root", "", "stories");
if ($link->connect_errno) 
{
    printf("Connect failed: %s\n", $link->connect_error);
    exit();
}
?>


<html>
<head>
<title> Home </title>
<link href="StyleSheet.css" rel="stylesheet"/>
</head>
<body>
	<header>
		
		<nav id="navbar">
			<h1>Welcome!</h1>
			<a style="text-align:left;position:relative;padding-right: 10px;" href="addArticle.php">Add an article</a>
			<a style="text-align:right;position:relative;" class="pull-right" href="logout.php">Logout</a>
		</nav>
	</header>
	
	<?php
			 	$result = $link->query("Select * from pending where approved='1' order by 'date' asc");
				
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					echo("<article><h2>". $row["title"] . "</h2>");
					echo("<h3>Article By: ". $row["submitted_by"] . "</h3>");
					echo("<h3>" . $row["date"] . "</h3>");
					echo("<p>" . $row["story"] . "</p></article>");
				}	 
	?>
		
				
	</div>
</body>
</html>

