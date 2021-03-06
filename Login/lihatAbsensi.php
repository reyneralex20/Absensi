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

    <title>Absen</title>

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
            <div class="sidebar-header text-center">
                <img src="/img/pp.png" class="rounded-circle" alt="usernamePP" style="width:150px;height:150px">
            </div>

            <ul class="list-unstyled components">
                <h5 class="text-center"><?php echo $_SESSION['namalengkap']; ?></h5>
                <li>
                    <a href="absen.php">Absen</a>
                </li>
                <li class="active">
                    <a href="lihatAbsensi.php">Lihat Keseluruhan Absensi</a>
                </li>
                <li>
                    <a href="login.php?logout=1">Log out</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="btn btn-primary" id="sidebarCollapse" class="btn btn-info navbar-btn">
                            <i class="fa">&#xf0c9;</i>
                        </button>
                    </div>
                </div>
            </nav>

            <div class="row">
                <div class="col text-center table-responsive-sm">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Scan Masuk</th>
                                <th>Scan Keluar</th>
                                <th>Terlambat</th>
                                <th>Pulang Cepat</th>
                                <th>Lembur</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <form class="" action="ajax.php" method="post">
                        <select class="selector" name="bulan">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select class="selector" name="tahun">
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                        <input type="submit" value="Print">
                        <input type="hidden" name="act" value="printToPdf">
                    </form>
                </div>
            </div>
        </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'ajax.php',
                data:{
                    act:'getAbsensi'
                },
                type:'post',
                dataType:'json',
                success: function(res){
                    res['content'].forEach((item, i) => {
                        console.log(item);
                        if(item['is_libur']==1){
                            $('.table').append('<tr><td>'+item['tanggal']+'</td><td>'+item['jam_masuk']+'</td><td>'+item['jam_pulang']+'</td><td colspan="6">'+item['keterangan']+'</td></tr>');
                        }else{
                            $('.table').append('<tr><td>'+item['tanggal']+'</td><td>'+item['jam_masuk']+'</td><td>'+item['jam_pulang']+'</td><td>'+item['scan_masuk']+'</td><td>'+item['scan_keluar']+'</td><td>'+item['terlambat']+'</td><td>'+item['pulang_cepat']+'</td><td>'+item['lembur']+'</td><td>'+item['jam_kerja']+'</td></tr>');
                        }
                    });
                }
            });
            // $('#btnPrint').click(()=>{
            //     $.ajax({
            //         url:'ajax.php',
            //         data:{
            //             act:'printToPdf'
            //         },
            //         type:'post',
            //         dataType:'json',
            //         success:function(res){
            //             console.log(res);
            //         }
            //     })
            // })
        })
        $('#sidebarCollapse').on('click',function(){
            $('#sidebar').toggleClass('active');
        });
    </script>
</body>

</html>
