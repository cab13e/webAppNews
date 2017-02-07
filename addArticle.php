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

if($action == "addArticle")
{
    $title = $_POST["title"];
    $author = $_POST["submitted_by"];
    $date = date("Y-m-d");
    $story = $_POST["story"];
    $approvedby = "";
    $approved = 0;

    $result = $link->query("INSERT INTO pending (title, date, story, submitted_by, approved_by, approved) VALUES ('$title', '$date', '$story', '$author', '$approvedby', '$approved')");
    if(!$result)
    {
        die('Can\'t query pending because: ' . $link->error);
        echo ("<h2> Bad </h2>");
    }
    else
        echo("<h2> submitted </h2>");
}


?>



<html>  
    <head>
    <link href="StyleSheet.css" rel="stylesheet"/>
    <title>Add Article</title>
    </head>
    <body>

     <header>
		
		<nav id="navbar">
			<div class="two-thirds1 column" id="main">
				<legend>Welcome!</legend>
				<a style="text-align:left;position:relative;padding-right: 10px;" href="home.php">Home</a>
				<a style="text-align:right;position:relative;" class="pull-right" href="logout.php">Logout</a>
			</div>
		</nav>
	</header>
       <div class="two-thirds1 column" id="main">
            <h2>Add an article: </h2>
            <form method="POST" action="addArticle.php" name="addArticle">
                Title: <input type="text" name="title" id="title" /> <br/>
                Author: <input type="text" name="submitted_by" id="submitted_by" /> <br/>
                <label for="content" class="col-sm-2 control-label">Content: </label> <br/>
                <textarea rows="5" name="story" id="story"></textarea>
                <input type="hidden" name="action" value="addArticle" /> 
                <input type="Submit" value="Go" />
            </form>
        </div>



    </body>
            

<?php


?>