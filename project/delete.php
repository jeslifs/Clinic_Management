<?php
require_once  "configure.php";
  $pid =$_POST['aid'] ;
  echo $pid;
$sql= "DELETE FROM `patient` WHERE `P_id`=$pid";
$result=mysqli_query($conn,$sql);
header("Location: welcome_nurse.php");
mysqli_close($conn);

 ?>
