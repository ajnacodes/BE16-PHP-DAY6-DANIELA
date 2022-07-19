<?php
    session_start();
    require_once "components/db_connect.php";

    if(isset($_SESSION["admin"])){
        header("Location: dashboard.php");
        exit;
    }

    if(!isset($_SESSION["user"])){
        header("Location: index.php");
        exit;
    }

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php" ?>
    <title>Welcome - <?= $row["f_name"] ?></title>
</head>
<body>
    <div class="container">
        <img src="pictures/<?= $row["picture"] ?>" alt="" width="150">
        <p>Hi, <?= $row["f_name"] . " " . $row["l_name"] ?></p>
        <a href="logout.php?logout">Logout</a>

        <a href="account.php">Account</a>
    </div>
</body>
</html>