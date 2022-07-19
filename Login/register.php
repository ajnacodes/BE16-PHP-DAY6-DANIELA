<?php
    session_start();

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    }

    if(isset($_SESSION["admin"])){
        header("Location: dashboard.php");
    }
    require_once "components/db_connect.php";
    require_once "components/file_upload.php";

    $error = false;

    $fname = $lname = $email = $birthdate = $pass = $picture = "";
    $fnameError = $emailError = $dateError = $passError = $picError = "";

    function cleanInput($var){
        $var = trim($var);
        $var = strip_tags($var);
        $var = htmlspecialchars($var);

        return $var;
    }

    if(isset($_POST["btn-signup"])){
        $fname = cleanInput($_POST["fname"]); 

        $lname = cleanInput($_POST["lname"]);

        $email = trim($_POST["email"]);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);

        $pass = trim($_POST["pass"]);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

        $birthdate = trim($_POST["birthdate"]);
        $birthdate = strip_tags($birthdate);
        $birthdate = htmlspecialchars($birthdate);

        if(empty($fname) || empty($lname)){
            $error = true;
            $fnameError = "Please enter your full name and surname";
        }elseif(strlen($fname) < 3 || strlen($lname) < 3){
            $error = true;
            $fnameError = "Name and surname must have at least 3 char";
        }elseif (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)){
            $error = true;
            $fnameError = "Name and surname must contain only letters and no spaces.";
        
        }

        if(empty($email)){
            $error = true;
            $emailError = "Please enter your email";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Please enter a valid email";
        }else {
            $sql = "SELECT email FROM users WHERE email = '$email'";
            $result = mysqli_query($connect, $sql);
            $count = mysqli_num_rows($result);
            if($count != 0){
                $error = true;
                $emailError = "Email is already in use";
            }
        }

        $uploadError = "";
        $picture = file_upload($_FILES["picture"]);

        if(empty($pass) ){
            $error = true;
            $passError = "Please enter your password";
        }elseif(strlen($pass) < 6){
            $error = true;
            $passError = "password must have at least 6 chars";
        }

        if(empty($birthdate) ){
            $error = true;
            $dateError = "Please enter your date of birth";
        }

        $password = hash("sha256", $pass);

        if(!$error){
            $sql = "INSERT INTO users(f_name, l_name, passwoord, birthdate, email, picture) VALUES ('$fname', '$lname', '$password', '$birthdate', '$email', '$picture->fileName')";

            $res = mysqli_query($connect, $sql);

            if($res){
                $errTyp = "success";
                $errMSG = "Successfully registered, you may login now";
                $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
            } else {
                $errTyp = "danger";
                $errMSG = "Something went wrong, try again later...";
                $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
            }
        }
    }
    mysqli_close($connect);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login And Registration System</title>
    <?php require_once 'components/boot.php' ?>
</head>




<body>
    

<div class="container">

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
method="post" class="w-75" autocomplete="off" enctype="multipart/form-data">
<h2>Sign up</h2>
<hr>

<?php
if (isset($errMSG)) {

?>

<div class="alert alert-<?php echo $errTyp ?>">
<p> <?php echo $errMSG; ?> </p>
<p> <?php echo $uploadError; ?> </p>
</div>



<?php } ?>

<input type="text" name="fname" class="form-control" 
placeholder="Enter your first name" maxlength="50" required
value="<?php echo $fname ?>"/>
<span class="text-danger"> <?php echo $fnameError; ?> </span>

<input type="text" name="lname" class="form-control" placeholder="Enter your last name" maxlength="50" value="<?php echo $lname ?>" />
<span class="text-danger"> <?php echo $fnameError; ?> </span>

<input type="email" name="email" class="form-control" placeholder="Enter your e-mail" maxlength="40" value="<?php echo $email ?>" />
<span class="text-danger"> <?php echo $emailError; ?> </span>

<div class="d-flex">
              <input class='form-control w-50' type="date" name="birthdate" value="<?php echo $birthdate ?>" />
              <span class="text-danger"> <?php echo $dateError; ?> </span>

              <input class='form-control w-50' type="file" name="picture">
              <span class="text-danger"> <?php echo $picError; ?> </span>
          </div>


          <input type="password" name="pass" class="form-control" placeholder="Enter your password" maxlength="15" />
          <span class="text-danger"> <?php echo $passError; ?> </span>
          <hr />
          <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign up</button>
          <hr />
          <a href="index.php">Sign in here</a>

</form>
</div>
</body>

</html>