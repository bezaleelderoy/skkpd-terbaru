<?php
include "../fpdf/fpdf.php";
include "../../koneksi.php";

// Buat objek PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// ===== HEADER (KOP SURAT) ===== //
$pdf->Image('../../gambar/logoti.png', 10, 6, 20); // Logo
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 7, 'SMK TI Bali Global Denpasar', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 7, 'Jl. Tukad Citarum No. 44 Denpasar. Bali', 0, 1, 'C');
$pdf->Cell(190, 7, 'website: https://smkti-baliglobal.sch.id | email: info@smkti-baliglobal.sch.id', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(190, 0, '', 'T', 1, 'C');
$pdf->Ln(10);

// ===== Fungsi Tampilkan Sertifikat ===== //
function tampilSertifikat($pdf, $koneksi, $angkatan, $status = NULL) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(95, 7, 'Angkatan : ' . strtoupper($angkatan), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);

    // Header Tabel
    $pdf->Cell(10, 7, 'No', 1);
    $pdf->Cell(20, 7, 'NIS', 1);
    $pdf->Cell(55, 7, 'Nama Siswa', 1);
    $pdf->Cell(60, 7, 'Jenis Kegiatan', 1);
    $pdf->Cell(33, 7, 'Status', 1);
    $pdf->Cell(12, 7, 'Kelas', 1, 1);

    $query = "SELECT NIS, Nama_Siswa, Jenis_Kegiatan, Kelas, Angkatan, Jurusan, Status
    FROM sertifikat 
    INNER JOIN siswa USING(NIS)
    INNER JOIN kegiatan USING(Id_Kegiatan)
    INNER JOIN jurusan USING(Id_Jurusan) WHERE Angkatan = '$angkatan'";
    if ($status) {
        $query .= " AND sertifikat.Status = '$status'";
    }
    $result = mysqli_query($koneksi, $query);

    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(10, 7, $no++, 1);
        $pdf->Cell(20, 7, $row['NIS'], 1);
        $pdf->Cell(55, 7, $row['Nama_Siswa'], 1);
        $pdf->Cell(60, 7, $row['Jenis_Kegiatan'], 1);
        $pdf->Cell(33, 7, $row['Status'], 1);
        $pdf->Cell(12, 7, $row['Jurusan']." ".$row['Kelas'], 1, 1);
    }
    $pdf->Ln(5);
}

// ===== Fungsi Rekap Kegiatan ===== //
function tampilRekapKegiatan($pdf, $koneksi, $angkatan = NULL, $status = NULL) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 7, 'Rekap Jenis Kegiatan Sertifikat', 0, 1, 'C');
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(120, 7, 'Jenis Kegiatan', 1);
    $pdf->Cell(70, 7, 'Total Sertifikat', 1, 1, 'C');

    // Query Data
    $query = "SELECT kegiatan.Jenis_Kegiatan, COUNT(sertifikat.Id_Kegiatan) as Total 
              FROM sertifikat 
              JOIN kegiatan ON sertifikat.Id_Kegiatan = kegiatan.Id_Kegiatan
              JOIN siswa ON sertifikat.NIS = siswa.NIS";
    $conditions = [];
    if ($angkatan) {
        $conditions[] = "siswa.Angkatan = '$angkatan'";
    }
    if ($status) {
        $conditions[] = "sertifikat.Status = '$status'";
    }
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    $query .= " GROUP BY kegiatan.Jenis_Kegiatan ORDER BY Total DESC";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(120, 7, $row['Jenis_Kegiatan'], 1);
        $pdf->Cell(70, 7, $row['Total'], 1, 1, 'C');
    }
    $pdf->Ln(5);
}

// ===== Panggil Fungsi Berdasarkan Filter User ===== //
$angkatan = isset($_COOKIE['angkatan']) ? $_COOKIE['angkatan'] : 'semua';
$status = isset($_COOKIE['status']) ? $_COOKIE['status'] : 'semua';

if ($angkatan == 'semua' && $status == 'semua') {
    $result_angkatan = mysqli_query($koneksi, "SELECT DISTINCT Angkatan FROM siswa ORDER BY Angkatan ASC");
    while ($row = mysqli_fetch_assoc($result_angkatan)) {
        tampilSertifikat($pdf, $koneksi, $row['Angkatan']);
    }
    tampilRekapKegiatan($pdf, $koneksi);
} elseif ($angkatan != 'semua' && $status == 'semua') {
    tampilSertifikat($pdf, $koneksi, $angkatan);
    tampilRekapKegiatan($pdf, $koneksi, $angkatan);
} elseif ($angkatan == 'semua' && $status != 'semua') {
    $result_angkatan = mysqli_query($koneksi, "SELECT DISTINCT Angkatan FROM siswa ORDER BY Angkatan ASC");
    while ($row = mysqli_fetch_assoc($result_angkatan)) {
        tampilSertifikat($pdf, $koneksi, $row['Angkatan'], $status);
    }
    tampilRekapKegiatan($pdf, $koneksi, NULL, $status);
} else {
    tampilSertifikat($pdf, $koneksi, $angkatan, $status);
    tampilRekapKegiatan($pdf, $koneksi, $angkatan, $status);
}

// Output PDF
$pdf->Output();
?>