<?php
include 'db.php';
session_start();

if(isset($_POST['act'])) {
    switch ($_POST['act']) {
        case 'timein':
            date_default_timezone_set ("Asia/Jakarta");
            $time= date("H:i:s");
            $t=time();
            $tanggal=date("Y-m-d",$t);

            $sql="INSERT INTO absensi (user_id,tanggal,jam_masuk) values ('".$_SESSION['id']."','".$tanggal."','".$time."')";

            $dataUser= array(
                "jam_masuk"=>$time,
                "tanggal"=>$tanggal
            );

            if($conn->query($sql)==TRUE){
                $status=200;
                $data['status']=$status;
                $data['content']=$dataUser;
                echo json_encode($data);
            }else{
                $status=500;
                $data['status']=$status;
                $data['msg']='error while inserting';
                echo json_encode($data);
            }
            $conn->close();
            break;

        case 'timeout':
            date_default_timezone_set ("Asia/Jakarta");
            $time= date("H:i:s");
            $t=time();
            $tanggal=date("Y-m-d",$t);

            $sql= "UPDATE absensi set jam_pulang = '".$time."' WHERE tanggal = '".$tanggal."' ";

            $dataUser=array(
                "jam_pulang"=>$time,
                "tanggal"=>$tanggal
            );

            if($conn->query($sql)==TRUE){
                $status=200;
                $data['status']=$status;
                $data['content']=$dataUser;
                echo json_encode($data);
            }else{
                $status=500;
                $data['status']=$status;
                $data['msg']='error while inserting';
                echo json_encode($data);
            }
            $conn->close();
            break;


    }
}
?>
