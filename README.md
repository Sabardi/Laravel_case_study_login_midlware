#  Case Study: Login Middleware
kita  ingin membatasi akses ke beberapa halaman menggunakan middleware.
Middleware tersebut akan memeriksa apakah user sudah login atau belum. Jika belum, blok
hak akses dan redirect ke form login. 

Proses pembatasan login ini dilakukan dengan cara memeriksa apakah sebuah session tersedia
atau tidak. Jika session ditemukan, artinya user sudah login dan halaman bisa diakses. Namun
jika session tidak ditemukan, tolak request dan redirect user ke form login.
Fitur login/logout seperti ini sebenarnya sudah ada di Laravel, yakni dari fitur Authentication
yang akan di bahas pada bab berikutnya, namun tidak ada salahnya kita buat versi manual agar
bisa lebih memahami dasar middleware dan session Laravel.


# Pembuatan Route
Hampir semua materi yang akan kita pakai sudah di bahas sebelumnya, oleh karena itu saya
akan langsung menampilkan file akhir dari project "login middleware".

use App\Http\Controllers\MahasiswaController;



Route::get('/login', [MahasiswaController::class,'login']);
Route::post('/login', [MahasiswaController::class,'prosesLogin']);
Route::get('/logout', [MahasiswaController::class,'logout']);

 Route::redirect('/', '/login');

 Route::get('/daftar-mahasiswa', [MahasiswaController::class,'daftarMahasiswa'])
 ->middleware('login');

 Route::get('/tabel-mahasiswa', [MahasiswaController::class,'tabelMahasiswa'])
 ->middleware('login');

 Route::get('/blog-mahasiswa', [MahasiswaController::class,'blogMahasiswa'])
 ->middleware('login');

Tiga route terakhir di baris 13 – 20 merupakan halaman yang akan kita proteksi (hanya bisa
diakses jika user sudah login). Perhatikan tambahan method ->middleware('login') di akhir
setiap route, inilah cara yang saya pakai untuk membatasi hak akses. 
