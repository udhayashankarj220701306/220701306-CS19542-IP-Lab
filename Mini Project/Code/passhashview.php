<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>passhashview</title>
</head>
<body>
    <form action="passhashview.php" method="post">
        <input type="text" name="pass">
        <div>
        <?php 
        if($_SERVER["REQUEST_METHOD"]=="POST")
            echo password_hash($_POST["pass"], PASSWORD_DEFAULT); 
        ?></div>
    </form>

</body>
</html>