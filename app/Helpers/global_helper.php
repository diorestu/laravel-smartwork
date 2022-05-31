<?php

use App\Models\Absensi;
use App\Models\Cabang;
use App\Models\User;
use App\Models\UserShift;
use Carbon\Carbon;

function btnDelete() {
    return "#e34b4b";
}
function btnTerima()
{
    return "#38a877";
}
function btnTolak()
{
    return "#e34b4b";
}

function nomorUrut($int)
{
    $no = 1;
    if ($int) {
        $latest = sprintf("%03s", abs($int + 1));
    } else {
        $latest = sprintf("%03s", $no);
    }
    return $latest;
}

function bulanRomawi()
{
    $a = Carbon::now();
    $romawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $b = $romawi[$a->month];
    return $b;
}

function hapusTitikAngka($int)
{
    $a = str_replace(".", "", $int);
    return $a;
}

function rupiah($nilai, $pecahan = 0)
{
    return "Rp. " . number_format($nilai, $pecahan, ',', '.');
}

function pecahTanpaRp($nilai, $pecahan = 0)
{
    return number_format($nilai, $pecahan, ',', '.');
}

function ubahAngka($str)
{
    $a = (int) $str;
    return $a;
}

function penomoranSurat($kode, $urut, $init, $bulan, $tahun)
{
    $nomor = $kode . '' . $urut . '/' . $init . '/' . $bulan . '/' . $tahun;
    return $nomor;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
    $temp = '';
    if ($nilai < 12) {
        $temp = ' ' . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = penyebut($nilai - 10) . ' belas';
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai / 10) . ' puluh' . penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = ' seratus' . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . ' ratus' . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = ' seribu' . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . ' ribu' . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . ' juta' . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . ' milyar' . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . ' trilyun' . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = 'minus ' . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
function removeNol($angka) {
    $angkaTanpaNol = str_replace("0", "", $angka);
    return $angkaTanpaNol;
}
function tambahNol($angka)
{
    if (strlen($angka) == 1) {
        $angkaDenganNol = "0".$angka;
    }
    else {
        $angkaDenganNol = $angka;
    }
    return $angkaDenganNol;
}
function tanggalIndo($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('dddd, LL');
}
function tanggalIndoWaktu($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('ll HH:mm');
}
function tanggalIndoWaktu2($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('LL HH:mm');
}
function tanggalIndoWaktuLengkap($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('dddd, LL HH:mm');
}
function tglIndo2($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('L');
}
function tanggalIndo3($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('ll');
}
function TampilJamMenit($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('HH:mm');
}
function TampilTanggal($date)
{
    return Carbon::parse($date)->locale('id')->format('Y-m-d');
}
function BulanTahun($date)
{
    return Carbon::parse($date)->locale('id')->isoFormat('MMMM Y');
}
function TanggalOnly($date)
{
    $tanggal = Carbon::parse($date)->locale('id')->format('d');
    $tgl     = ltrim($tanggal, '0');
    return $tgl;
}
function hoursandmins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function telat($start_time, $finish_time, $shift) {
    if ($shift == "L") {
        echo "<span>-</span>";
    } else {
        $jamawal        = Carbon::parse($start_time);
        $jamakhir       = Carbon::parse($finish_time);
        $totalDuration  = $jamawal->diffInMinutes($jamakhir, false);
        $jam_menit      = hoursandmins($totalDuration, '%0dj, %02dm');

        if ($totalDuration > 1) {
            echo "<span class='text-danger'>" . $jam_menit . "</span>";
        } else {
            echo "<span>On time</span>";
        }
    }
}
function JamOnly($date)
{
    if ($date != null) {
        $jam    = Carbon::parse($date)->locale('id')->isoFormat('HH');
        $jam2   = str_replace("0", "", $jam);
    }
    else {
        $jam2 = 0;
    }
    return $jam2;
}
function Bulan($date)
{
    $dateObj   = DateTime::createFromFormat('!m', $date);
    return Carbon::parse($dateObj)->locale('id')->isoFormat('MMMM');
}
function converttanggal($date)
{
    $temp = explode("-", $date);
    $tahun = $temp[0];
    $bl = $temp[1];
    $tanggal = $temp[2];
    $waktu = $bl . "/" . $tanggal . "/" . $tahun;
    return $waktu;
}
function inverttanggal($date)
{
    if ($date == "") {
        $tgl_ukur_bener = "0000-00-00";
    } else {
        $temp = explode("/", $date);
        $bl = $temp[0];
        $tanggal = $temp[1];
        $tahun = $temp[2];
        $tgl_ukur_bener = $tahun . "-" . $bl . "-" . $tanggal;
    }
    return str_replace(' ', '', $tgl_ukur_bener);
}
function ubahKeTanggal($datetime) {
    $tanggal = date("Y-m-d", strtotime($datetime));
    return $tanggal;
}
function masaKerja($tanggal)
{
    $awal  = new DateTime($tanggal);
    $akhir = new DateTime();
    $diff  = $awal->diff($akhir);
    $tahun = $diff->y . ' tahun, ';
    $bulan = $diff->m . ' bulan';
    $hari  = $diff->d . ' hari, ';
    $jam   = $diff->h . ' jam, ';
    $menit = $diff->i . ' menit, ';
    $detik = $diff->s . ' detik, ';
    $masakerja = $tahun . $bulan;
    return $masakerja;
}
function getTahunKerja($tanggal)
{
    $awal  = new DateTime($tanggal);
    $akhir = new DateTime();
    $diff  = $awal->diff($akhir);
    $tahun = $diff->y;
    return $tahun;
}
function selisihJam($awal, $akhir)
{
    $awal  = Carbon::parse($awal);
    $akhir = Carbon::parse($akhir);
    $diff  = $akhir->diffInMinutes($awal);
    return $diff;
}
function hariKerja($user, $awal, $akhir) {
    $data       = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                ->where('shifts.nama_shift', '!=', "L")
                ->where('id_user', $user)
                ->whereBetween('tanggal_shift', [$awal, $akhir])->count();
    return $data;

}
function tepatWaktu($user, $awal, $akhir)
{
    $hitung     = 0;
    $data       = Absensi::whereBetween('jam_hadir', [$awal, $akhir])->where('id_user', $user)->get();
    foreach ($data as $d) {
        $jam_hadir = $d->jam_hadir;
        $tgl_absen = TampilTanggal($d->jam_hadir);
        $cek_shift = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                    ->where('user_shifts.tanggal_shift', '=', $tgl_absen)->first();
        $jam_shift = $cek_shift->hadir_shift;
        $waktu_shift = $tgl_absen . " " . $jam_shift;

        if ($cek_shift->nama_shift != "L") {
            $jamawal        = Carbon::parse($waktu_shift);
            $jamakhir       = Carbon::parse($jam_hadir);
            $totalDuration  = $jamawal->diffInMinutes($jamakhir, false);
            if ($totalDuration <= 0) {
                $hitung++;
            }
        }
    }
    return $hitung;
}
function namaCabang($id_cabang) {
    $cb = Cabang::where('id', $id_cabang)->first();
    return $cb->cabang_nama;
}
function namaUser($id_user)
{
    $usr = User::where('id', $id_user)->first();
    return $usr->nama;
}
function terlambat($user, $awal, $akhir)
{
    $hitung     = 0;
    $data       = Absensi::whereBetween('jam_hadir', [$awal, $akhir])->where('id_user', $user)->get();
    foreach ($data as $d) {
        $jam_hadir = $d->jam_hadir;
        $tgl_absen = TampilTanggal($d->jam_hadir);
        $cek_shift = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
            ->where('user_shifts.tanggal_shift', '=', $tgl_absen)->first();
        $jam_shift = $cek_shift->hadir_shift;
        $waktu_shift = $tgl_absen . " " . $jam_shift;

        if ($cek_shift->nama_shift != "L") {
            $jamawal        = Carbon::parse($waktu_shift);
            $jamakhir       = Carbon::parse($jam_hadir);
            $totalDuration  = $jamawal->diffInMinutes($jamakhir, false);
            if ($totalDuration > 0) {
                $hitung++;
            }
        }
    }
    return $hitung;
}
function mangkir($user, $awal, $akhir)
{
    $mangkir = 0;
    $data   = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                            ->where('user_shifts.id_user', '=', $user)
                            ->where('shifts.nama_shift', '!=', "L")
                            ->whereBetween('user_shifts.tanggal_shift', [$awal, $akhir])->get();
    foreach ($data as $d) {
        $tgl        = $d->tanggal_shift;
        $cekAbsen   = Absensi::where("id_user", $user)->whereDate('jam_hadir', $tgl)->where('id_user', $user)->count();
        if ($cekAbsen <= 0) {
            $mangkir++;
        }
    }
    return $mangkir;
}
