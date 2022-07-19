<?php
    session_start();

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    }

    if(isset($_SESSION["admin"])){
        header("Location: dashboard.php");
    }

    
    require_once "components/db_connect.php";


    $error = false;
    $email = $password = $emailError = $passError = '';

    if (isset($_POST['btn-login'])) {

        // prevent sql injections/ clear user invalid inputs
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);
      
        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
      
        if (empty($email)) {
            $error = true;
            $emailError = "Please enter your email address.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $emailError = "Please enter valid email address.";
        }
      
        if (empty($pass)) {
            $error = true;
            $passError = "Please enter your password.";
        }

        if(!$error){
            $password = hash("sha256", $pass);

            $sql = "SELECT * FROM users WHERE email = '$email' AND passwoord = '$password'";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);
            if($count == 1){
                if($row["statuss"] == "user"){
                    $_SESSION["user"] = $row["id"];
                    header("Location: home.php");
                }else {
                    $_SESSION["admin"] = $row["id"];
                    header("Location: dashboard.php");
                }
            }else {
                $errMSG = "Incorrect Credentials, Try again...";
            }
        }
      
    }  
    
    mysqli_close($connect);
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Registration System</title>
  <?php require_once 'components/boot.php' ?>
</head>

<body>
  <div class="container">
      <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
          <h2>Login</h2>
          <hr />
          <?php
          if (isset($errMSG)) {
              echo $errMSG;
          }
          ?>

          <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Type your e-mail" value="<?php echo $email; ?>" maxlength="40" />
          <span class="text-danger"><?php echo $emailError; ?></span>

          <input type="password" name="pass" class="form-control" placeholder="Type your password" maxlength="15" />
          <span class="text-danger"><?php echo $passError; ?></span>
          <hr />
          <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign In</button>
          <hr />
          <a href="register.php">Not registered yet? Click here</a>
      </form>
  </div>
</body>
</html>