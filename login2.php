<?php
/*
--Create Database user_db and then sue the database
--Import this into phpmyadmin

CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(50) NOT NULL,
  `id` int(2) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;
*/

//$crypted = crypt ( string $str, string $salt);

/**************************
*
* Database Connections
*
***************************/
$link = new mysqli("localhost","root", "", "userDB");


if ($link->connect_errno) {
    printf("Connect failed: %s\n", $link->connect_error);
    exit();
}
/**************************
*
* Database interactions
*
***************************/


session_start();

if(isset($_SESSION['use']))   // Checking whether the session is already there 
                              // If true, then header redirect it to the home page directly 
 {
    header("Location:home.php"); 
 }

if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
     $user = $_POST['user'];
     $pass = $_POST['pass'];

      if($user == "Blee" && $pass == "1234")  // username is  set to "Ank"  and Password   
         {                                   // is 1234 by default
            $_SESSION['use']=$user;
            //  On Successful Login redirects to home.php
	         echo '<script type="text/javascript"> window.open("home.php","_self");</script>'; 
          }
      else
      {
	       echo "<h2>Invalid UserName or Password</h2";
      }
}


$loggedin = false;
if(isset($_COOKIE["AppName"]))
{
	$name = $_COOKIE["AppName"];
	$cryptedCookie = $_COOKIE[$name];
	$cryptedName = crypt($name,"ilovetacos");
	if($cryptedCookie == $cryptedName)
		$loggedin = true;
}
else
	$action = "none";

if(isset($_REQUEST["action"]))
	$action = $_REQUEST["action"];
else
	$action = "none";

$message = "";

if($action == "add_user")
{
	$name = $_POST["name"];
	$password = $_POST["password"];
	$level = $_POST["level"];
	
	$name = htmlentities($link->real_escape_string($name));
	$password = htmlentities($link->real_escape_string($password));
	$password = crypt ($password,"ilovetacos");
	$result = $link->query("INSERT INTO users (username, password, level) VALUES ('$name', '$password', '$level')");
	if(!$result)
		die ('Can\'t query users because: ' . $link->error);
	else
		$message = "User Added";
}
elseif ($action == "delete_user") {
	$id = $_POST["id"];
	$name = $_POST["name"];
	$id = htmlentities($link->real_escape_string($id));
	$result = $link->query("DELETE FROM users WHERE id='" . $id . "'");
	if(!$result)
		die ('Can\'t query users because: ' . $link->error);
	else
		$message = "User $name Deleted";
}
elseif ($action == "edit_user") {
	$id = $_POST["id"];
	$id = htmlentities($link->real_escape_string($id));
	$name = $_POST["name"];
	$name = htmlentities($link->real_escape_string($name));
	$result = $link->query("UPDATE users SET username='$name' WHERE id='" . $id . "'");
	if(!$result)
		die ('Can\'t query users because: ' . $link->error);
	else
		$message = "User $name Updated";
}
elseif ($action == "login") {
	$name = $_POST["name"];
	$password = $_POST["password"];
	
	$name = htmlentities($link->real_escape_string($name));
	$password = htmlentities($link->real_escape_string($password));
	
	$password = crypt ($password,"ilovetacos");
	
	$result = $link->query("SELECT * FROM users WHERE username='$name'");
	if(!$result)
		die ('Can\'t query users because: ' . $link->error);

	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) 
	{
	  $row = $result->fetch_assoc();
	  if($row["password"] == $password)
	  {
		$message = "User $name Logged in!";
		$cookieValue = crypt($name,"ilovetacos");
		setcookie("AppName", $name, time()+3600);  /* expire in 1 hour */
		setcookie($name, $cookieValue, time()+3600);  /* expire in 1 hour */
		$loggedin = true;
	  }
	  else
		$message = "Password for user $name incorrect!";
	}
	else {
	  // do something else
	  $message = "No user $name found!";
	}
}
?>

<html>
	<head>
		<title>Welcome</title>
		<script>
			function validate()
			{
				var name = document.getElementById("add_name").value;
				if(name == "")
					alert("Please enter a name");
				else
				{
					var found = false;
					for(var i=0; i<name.length; i++)
					{
						if(name[i] == "@")
							found = true;
					}
					if(found)
						alert("Please do not use the '@' character in your name");
					else
						document.forms["add_user"].submit();
				}
				
				return;
			}
			function confirm_delete(i)
			{
				var r = confirm("Are you sure you want to delete this user?");
				if(r)
				{
					document.forms["delete_user"+i].submit();
				}
				
				return;
			}
			function check_pass()
			{
				var pass1 = document.getElementById("pass1").value;
				var pass2 = document.getElementById("pass2").value;
				if(pass1==pass2)
				{
					document.getElementById("pass_same").innerHTML = "Match";
					document.getElementById("pass_same").style.background = "Green";
					document.getElementById("pass_same").style.color = "White";
				}
				else
				{
					document.getElementById("pass_same").innerHTML = "No Match";
					document.getElementById("pass_same").style.background = "Red";
					document.getElementById("pass_same").style.color = "White";
				}
			}
		</script>
	</head>
	<body>
	
		<h1>Welcome!</h1>
		<?php
			if($loggedin)
				print "Welcome, ". $_COOKIE["AppName"];
			else
				print "Not logged in.";
				
			if($message != "")
				print $message . "<br/><br/>";
			
			print "<h3>Users:</h3>";
			
			$result = $link->query("SELECT * FROM users");
			if(!$result)
				die ('Can\'t query users because: ' . $link->error);
			else
			{
				$i=0;
				while($row = $result->fetch_assoc()):?>
					<form method="post" action="login2.php">
						<input type="hidden" name="id" value="<?php print $row["id"];?>" />
						<input type="text" name="name" value="<?php print $row["name"];?>" />
						<input type="hidden" name="action" value="edit_user" />
						<input type="Submit" value="Update" />
					</form>

					<form method="post" action="login2.php" name="delete_user<?php print $i; ?>">
						<input type="hidden" name="id" value="<?php print $row["id"];?>" />
						<input type="hidden" name="name" value="<?php print $row["name"];?>" />
						<input type="hidden" name="action" value="delete_user" />
						<input type="Button" value="Delete" onClick="confirm_delete(<?php print $i; ?>)" />
					</form>

				<?php 
				$i++;
				endwhile;
			}

			$result->close();
		?>
		Add User: 
		<form method="post" action="login2.php" name="add_user">
			Username: <input type="text" name="name" id="add_name" /> <br/>
			Level: <input type="text" name="level" id="addLevel" /> <br/>
			Password: <input type="text" name="password" id="pass1" /> <br/>
			Password (again): <input type="text" id="pass2" onKeyUp="check_pass()"/>
			<input type="hidden" name="action" value="add_user" />
			<input type="Button" value="Go" onClick="validate()" />
		</form>
		
		Login: 
		<form method="post" action="home.php" name="login">
			Username: <input type="text" name="name" /> <br/>
			Password: <input type="text" name="password" /> <br/>
			<input type="hidden" name="action" value="login" />
			<input type="Submit" value="Go"/>
		</form>
		
		<br/>
		

		
	</body>
</html>