<?php
  require_once "configure.php";

  $F_name=$M_name=$L_name=$Sex=$Address=$Dob=$A_date=$A_time=$Reason=$dname=$did=$nid='';
  $F_name_err=$M_name_err=$L_name_err=$Sex_err=$Address_err=$Dob_err=$A_date_err=$A_time_err=$Reason_err=$dname_err='';

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    //check if any input is empty
    if(empty(trim($_POST['F_name'])))
    {
      $F_name_err='First Name cannot be blank';
    }
    elseif(empty(trim($_POST['M_name'])))
    {
      $M_name_err='Middle Name cannot be empty';
    }
    elseif(empty(trim($_POST['L_name'])))
    {
      $L_name_err='Last Name cannot be empty';
    }
    elseif(empty(trim($_POST['Dob'])))
    {
      $Dob_err='DOB cannot be empty';
    }
    elseif(empty(trim($_POST['Sex'])))
    {
      $Sex_err='Sex cannot be empty';
    }
    elseif(empty(trim($_POST['Address'])))
    {
      $Address_err='Address cannot be empty';
    }
    elseif(empty(trim($_POST['A_date'])))
    {
      $A_date_err='Date cannot be empty';
    }
    elseif(empty(trim($_POST['A_time'])))
    {
      $A_time_err='Time cannot be empty';
    }
    elseif(empty(trim($_POST['Reason'])))
    {
      $Reason_err='Reason cannot be empty';
    }
    elseif(empty($_POST['dname']))
    {
      $dname_err='Specialization cannot be empty';
    }
    else
    {
      //patient
      $F_name=trim($_POST['F_name']);
      $M_name=trim($_POST['M_name']);
      $L_name=trim($_POST['L_name']);
      $Dob=trim($_POST['Dob']);
      $Sex=trim($_POST['Sex']);
      $Address=trim($_POST['Address']);
      //appointment
      $A_date=trim($_POST['A_date']);
      $A_time=trim($_POST['A_time']);
      $dname=trim($_POST['dname']);  
      //reason
      $Reason=trim($_POST['Reason']);


      
    }

    //patient
    if(empty($F_name_err)&& empty($M_name_err)&& empty($L_name_err)&& empty($Dob_err)&& empty($Sex_err)&& empty($Address_err))
    {
        $sql1="INSERT INTO patient (F_name,M_name,L_name,Dob,Sex,Address) VALUES(?,?,?,?,?,?)";
        $stmt=mysqli_prepare($conn,$sql1);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_fname,$param_mname,$param_lname,$param_dob,$param_sex,$param_address);

            //set the parameters
            $param_fname=$F_name;
            $param_mname=$M_name;
            $param_lname=$L_name;
            $param_dob=$Dob;
            $param_sex=$Sex;
            $param_address=$Address;
            if(mysqli_stmt_execute($stmt))
              {
                mysqli_stmt_store_result($stmt);
              }
        }
        mysqli_stmt_close($stmt);
    }
    //appointment
    if(empty($A_date_err)&& empty($A_time_err))
    {
      
      $p="SELECT `N_id`,`D_id` FROM `doctor` WHERE `S_id`=$dname";
      $result1=mysqli_query($conn, $p);
      while($row1=mysqli_fetch_assoc($result1))
      {
        echo $row1['D_id'];
        echo"<br>";
        $did=$row1['D_id'];
        $nid=$row1['N_id'];
      }
      
        $sql2="INSERT INTO `appointment`(D_id,N_id,A_date,A_time)values('$did','$nid','$A_date','$A_time')";
          $stmt=$conn->prepare($sql2);
       

        if($stmt)
        {
          if(mysqli_stmt_execute($stmt))
          {
           
            mysqli_stmt_store_result($stmt);
          }
        }
        mysqli_stmt_close($stmt);
    }

    //reason
    if( empty($Reason_err))
    {

      $_aid="SELECT max(`A_id`) FROM `appointment`";
      $result1=mysqli_query($conn, $_aid);
      while($row1=mysqli_fetch_assoc($result1))
      {
        echo $row1['max(`A_id`)'];
        echo"<br>";
        $i=$row1['max(`A_id`)'];
      }
      echo $i."<br>";
      $sql3="INSERT INTO appoint_reason(A_id,Reason)values('$i','$Reason')";
      $stmt=$conn->prepare($sql3);
        if($stmt)
        {
          
          if(mysqli_stmt_execute($stmt))
          {            
            mysqli_stmt_store_result($stmt);
          }

        }
        mysqli_stmt_close($stmt);
    }


    //appoint_taken
    $Pi="SELECT max(`P_id`) FROM `patient`";
      $result3=mysqli_query($conn, $Pi);
      while($row3=mysqli_fetch_assoc($result3))
      {
        echo $row3['max(`P_id`)'];
        echo"<br>";
        $P=$row3['max(`P_id`)'];
      }

      $Ai="SELECT max(`A_id`) FROM `appointment`";
      $result4=mysqli_query($conn, $Ai);
      while($row4=mysqli_fetch_assoc($result4))
      {
        echo $row4['max(`A_id`)'];
        echo"<br>";
        $A=$row4['max(`A_id`)'];
      }
      
        $sql5="INSERT INTO `appointment_taken`(P_id,A_id)values('$P','$A')";
          $stmt=$conn->prepare($sql5);

          if($stmt)
          {
            if(mysqli_stmt_execute($stmt))
            {
             
              mysqli_stmt_store_result($stmt);
            }
          }
          mysqli_stmt_close($stmt);

      //p_history
      if(isset($_POST['Submit']))
      {
          $pid="SELECT max(`P_id`) FROM `patient`";
          $result=mysqli_query($conn, $pid);
          while($row=mysqli_fetch_assoc($result))
          {
            echo $row['max(`P_id`)'];
            echo"<br>";
            $id=$row['max(`P_id`)'];
          }
          
          //insert check box values
          $history=implode(',',$_POST['history']);
          //insert into database
          $sql6="INSERT INTO patient_history(P_id,P_history)values('$id','$history')";
          $stmt=$conn->prepare($sql6);
          
      }
      
      if(mysqli_stmt_execute($stmt))
      {
          mysqli_stmt_store_result($stmt);
          header("location:welcome_patient.php");
      }
      else
      {
          echo "Something went wrong... cannot redirect!";
      }
      mysqli_stmt_close($stmt);
        
    
    mysqli_close($conn);

  }

?>


<html>
    <head>
        <title>Jesus's Clinic</title>
        <link rel="icon" href="logos.ico">
        <link rel="stylesheet" href="Design.css">
        <link rel="stylesheet" href="Appointment.css">
    </head>
    <body><center><h2 style="color:white;">Book Your Appointment</h2>
        <form method="post"><br><br>
  

  <label>First Name:</label>
  <input type="text" id="" name="F_name" placeholder="Enter First name" required><br>
  
  <label>Middle Name:</label>
  <input type="text" id="" name="M_name" placeholder="Enter Middle name" required><br>

  <label>Last name:</label>
  <input type="text" id="" name="L_name" placeholder="Enter Last name" required><br>
  

  <label>DOB:</label>
  <input type="date" id="" name="Dob" required><br>
  

  <label>Sex:</label>
  <select name="Sex" id="" required>
    <option value="" selected disabled>Choose an option...</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
  </select><br>

  <label>Address:</label>
  <textarea name="Address" id="" cols="30" rows="10" placeholder="Enter Address..." required></textarea><br>
  
  <fieldset><legend><label>Patient Medical History:</label></legend>
    <br><input type="checkbox" name="history[]" value="Heart problem">Heart problem<br><br>
    <input type="checkbox" name="history[ ]" value="Hyper tension">Hyper Tension<br><br>
    <input type="checkbox" name="history[ ]" value="Kidney problem">Kidney problem<br><br>
    <input type="checkbox" name="history[ ]" value="Asthama/Breathing problem">Asthma/Breathing problem<br><br>
    <input type="checkbox" name="history[ ]" value="Surgeries">Surgeries<br><br>
    <input type="checkbox" name="history[ ]" value="Diabetes">Diabetes<br><br>
    <input type="checkbox" name="history[ ]" value="cancer">cancer<br><br>
    <input type="checkbox" name="history[ ]" value="Chest pain">Chest pain<br><br>
  </fieldset><br>

  <label>Appointment With:</label>
  <select name="dname" id="">
    <option value="" selected disabled>Choose an option...</option>
    <option value="1">Cardiologist</option>
    <option value="2">Dentist</option>
    <option value="3">Dermotologist</option>
    <option value="4">ENT</option>
    <option value="5">General Physician</option>
    <option value="6">Allergists</option>
  </select><br>

  <label>Reason for Appointment:</label>
  <textarea name="Reason" id="" cols="30" rows="10" placeholder="Enter Reason..." required></textarea><br>  
  
  <label>Appointment Date:</label>
  <input type="date" id="" name="A_date" required><br>

  <label>Appointment time:</label>
  <input type="time" id="" name="A_time" required><br>

  <input type="submit" name="Submit"><input type="reset">
</form>
   </center></body>
</html>        
        
