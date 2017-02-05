<?php
setcookie("AppName" , '' , time()-50000, '/');
header("Location: login2.php");
exit;
?>