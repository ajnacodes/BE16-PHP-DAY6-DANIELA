<?php 
require_once "../components/db_connect.php";

if($_POST){
    $id = $_POST['id'];
    //  $image_file = $_POST['image_file'];
    //  ($image_file =="placeholder.jpeg")?: unlink("../images/$image_file");
    //  var_dump($_POST);
    $sql = "DELETE from users WHERE id = $id";
    if(mysqli_query($connect, $sql)){
        
        $message = "Record deleted";
    }else{
      
        $message = "Not deleted :" . $connect->error;
    }
    mysqli_close($connect);
}else{
    header("location: ../error.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once dirname(__DIR__)."\components\boot.php"; ?>

    <title>Delete response</title>
</head>



<body>
    

<div class="container d-flex justify-content-center my-5 py-5"> 

<div class="card border-dark">
  <div class="card-header">
   Delete request response
  </div>
  <div class="card-body">

    <h3 class="fs-subtitle"></p><?=$message;?></h3>
    <a href="../dashboard.php" class="btn btn-outline-dark mx-5 px-5">Go back</a>
  </div>
</div>


</div>


</body>
</html>