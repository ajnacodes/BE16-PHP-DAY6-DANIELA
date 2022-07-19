<?php 
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";


if ($_POST) {

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$birthdate = $_POST['birthdate'];
$statuss = $_POST['statuss'];
$id = $_POST['id'];
$picture = file_upload($_FILES['picture']);

if ($picture->error === 0) {
    ($_POST['picture']) == "avatar.jpeg" ?: unlink("../pictures/$_POST[picture]");
    $sql = "UPDATE users SET  f_name = '$fname',
     l_name = '$lname',passwoord = '$pass',
     birthdate = '$birthdate', email = '$email',
      picture = '$picture->fileName', statuss = '$statuss' WHERE id = {$id}";
} else {
    $sql = "UPDATE users SET  f_name = '$fname',
    l_name = '$lname', passwoord = '$pass',
    birthdate = '$birthdate', email = '$email',
    statuss = '$statuss' WHERE id = {$id}";
}

if (mysqli_query($connect, $sql)) {
    $message = "The record was successfully updated";
    $uploadError = ($picture->error !=0)?
    $picture->ErrorMessage : '';
} else {
    $message = "Something went wrong with your record";
    mysqli_connect_error();
    $uploadError = ($picture->error !=0)?
    $picture->ErrorMessage : '';
}
mysqli_close($connect);
} else {
    header("location: ../error.php");
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit request</title>
</head>
<body>
    

<div class="container d-flex justify-content-center my-5 py-5"> 

<div class="card border-dark">
  <div class="card-header">
  Edit response
  </div>
  <div class="card-body">

    <h3 class="fs-subtitle"></p><?=$message;?></h3>
    <a href="../dashboard.php" class="btn btn-outline-dark mx-5 px-5">Go back</a>
  </div>
</div>


</div>


</body>
</html>