<?php
    include "db.php";
    $cid = "";
    if (isset($_GET["cid"])) {
        $cid = $_GET["cid"];
    } elseif (isset($_POST["cid"])) {
        $cid = $_POST["cid"];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cid = $_POST["cid"];
    }
?>

<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="styleforprofile.css">
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>User Profile</h1>
        </div>

        <?php
            $sql = "SELECT * FROM customers WHERE customer_id='$cid'";
            $customers = $db->query($sql);
            $customer = $customers->fetch_assoc();
        ?>

        <div class="profile-info">
            <h2>Personal Info</h2>
            <p><strong>First Name:</strong> <?php echo $customer["first_name"]; ?></p>
            <p><strong>Last Name:</strong> <?php echo $customer["last_name"]; ?></p>
            <p><strong>Email:</strong> <?php echo $customer["email"]; ?></p>
            <p><strong>Phone No:</strong> <?php echo $customer["phone_number"]; ?></p>
            <p><strong>Address:</strong> <?php echo $customer["address"]; ?></p>
            <p><strong>D.O.B:</strong> <?php echo $customer["date_of_birth"]; ?></p>
            <p><strong>Account Status:</strong> <?php echo $customer["account_status"]; ?></p>
        </div>

        <div class="account-info">
            <h2>Account Info</h2>
            <?php
                $sql = "SELECT * FROM accounts WHERE customer_id='$cid'";
                $accounts = $db->query($sql);
                if ($accounts->num_rows > 0) {
                    while ($row = $accounts->fetch_assoc()) {
                        echo "<a class='account-link' href='transaction.php?ano=" . $row['account_number'] . "&cid=" . $row['customer_id'] . "'>Account No: " . $row['account_number'] . " | Type: " . $row['account_type'] . " | Balance: " . $row['balance'] . " | Status: " . $row['status'] . "</a><br>";
                    }
                } else {
                    echo "<p>No Account Found</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
