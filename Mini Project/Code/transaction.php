<?php
    include "db.php";
    $ano="";
    if(isset($_GET["ano"]))
        $ano=$_GET["ano"];
    elseif(isset($_POST["ano"]))
        $ano=$_POST["ano"];
    $cid="";
        if(isset($_GET["cid"]))
            $cid=$_GET["cid"];
        elseif(isset($_POST["cid"]))
            $cid=$_POST["cid"];
    $sql="select * from accounts where account_number='$ano'";
    $result=$db->query($sql);
    $row=$result->fetch_assoc();
    $aid1=$row["account_id"];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST["transfer"])){
            $ttype="transfer";
            $description=$_POST['description'];
            $tano=$_POST["to_account_no"];
            $amount=(int)$_POST["amount"];
            $sql="select * from accounts where account_number='$ano'";
            $result=$db->query($sql);
            $row=$result->fetch_assoc();
            $balance=(int)$row["balance"];
            $amt=$balance-$amount;
            $sql="select * from accounts where account_number='$tano'";
            $result=$db->query($sql);
            $row=$result->fetch_assoc();
            $aid2=$row["account_id"];
            if(
                $balance<$amount ){
                echo "Insufficient Balance<br>";
            }
            else{
                $sql="insert into transactions (account_id,from_account_id,to_account_id,transaction_type,amount,description,balance_before,balance_after) values('$aid1','$aid1','$aid2','$ttype','$amount','$description','$balance','$amt')";
                if($db->query($sql)===False)   
                    echo "Error: " . $sql . "<br>" . $conn->error;
                $sql="update accounts set balance='$amt' where account_number='$ano'";
                if($db->query($sql)===False)   
                    echo "Error: " . $sql . "<br>" . $conn->error;
                $balance=(int)$row["balance"];
                $amt=$balance+$amount;
                $sql="insert into transactions (account_id,from_account_id,to_account_id,transaction_type,amount,description,balance_before,balance_after) values('$aid2','$aid2','$aid1','$ttype','$amount','$description','$balance','$amt')";
                if($db->query($sql)===False)   
                    echo "Error: " . $sql . "<br>" . $conn->error;
                $sql="update accounts set balance='$amt' where account_number='$tano'";
                if($db->query($sql)===False)   
                    echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
        }
        
    }
    $aid=$aid1;
?>
<html>
<head>
    <title>Transaction</title>
    <link rel="stylesheet" href="stylefortransaction.css">
</head>
<body>
    <div class="container">
        <h2>Account Information</h2>
        <?php
            $sql="select * from accounts where customer_id='$cid'";
            $accounts=$db->query($sql);
            if($accounts->num_rows>0){
                while($row=$accounts->fetch_assoc()){
                    echo "<p>Account No: ".$row['account_number']." | Account Type: ".$row['account_type']." | Balance: ".$row['balance']."</p>";
                }
            } else {
                echo "<p>NO Account Found</p>";
            }
        ?>

        <h2>Transaction</h2>
        <form action="/transaction.php" method="post">
            <input hidden type="text" name="ano" value="<?php echo $ano ?>">
            <input hidden type="text" name="cid" value="<?php echo $cid ?>">

            <label for="amount">Amount:</label>
            <input type="number" name="amount" required>

            <label for="to_account_no">Receiving Account No:</label>
            <input type="text" name="to_account_no" required>

            <label for="description">Description:</label>
            <input type="text" name="description" required>

            <input type="submit" name="transfer" value="Transfer">
        </form>

        <div class="transaction-history">
            <h2>Transaction History</h2>
            <?php
                $sql = "select * from transactions where account_id='$aid'";
                $result=$db->query($sql);
                
                while($row=$result->fetch_assoc()){
                    echo '<div class="transaction-item">';
                    if($row['transaction_type']=="transfer")
                        echo "<p>Account Id: ".$row['account_id']." | To Account Id: ".$row['to_account_id']." | Amount: ".$row['amount']." | Description: ".$row['description']."</p>";
                    else
                        echo "<p>Account Id: ".$row['account_id']." | Amount: ".$row['amount']." | Description: ".$row['description']."</p>";
                    echo '</div>';
                }
            ?>
        </div>

        <div class="back-link">
            <a href="profile.php?cid=<?php echo $cid ?>">Back to Profile</a>
        </div>
    </div>
</body>
</html>