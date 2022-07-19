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
        $pass = $data['passwoord'];
        $picture = $data['picture'];
        $status = $data['statuss'];
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
    <title>Delete user</title>
</head>
<body>
    

<div class="container d-flex justify-content-center my-5 py-5"> 
<form action="actions/a_delete.php" method="post">
<input type="hidden" name="id" value="<?php echo $id?>" />
<input type="hidden" name="picture" value="<?php echo $picture?>" />
<div class="card border-dark">
  <div class="card-header">
   Delete request response
  </div>
  <div class="card-body">
    <h5 class="card-title text-danger">WARNING</h5>
    <p class="card-text ">If you really wish to delete this user, note that the changes are irreversible.</p>

    <button class="btn btn-outline-danger mx-5" type="submit">Yes, delete</button>
    <a href="dashboard.php" class="btn btn-outline-dark mx-5 px-5">Go back</a>
  </div>
</div>
</form>

</div>


</body>
</html>