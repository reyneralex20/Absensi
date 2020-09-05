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
                <form method="POST" action="home.php">
                    <div class="row w-100 m-auto">
                        <div class="col form-group">
                            <label for="loginUsername">Username : </label>
                            <input type="text" class="form-control" id="loginId" name="loginTest" placeholder="Username">
                        </div>
                    </div>
                    <div class="row w-100 m-auto">
                        <div class="col form-group ">
                            <label for="loginPass">Password : </label>
                            <input type="password"  class="form-control" id="loginPass" name="passTest" placeholder="password"><br>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
            </div>
        </div>

    </body>
</html>
