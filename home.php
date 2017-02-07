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
			<div class="two-thirds1 column" id="main">
				<h1 id="welcome">Welcome!</h1>
			</div> <br/>
			<a style="text-align:left;position:relative;padding-right: 10px;" href="addArticle.php"><h3 id="linker">Add an article</h3></a>
			<a style="text-align:right;position:relative;" class="pull-right" href="logout.php"><h3 id="linker">Logout<h3></a> <br/>
		</nav>
	</header>
	
	<?php
			 	$result = $link->query("Select * from pending where approved='1' order by 'date' asc");
				
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					echo("<div class='t-thirds1 column' id='main'><legend>". $row["title"] . "</legend>");
					echo("<h4>Article By: ". $row["submitted_by"] . "</h4>");
					echo("<h5>" . $row["date"] . "</h5>");
					echo("<p>" . $row["story"] . "</p></div>");
				}	 
	?>
		
				
	</div>
</body>
</html>

