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
                    <li><a href="about.php">About</a></li> 
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="appointment.php">Appointment</a></li>
                    <li><a href="#Home">Home</a></li>
                    <li><?php echo "Welcome ",ucwords($name) ?></li>
                </ul>
            </div>
        </nav>
    </head>
    <hr>
    <hr>
    <body><br><br>
        <div id="div_p">
            <p><b>When you need answers,<br>you know where to</p><p id="go" style="left:160px; position:relative;text-shadow: 0 0 5px greenyellow,
            0 0 25px greenyellow,
            0 0 50px greenyellow,
            0 0 100px greenyellow;" >go <sup style="color:rgb(224, 53, 53); font-size: 38px; animation-name:cross; animation-duration:7s;  
            font-family: Arial, Helvetica, sans-serif;  animation-iteration-count: infinite; text-shadow: 0 0 5px rgb(255, 0, 0),
            0 0 25px rgb(255, 255, 255),
            0 0 50px rgb(255, 0, 0),
            0 0 100px rgb(255, 0, 0); ">+</sup></b></p>
            <div id="ambulance">
                <img id="ambulance_right" src="ambulance_right.png" alt="ambulance" style="width:30px;height:29px;">
                <img id="ambulance_left" src="ambulance_left.png" alt="ambulance" style="width:30px;height:29px;">              
            </div>
        </div><br><br><hr><hr><br><br>

        <section id="cards">
            <!-- <div id="c_left">
                <h3 style="font-size:25px"><i><u>More experience</u></i></h3><br>
                <p style="padding: 5px; font-size: 23px;"><i>The patients we treat each year prepares us to treat the one who matters most - you.</i></p>
            </div>
            
            <div id="c_right">
                <h3 style="font-size:25px"><i><u>The right answers</i></u></h3><br>
                <p style="padding: 5px; font-size: 23px;"><i> Count on our experts to deliver an accurate diagnosis and the right plan for you the first time.</i></p>
            </div>

            <div id="c_center">
                <h3 style="font-size:25px"><i><u>You come first</u></i></h3><br>
                <p style="padding: 5px; font-size: 23px;"><i>Treatment at Jesus's Clinic is a truly human experience. You're cared for as a person first.</i></p>
            </div>-->
        </section>
    </body>
</html>