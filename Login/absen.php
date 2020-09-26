<?php
    session_start();
    // echo var_dump($_SESSION);
    if(isset($_SESSION['username'])) {
        // echo "SUDAH LOGIN";
    } else {
        header("Location:login.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Home</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" style="height: 100vh">
            <div class="sidebar-header">
                <img src="/img/test1.png" class="rounded-circle" alt="usernamePP" style="width:200px;height:200px">
            </div>

            <ul class="list-unstyled components">
                <h3 class="text-center"><?php echo $_SESSION['namalengkap']; ?></h3>
                <li class="active">
                    <a href="absen.php">Absen</a>
                </li>
                <li>
                    <a href="lihatAbsensi.php">Lihat Keseluruhan Absensi</a>
                </li>
                <li>
                    <a href="login.php?logout=1">Log out</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <div class="row text-center w-25 p-3 mx-auto mt-5">
                <div class="col text-center">
                    <h1>Hello</h1>
                    <h3 class="text-center"><?php echo $_SESSION['namalengkap']; ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button type="submit" name="buttonIn" id="timeIn">Time in</button>
                    <div id="hasilTimeIn">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mt-2">
                    <button type="submit" name="buttonOut" id="timeOut" disabled="disabled"> Time out</button>
                    <div id="hasilTimeOut">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"</script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script>
        $( document ).ready(function(){
            $("#timeIn").click(()=>{
                $.ajax({
                    url: 'ajax.php',
                    data: {
                        act:'timein'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(res){
                        if(res['status']==200){
                            $("#hasilTimeIn").html("Anda telah time in pada:<br/>"+res['content']['tanggal']+"<br/>pukul<br/>"+res['content']['scan_masuk']);
                        }
                    }
                });
                $("#timeOut").removeAttr("disabled");
                $("#timeIn").attr("disabled", true);
            })

            $("#timeOut").click(()=>{
                $.ajax({
                    url:'ajax.php',
                    data:{
                        act:'timeout'
                    },
                    type:'post',
                    dataType: 'json',
                    success: function(res){
                        if(res['status']==200){
                            $("#hasilTimeOut").html("Anda telah time out pada:<br/>"+res['content']['tanggal']+"<br/>pukul<br/>"+res['content']['scan_keluar']);
                        }
                    }
                })
                $("#timeOut").attr("disabled", true);
            });
        });
    </script>
</body>

</html>
