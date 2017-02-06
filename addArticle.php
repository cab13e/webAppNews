<html>  
    <head>
    </head>
    <body>
        <div style="text-align: center;">
            <h2>Add an article: </h2>
            <form method="POST" action="home.php" name="addArticle">
                Author: <input type="text" name="author" id="author" /> <br/>
                Date: <input type="date" name="date" id="date" /> <br/>
                <label for="content" class="col-sm-2 control-label">Content: </label> <br/>
                <textarea rows="5" name="content" id="content"></textarea>
                <input type="hidden" name="action" value="addArticle" />
                <input type="button" value="Go" onClick="confirm" />
            </form>
        </div>



    </body>
            

<?php


?>