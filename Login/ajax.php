<?php
include 'db.php';
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
session_start();
date_default_timezone_set("Asia/Jakarta");

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

if(isset($_POST['act'])) {
    switch ($_POST['act']) {
        case 'timein':
            $timeIn = date("Y-m-d H:i:00");
            $scanMasuk = date("H:i");
            $sql="INSERT INTO $table_absensi (user_id, time_in, scan_masuk) values ('".$_SESSION['id']."','".$timeIn."', '".$scanMasuk."') ";
            $dataUser= array(
                "scan_masuk"=>$timeIn
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
            $timeOut = date("Y-m-d H:i:00");
            $scanKeluar = date("H:i");
    
            $sqlTimeIn = "SELECT * FROM $table_absensi WHERE `user_id`='".$_SESSION['id']."' and `is_libur`='0' and `time_out` is null";
            $result=$conn->query($sqlTimeIn);
            $rows = $result->fetch_assoc();
            $epoch_jamMasuk = strtotime($jam_masuk);
            $epoch_jamPulang = strtotime($jam_pulang);
            $epoch_scanMasuk = strtotime($rows['time_in']);
            $epoch_scanKeluar = strtotime($timeOut);
            
            $diffMasuk = $epoch_jamMasuk - $epoch_scanMasuk;
            $diffKeluar = $epoch_scanKeluar - $epoch_jamPulang;
            $jamKerja = $epoch_scanKeluar - $epoch_scanMasuk;
            $timeKerja = convertToHoursMins(abs(floor($jamKerja/60)));

            # cek jika terlambat
            if($diffMasuk < 0) {
                $menitTerlambat = abs(floor($diffMasuk/60));
                $timeTerlambat = convertToHoursMins($menitTerlambat);
            }

            # cek jika pulang cepat atau lembur
            if($diffKeluar < 0) {
                $menitPulangCepat = abs(floor($diffKeluar/60));
                $timePulangCepat = convertToHoursMins($menitPulangCepat);
            } else {
                $menitLembur = abs(floor($diffKeluar/60));
                $timeLembur = convertToHoursMins($menitLembur);
            }
            
            $sql = "UPDATE $table_absensi set terlambat='".$timeTerlambat."', pulang_cepat='".$timePulangCepat."', lembur='".$timeLembur."', jam_kerja='".$timeKerja."', time_out = '".$timeOut."', scan_keluar = '".$scanKeluar."' WHERE id_absensi='".$rows['id_absensi']."'";

            $dataUser=array(
                "scan_keluar"=>$timeOut,
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
            $libur = date("Y-m-d");

            $sql="INSERT INTO $table_absensi (user_id,time_in,is_libur,keterangan) values ('".$_SESSION['id']."','".$libur."','1','".$_POST['keterangan']."') ";
            $dataUser= array(
                "tanggal"=>$libur
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
            parse_str($_POST['form'], $forms);
            $sql= "SELECT * FROM $table_absensi WHERE user_id= '".$_SESSION['id']."' and month(time_in)='".$forms['bulan']."' and year(time_in)='".$forms['tahun']."' order by time_in asc";
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
            $html = file_get_contents("pdf.html");
            $html = str_replace("{noId}", $_SESSION['id'], $html);
            $html = str_replace("{nama}", $_SESSION['namalengkap'],$html);
            $html = str_replace("{nip}",$_SESSION['NIP'],$html);
            //
            $sql= "SELECT * FROM $table_absensi WHERE user_id= '".$_SESSION['id']."' and month(`time_in`)= '".$_POST['bulan']."' and year(`time_in`)='".$_POST['tahun']."' order by time_in asc";
            $result = $conn->query($sql);
            // echo var_dump($result->fetch_all(MYSQLI_ASSOC));
            $rows = $result->fetch_all(MYSQLI_ASSOC);
    
            $startDate=$rows[0]['time_in'];
            $endDate=$rows[sizeof($rows)-1]['time_in'];
            date_default_timezone_set ("Asia/Jakarta");
            $tanggalTTD=date("d/m/Y");
    
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
                        ."<td>".date("d/m/Y", strtotime($row['time_in']))."</td>"
                        ."<td>".$row['jam_masuk']."</td>"
                        ."<td>".$row['jam_pulang']."</td>"
                        ."<td colspan='6'>".$row['keterangan']."</td>"
                        ."</tr>";
                    }else{
                        $tbl.="<tr>"
                        ."<td>".date("d/m/Y", strtotime($row['time_in']))."</td>"
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
            $html = str_replace("{tglMulai}", date("d/m/Y", strtotime($startDate)), $html);
            $html = str_replace("{tglSelesai}", date("d/m/Y", strtotime($endDate)), $html);
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
            $dompdf->stream("absensi-".$_POST['bulan']."-".$_POST['tahun'].".pdf");
    
            $data['content']=$dataUser;
            echo json_encode($data);
        break;
        case 'getMonths':
            $q_months = $conn->query("select distinct month(time_in) as month from $table_absensi WHERE user_id= '".$_SESSION['id']."'");
            $months_raw = $q_months->fetch_all(MYSQLI_ASSOC);
            
            $q_year = $conn->query("select distinct year(time_in) as year from $table_absensi WHERE user_id= '".$_SESSION['id']."'");
            $years_raw = $q_year->fetch_all(MYSQLI_ASSOC);
            
            $months = [];
            $years = [];
            foreach($months_raw as $mr) {
                $dateObj = DateTime::createFromFormat('!m', (int) $mr['month']);
                $monthName = $dateObj->format('F');
                $months[] = [
                    'val' => $mr['month'],
                    'text'=> $monthName
                ];
            }
            foreach($years_raw as $yr) {
                $years[] = $yr['year'];
            }
            $result = [
                'months' => $months,
                'years' => $years
            ];
            echo json_encode($result);
            break;
        case 'checkHasTimed':
            $q_timed = $conn->query("SELECT * FROM _absensi WHERE user_id= '".$_SESSION['id']."' and date(time_in) = CURDATE() and time_out is null and is_libur='0'");
            $timed = $q_timed->fetch_assoc();
            
            $q_libur = $conn->query("SELECT * FROM _absensi WHERE user_id= '".$_SESSION['id']."' and date(time_in) = CURDATE() and is_libur='1'");
            $libur = $q_libur->fetch_assoc();
            
            $result = [
                'status' => 1,
                'timed' => [],
                'libur' => []
            ];
            
            if(!is_null($timed)) {
                $result['status'] = -1;
                $result['timed'] = $timed;
            } else if(!is_null($libur)) {
                $result['status'] = -2;
                $result['libur'] = $libur;
            }
            echo json_encode($result);
            break;
    }
}
