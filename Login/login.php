<?php
    require_once ("db.php");
    if(isset($_POST['login'])){
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


        // $hash=password_hash($password,PASSWORD_DEFAULT);

        $sql = "SELECT * FROM user WHERE username= '$username'";
        $result =  $conn->query($sql);
        // echo var_dump($result);

        $count=mysqli_num_rows($result);

        if($count == 1){
            while ($row = $result->fetch_assoc()) {
                if(password_verify($password,$row['password'])){
                    session_start();
                    $_SESSION['username']=$username;
                    $_SESSION['namalengkap']=$row['nama_lengkap'];
                    $_SESSION['NIP']=$row['NIP'];
                    $_SESSION['id']=$row['id'];
                    // echo var_dump($_SESSION);
                    // echo "password is valid";

                    header("Location: absen.php");
                }else{
                    echo "invalid passsword";
                }
            }
        }
    }
    if(isset($_GET['logout'])){
        session_start();
        session_destroy();
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Login</title>
    </head>

    <body>
        <div class="container text-center w-25 p-3 mx-auto mt-5 border">
            <div class="row">
                <div class="col justify-content-center">
                <h2>Login</h2>
                <form method="POST" action="">
                    <div class="row w-100 m-auto">
                        <div class="col form-group">
                            <label for="loginUsername">Username : </label>
                            <input type="text" class="form-control" id="loginId" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="row w-100 m-auto">
                        <div class="col form-group ">
                            <label for="loginPass">Password : </label>
                            <input type="password"  class="form-control" id="loginPass" name="password" placeholder="password"><br>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                </form>
            </div>
            </div>
        </div>

    </body>
</html>
