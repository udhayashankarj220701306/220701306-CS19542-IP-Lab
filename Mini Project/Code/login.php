<?php
    include "db.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST["username"];
        $pass=password_hash($_POST["password"], PASSWORD_DEFAULT);
        // if(isset($_POST["login"])){
            $sql="select * from userauth where username='$username'";
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                if(password_verify($_POST["password"],$row['password_hash'])){
                    $sql = "update userauth set last_login = CURRENT_TIMESTAMP where user_id=".$row['customer_id'];
                    $db->query($sql);
                    header("location:profile.php?cid=".$row['customer_id']);
                }
                else
                    echo " password mismatch ";
            }
            else    
                echo " user not found";

        // }
    }
?>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="video-background">
        <video autoplay muted loop id="background-video">
            <source src="bgvideosmall.mp4" type="video/mp4">
        </video>
        <div class="form-container">
        <!-- <form> -->
        <form action="\login.php" method = "POST">
                <input type="text" name="username" placeholder="User Name" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <a href="/home.php">profile</a>
            </form>
        </div>
    </div>
</body>
</html>