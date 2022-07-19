<?php
require_once "components/db_connect.php";

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $fname = $data['f_name'];
        $lname = $data['l_name'];
        $email = $data['email'];
        $birthdate = $data['birthdate'];
        $password = $data['passwoord'];
        $picture = $data['picture'];
        $statuss = $data['statuss'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php" ?>
    <title>My Account</title>
</head>
<body>
    
<div class="container m-5">

<form  class="w-50" action="actions/a_update.php" method="post" enctype="multipart/form-data"><div class="text-center">
  <fieldset>
<h4 class="text-center" >Edit user details</h4>

  <img src="pictures/<?php echo $picture?>"  style="witdh: 10rem; height: 7rem;" class="rounded" alt="...">
</div>
  <div class="mb-3">
    <label for="" class="form-label">First name</label>
    <input type="text" class="form-control" name="fname" value="<?php echo $fname?>">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Last name</label>
    <input type="text" class="form-control" name="lname" value="<?php echo $lname?>">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Email</label>
    <input type="text" class="form-control" name="email" value="<?php echo $email?>">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Birthdate</label>
    <input type="date" class="form-control"  name="birthdate" value="<?php echo $birthdate?>">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Password</label>
    <input type="password" class="form-control" name="pass" value="<?php echo $password?>">

    <input class="form-control" type="text" name="statuss" placeholder="Status" value="<?php echo $statuss?>"/>
  </div>
  <div class="mb-3">
    <label class="form-label">Picture</label>
    <input type="file" class="form-control" name="picture" placeholder="Choose a picture">
    <input type="hidden" name="id" value="<?php echo $id?>" />
  <input type="hidden" name="picture" value="<?php echo $picture?>" />
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="index.php" class="btn btn-primary" >Go back</a>
  </fieldset>
</form>

</div>
</body>
</html>