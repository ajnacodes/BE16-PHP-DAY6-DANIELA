<?php
    session_start();

    require "components/db_connect.php";

    if(isset($_SESSION["user"])){
        header("Location: home.php");
        exit;
    }
    if(!isset($_SESSION["admin"]) && !isset($_SESSION["user"])){
        header("Location: index.php");
        exit;
    } 

    $sql = "SELECT * FROM users WHERE id = {$_SESSION['admin']}";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $status = 'admin';
    $sql2 = "SELECT * FROM users where statuss != '$status'";
$result2 = mysqli_query($connect2, $sql2);

$tbody ="";

if(mysqli_num_rows($result2) > 0 ) {
    while($row2 = mysqli_fetch_assoc($result2)) {

        $tbody .= "
        
        <tr>
        <td>
          <div class='d-flex align-items-center'>
            <img
                src='pictures/".$row2['picture']."'
                alt=''
                style='width: 45px; height: 45px'
                class='rounded-circle'
                />
            <div class='ms-3'>
              <p class='fw-bold mb-1'>".$row2['f_name']." ".$row2['l_name']."</p>
              <p class='text-muted mb-0'>".$row2['email']."</p>
            </div>
          </div>
        </td>
        <td>
        <p class='text-muted mb-0'> ".$row2['birthdate']."</p>
        </td>
        <td><p class='text-muted mb-0'>".$row2['statuss']."</p></td>
        <td>
        <div class='container d-flex px-2'> 
        <a href='update.php?id=" .$row2['id']."'> <button type='button' class='btn btn-link btn-sm btn-rounded'>
        Edit
      </button>  </a>
      <a href='delete.php?id=" .$row2['id']."'>
      <button type='button' class='btn btn-link btn-sm btn-rounded'>
      Delete
    </button></a>
        
        </div>
        </td>
      </tr>
        
        ";

    }
} else{
    $tbody= "<h5 class='card-title'>No data available</h5>";
  }


?>



<?php 

require "components/db_connect.php";

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
    <div class="container m-4">

        <div class="card border-warning mb-3 flex-row" style="width: 24.7rem;">
        <img src="pictures/<?= $row["picture"] ?>" alt="" width="170">
            <div class="card-body   ">
              <h5 class="card-title text-warning font-italic">Admin</h5>
              <p class="card-text">Hello, <?= $row["f_name"] . " " . $row["l_name"] ?></p>
              <a href="logout.php?logout"class="btn btn-outline-dark">Logout</a>
   
             </div>
        </div>

    </div>

    <div class="container d-flex justify-content-center">

<!-- 
    <table class="table table-dark table-borderd">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
     -->



     <table class="table align-middle my-5 py-3 mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Name</th>
      <th>Birth date</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
  <?php echo $tbody?>
  </tbody>
</table>

    </div>

    
</body>
</html>