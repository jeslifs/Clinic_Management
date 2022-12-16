<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location:login.php");
    }
?>

<html>
    <head>
        <title>
            Jesus's Clinic
        </title>
        <style>
            table, th, td {
                border:1px solid black;
            }
            #he{
                
            }
        </style>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="icon" href="logos.ico">
        <link rel="stylesheet" href="Design.css">
        <nav>
            <div id="nav_bar">
                <ul id="nav_bar_li"><?php $name= $_SESSION['username']?>
                     
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="#Home">Home</a></li>
                    <li><?php echo "Welcome ",ucwords($name) ?></li>
                </ul>
            </div>
        </nav>
         <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    </head>

    <body><br><br>
    <?php
        require_once "configure.php";
        $limit = 5;
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }else{
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $count=$offset+1;
         $sql="SELECT distinct a.`A_id`,p.F_name,a.`A_date`,a.`A_time`,ar.Reason ,d.DF_name
        FROM `appointment` as a 
        inner join patient as p
        inner join appoint_reason as ar 
        inner join doctor as d
        WHERE a.A_id=ar.A_id and a.`D_id`=d.D_id and a.A_id=p.P_id LIMIT {$offset},{$limit};
        ";
          $result=mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0)
    ?>
      <table class="table">
  <thead>
    <tr>
        <?php $sql3="SELECT count(`P_id`) FROM `patient`;"; 
           $result3=mysqli_query($conn,$sql3);
           $row3=mysqli_fetch_assoc($result3);
        
        ?>
        <h3> <center><?php echo "There are ",$row3['count(`P_id`)'], " patients"?></center></h3>
      <th scope="col">Appointment id</th>
      <th scope="col">Patient's Name</th>
      <th scope="col">Appointment Date</th>
      <th scope="col">Appointment Time</th>
      <th scope="col">Reason</th>
      <th scope="col">Doctor's Name</th>
      <th scope="col"><center>Approve/Dissapprove</center></th>
    </tr>
  </thead>
  <tbody>
    <?php 
      
          while($row=mysqli_fetch_assoc($result))
          {
            
            echo"<br>";
            $id=$row["A_id"];
            echo "
            <tr>
            <form action='delete.php' method='POST'>

  
            <td>
            <input  type='disabled' name='aid' size='1' style='background-color:#189AB4; border:none; border-radius: 5px;' value='$id' placeholder='$id'>
             </td>
            <td>$row[F_name]</td>
            <td>$row[A_date]</td>
            <td>$row[A_time]</td>
            <td>$row[Reason]</td>
            <td>$row[DF_name]</td> 
            <td >
            <input class='but' type='submit' value='Delete' style='background-color:transparent; color:red;border:none;' placeholder='DELETE'>
                    
            </td>
            </form>
            </tr>";
            //<a style='background-color:aqua;font-size: 14px;font-weight: 600;text-transform: uppercase; padding: 3px 7px;color: black; text-decoration: none; border-radius: 3px;align:center;' href='delete.php'  $row['donor_id']</a>
          }
          //$status='';
          //$status=$_post['approve'];
          //$sql1="INSERT INTO patient(status)values('$status')";
          //$stmt=$conn->prepare($sql1);


    ?>

<div class="table-responsive"style="text-align:center;align:center">
    <?php
    $sql1 = "SELECT * FROM patient";
    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

    if(mysqli_num_rows($result1) > 0){

      $total_records = mysqli_num_rows($result1);

      $total_page = ceil($total_records / $limit);

      echo '<ul class="pagination admin-pagination">';
      if($page > 1){
        echo '<li><a href="welcome_nurse.php?page='.($page - 1).'">Prev</a></li>';
      }
      for($i = 1; $i <= $total_page; $i++){
        if($i == $page){
          $active = "active";
        }else{
          $active = "";
        }
        echo '<li class="'.$active.'"><a href="welcome_nurse.php?page='.$i.'">'.$i.'</a></li>';
      }
      if($total_page > $page){
        echo '<li><a href="welcome_nurse.php?page='.($page + 1).'">Next</a></li>';
      }

      echo '</ul>';
    }
    ?>
  </div>

  </tbody>
</table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
         $('#myTable').DataTable();
        } );
     </script>
    </body>
</html>