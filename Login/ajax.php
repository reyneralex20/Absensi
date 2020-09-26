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

        $sql= "UPDATE absensi set scan_keluar = '".$time."' WHERE tanggal = '".$tanggal."' ";

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
