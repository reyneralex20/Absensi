<?php
include 'db.php';
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
session_start();

if(isset($_POST['act'])) {
    switch ($_POST['act']) {
        case 'timein':
        date_default_timezone_set ("Asia/Jakarta");
        $time= date("H:i:s");
        $t=time();
        $tanggal=date("Y-m-d",$t);

        $sql="INSERT INTO absensi (user_id,tanggal,scan_masuk) values ('".$_SESSION['id']."','".$tanggal."','".$time."') ";
        $dataUser= array(
            "scan_masuk"=>$time,
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

        $sqlTimeIn="SELECT scan_masuk, jam_masuk, jam_pulang FROM absensi WHERE user_id= '".$_SESSION['id']."' and tanggal = '".$tanggal."' and scan_keluar is null";
        $result=$conn->query($sqlTimeIn);
        $rows = $result->fetch_assoc();
        $epoch_jamMasuk = strtotime($rows['jam_masuk']);
        $epoch_jamPulang = strtotime($rows['jam_pulang']);
        $epoch_scanMasuk = strtotime($rows['scan_masuk']);
        $epoch_scanKeluar = strtotime($time);
        $jamLembur='00:00';
        $jamKerja ='00:00';

        // echo var_dump($rows, $epoch_jamMasuk, $epoch_jamPulang);
        if($epoch_scanMasuk>$epoch_jamMasuk){
            $terlambat = "Ya";
        }else{
            $terlambat = "Tidak";
        }

        if($epoch_jamPulang>$epoch_scanKeluar){
            $pulangCepat = "Ya";
        }else{
            $pulangCepat = "Tidak";
            $diffLembur = abs(strtotime($time) - strtotime($rows['jam_pulang']));

            // Convert $diff to minutes
            $tminsLembur = $diffLembur/60;

            // Get hours
            $hoursLembur = floor($tminsLembur/60);
            if($hoursLembur < 10) $hoursLembur = str_pad($hoursLembur, 2, '0', STR_PAD_LEFT);

            // Get minutes
            $minsLembur = $tminsLembur%60;
            if($minsLembur < 10) $minsLembur = str_pad($minsLembur, 2, '0', STR_PAD_LEFT);

            $jamLembur = $hoursLembur.":".$minsLembur;
        }

        $diffKerja = abs(strtotime($rows['scan_masuk']) - strtotime($rows['jam_masuk']));

        // Convert $diff to minutes
        $tminsKerja = $diffKerja/60;

        // Get hours
        $hoursKerja = floor($tminsKerja/60);
        if($hoursKerja < 10) $hoursKerja= str_pad($hoursKerja, 2, '0', STR_PAD_LEFT);

        // Get minutes
        $minsKerja = $tminsKerja%60;
        if($minsKerja < 10) $minsKerja = str_pad($minsKerja, 2, '0', STR_PAD_LEFT);

        $jamKerja = $hoursKerja.":".$minsKerja;
        // echo var_dump($jamLembur, $jamKerja);

        $sql= "UPDATE absensi set terlambat= '".$terlambat."', pulang_cepat='".$pulangCepat."', lembur='".$jamLembur."', jam_kerja='".$jamKerja."', scan_keluar = '".$time."' WHERE tanggal = '".$tanggal."' ";


        $dataUser=array(
            "scan_keluar"=>$time,
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

        case 'libur':
            date_default_timezone_set ("Asia/Jakarta");
            $time= date("H:i:s");
            $t=time();
            $tanggal=date("Y-m-d",$t);

            $sql="INSERT INTO absensi (user_id,tanggal,is_libur,keterangan) values ('".$_SESSION['id']."','".$tanggal."','1','".$_POST['keterangan']."') ";
            $dataUser= array(
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

        case 'getAbsensi':
        $sql= "SELECT * FROM absensi WHERE user_id= '".$_SESSION['id']."' order by tanggal asc";
        $result = $conn->query($sql);

        $dataUser=array();

        while($row = $result->fetch_assoc()) {
            array_push($dataUser,$row);
        }
        $data['content']=$dataUser;
        echo json_encode($data);

        $conn->close();
        break;

        case 'printToPdf':
        // echo var_dump($_POST);

        $html = file_get_contents("pdf.html");
        $html = str_replace("{noId}", $_SESSION['id'], $html);
        $html = str_replace("{nama}", $_SESSION['namalengkap'],$html);
        $html = str_replace("{nip}",$_SESSION['NIP'],$html);
        //
        $sql= "SELECT * FROM absensi WHERE user_id= '".$_SESSION['id']."' and month(`tanggal`)= '".$_POST['bulan']."' and year(`tanggal`)='".$_POST['tahun']."' order by tanggal asc";
        $result = $conn->query($sql);
        // echo var_dump($result->fetch_all(MYSQLI_ASSOC));
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $startDate=$rows[0]['tanggal'];
        $endDate=$rows[sizeof($rows)-1]['tanggal'];
        date_default_timezone_set ("Asia/Jakarta");
        $tanggalTTD=date("d-m-Y");


        // echo var_dump($startDate,$endDate);

        $conn->close();

        $dataUser=array();

        $tbl="";
        // echo var_dump($rows);
        if(empty($rows)){
            $tbl.="<tr>"
            ."<td colspan='9'>Data absensi tidak tersedia</td>"
            ."</tr>";
        }else{
            foreach($rows as $row) {
                if($row['is_libur']==1){
                    $tbl.="<tr>"
                    ."<td>".$row['tanggal']."</td>"
                    ."<td>".$row['jam_masuk']."</td>"
                    ."<td>".$row['jam_pulang']."</td>"
                    ."<td colspan='6'>".$row['keterangan']."</td>"
                    ."</tr>";
                }else{
                    $tbl.="<tr>"
                    ."<td>".$row['tanggal']."</td>"
                    ."<td>".$row['jam_masuk']."</td>"
                    ."<td>".$row['jam_pulang']."</td>"
                    ."<td>".$row['scan_masuk']."</td>"
                    ."<td>".$row['scan_keluar']."</td>"
                    ."<td>".$row['terlambat']."</td>"
                    ."<td>".$row['pulang_cepat']."</td>"
                    ."<td>".$row['lembur']."</td>"
                    ."<td>".$row['jam_kerja']."</td>"
                    ."</tr>";
                }
            }
        }
        $html = str_replace("{tableBody}", $tbl, $html);
        $html = str_replace("{tglMulai}",$startDate, $html);
        $html = str_replace("{tglSelesai}", $endDate, $html);
        $html = str_replace("{tglttd}", $tanggalTTD, $html);

        // echo $html;
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("absensi.pdf");

        $data['content']=$dataUser;
        echo json_encode($data);

        break;
    }
}
?>
