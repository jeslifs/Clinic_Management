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

    ?>
      <table class="table">
  <thead>
    <tr>
      <th scope="col">Patient id</th>

      <th scope="col">Appointment Date</th>
      <th scope="col">Appointment Time</th>
      <th scope="col">First Name</th>
      <th scope="col">Patient's History</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      
        $sql="SELECT distinct dp.P_id,dp.F_name,dp.A_date,dp.A_time,ph.P_history FROM `doc_patient` as dp INNER join patient_history as ph WHERE dp.P_id=ph.P_id and dp.DF_name='$name';";
          $result=mysqli_query($conn, $sql);
          while($row=mysqli_fetch_assoc($result))
          {
            
            echo"<br>";
            $id=$row["P_id"];
            echo("<tr>
            <td>$row[P_id]</td>
            <td>$row[A_date]</td>
            <td>$row[A_time]</td>
            <td>$row[F_name]</td>
            <td>$row[P_history]</td>
            </tr>");
          }
    ?>


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