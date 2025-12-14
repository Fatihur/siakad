<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Guru;
use App\Http\Controllers\Siswa;

// Auth
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [Admin\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [Admin\ProfilController::class, 'update'])->name('profil.update');
    
    // Master Data
    Route::resource('tahun-akademik', Admin\TahunAkademikController::class)->parameters(['tahun-akademik' => 'tahunAkademik']);
    Route::post('tahun-akademik/{tahunAkademik}/set-aktif', [Admin\TahunAkademikController::class, 'setAktif'])->name('tahun-akademik.set-aktif');
    Route::post('semester/{semester}/set-aktif', [Admin\TahunAkademikController::class, 'setSemesterAktif'])->name('semester.set-aktif');
    
    Route::resource('jurusan', Admin\JurusanController::class);
    Route::resource('kelas', Admin\KelasController::class);
    Route::resource('ruang', Admin\RuangController::class);
    Route::resource('mata-pelajaran', Admin\MataPelajaranController::class)->parameters(['mata-pelajaran' => 'mataPelajaran']);
    Route::get('mata-pelajaran/{mataPelajaran}/guru', [Admin\MataPelajaranController::class, 'getGuru'])->name('mata-pelajaran.guru');
    Route::resource('guru', Admin\GuruController::class);
    Route::resource('siswa', Admin\SiswaController::class);
    
    // Jam Istirahat
    Route::get('jam-istirahat', [Admin\JamIstirahatController::class, 'index'])->name('jam-istirahat.index');
    Route::post('jam-istirahat', [Admin\JamIstirahatController::class, 'store'])->name('jam-istirahat.store');
    Route::put('jam-istirahat/{jamIstirahat}', [Admin\JamIstirahatController::class, 'update'])->name('jam-istirahat.update');
    Route::delete('jam-istirahat/{jamIstirahat}', [Admin\JamIstirahatController::class, 'destroy'])->name('jam-istirahat.destroy');
    Route::post('jam-istirahat/{jamIstirahat}/toggle', [Admin\JamIstirahatController::class, 'toggle'])->name('jam-istirahat.toggle');
    
    // Jadwal
    Route::get('jadwal/generator', [Admin\JadwalController::class, 'generator'])->name('jadwal.generator');
    Route::post('jadwal/generator', [Admin\JadwalController::class, 'generatorStore'])->name('jadwal.generator.store');
    Route::resource('jadwal', Admin\JadwalController::class);
    
    // Verifikasi Nilai
    Route::get('verifikasi-nilai', [Admin\VerifikasiNilaiController::class, 'index'])->name('verifikasi-nilai.index');
    Route::get('verifikasi-nilai/{bukuNilai}', [Admin\VerifikasiNilaiController::class, 'show'])->name('verifikasi-nilai.show');
    Route::post('verifikasi-nilai/{bukuNilai}', [Admin\VerifikasiNilaiController::class, 'verifikasi'])->name('verifikasi-nilai.verifikasi');
    
    // Pengumuman
    Route::resource('pengumuman', Admin\PengumumanController::class);
});

// Guru Routes
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [Guru\DashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [Guru\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [Guru\ProfilController::class, 'update'])->name('profil.update');
    
    // Absensi
    Route::get('absensi', [Guru\AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/{jadwal}/create', [Guru\AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi/{sesi}', [Guru\AbsensiController::class, 'store'])->name('absensi.store');
    Route::post('absensi/{sesi}/tutup', [Guru\AbsensiController::class, 'tutup'])->name('absensi.tutup');
    Route::get('absensi/{jadwal}/riwayat', [Guru\AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    
    // Nilai
    Route::get('nilai', [Guru\NilaiController::class, 'index'])->name('nilai.index');
    Route::post('nilai/create', [Guru\NilaiController::class, 'create'])->name('nilai.create');
    Route::get('nilai/{bukuNilai}/edit', [Guru\NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('nilai/{bukuNilai}', [Guru\NilaiController::class, 'update'])->name('nilai.update');
    Route::post('nilai/{bukuNilai}/ajukan', [Guru\NilaiController::class, 'ajukan'])->name('nilai.ajukan');
    
    // Materi
    Route::resource('materi', Guru\MateriController::class);
    
    // Tugas
    Route::resource('tugas', Guru\TugasController::class);
    Route::post('tugas/pengumpulan/{pengumpulan}/nilai', [Guru\TugasController::class, 'nilaiPengumpulan'])->name('tugas.nilai-pengumpulan');
});

// Siswa Routes
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [Siswa\DashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [Siswa\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [Siswa\ProfilController::class, 'update'])->name('profil.update');
    
    Route::get('/jadwal', [Siswa\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/nilai', [Siswa\NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/absensi', [Siswa\AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/materi', [Siswa\MateriController::class, 'index'])->name('materi.index');
    Route::get('/tugas', [Siswa\TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{tuga}', [Siswa\TugasController::class, 'show'])->name('tugas.show');
    Route::post('/tugas/{tuga}/kumpulkan', [Siswa\TugasController::class, 'kumpulkan'])->name('tugas.kumpulkan');
});

// Notifikasi Routes (untuk semua role)
Route::middleware('auth')->group(function () {
    Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{notifikasi}/baca', [App\Http\Controllers\NotifikasiController::class, 'baca'])->name('notifikasi.baca');
    Route::post('/notifikasi/baca-semua', [App\Http\Controllers\NotifikasiController::class, 'bacaSemua'])->name('notifikasi.baca-semua');
    Route::delete('/notifikasi/{notifikasi}', [App\Http\Controllers\NotifikasiController::class, 'hapus'])->name('notifikasi.hapus');
    Route::get('/notifikasi/unread', [App\Http\Controllers\NotifikasiController::class, 'getUnread'])->name('notifikasi.unread');
});
