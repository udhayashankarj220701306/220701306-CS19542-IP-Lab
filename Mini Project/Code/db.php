<?php
    define("host","localhost:3306");
    define("user","root");
    define("password","");
    define("db","banking");
    $db = mysqli_connect(host, user, password, db);
    if(!$db)
        echo "Connection Failed";
?>