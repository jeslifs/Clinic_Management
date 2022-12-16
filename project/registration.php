<?php
require_once "configure.php";
    $username = $password = "";
    $type='p';
    $username_err = $password_err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //check if username is empty
        if(empty(trim($_POST['username'])))
        {
            $username_err='Username cannot be blank';
        }
        else
        {
            $sql="SELECT id FROM users WHERE username = ?";
            $stmt=mysqli_prepare($conn,$sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                //set the value of param username
                $param_username=trim($_POST['username']);

                //try execute this statement
                if(mysqli_stmt_execute($stmt))
                {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt)==1)
                    {
                        $username_err="This username is already taken";
                    }
                    else
                    {
                        $username=trim($_POST['username']);
                    }
                }
                else
                {
                    echo "Something went wrong.";
                }
            }
        }
        
    
    //check for password
    if(empty(trim($_POST['password'])))
    {
        $password_err='Password cannot be blanked';
    }
    elseif(strlen(trim($_POST['password']))<5)
    {
        $password_err="Password cannot be less than 5 character";
    }
    else
    {
        $password=trim($_POST['password']);
    }

    

    //if no errors insert into database
    if(empty($username_err)&& empty($password_err))
    {
        $sql="INSERT INTO users (username,password,type) VALUES(?,?,'p')";
        $stmt=mysqli_prepare($conn,$sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_username,$param_password);

            //set the parameters
            $param_username=$username;
            $param_password=password_hash($password,PASSWORD_DEFAULT);

            //try to execute the query
            if(mysqli_stmt_execute($stmt))
            {
                header("location:login.php");
            }
            else
            {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<html>
    <head>
        <title>Jesus's Clinic</title>
        <link rel="icon" href="logos.ico">
        <link rel="stylesheet" href="Design.css">
    </head>
    <body>
        <div class="login-box">
            <h2>Register</h2>
            <form action="" method="post">
              
              <div class="user-box">
                <input type="text" name="username" required="">
                <label>Username</label>
              </div>
              <div class="user-box">
                <input type="password" name="password" required="">
                <label>Password</label>
              </div>
              <a href="#">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <input id="login_but" type="submit" value="submit">
              </a>
            </form>
          </div>
    </body>
</html>