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

Tiga route merupakan halaman yang akan kita proteksi (hanya bisa
diakses jika user sudah login). Perhatikan tambahan method ->middleware('login') di akhir
setiap route, inilah cara yang saya pakai untuk membatasi hak akses. 

# Pembuatan Controller
kode pembuatan controller
 php artisan make:controller MahasiswaController

 public function daftarMahasiswa(){
        return view('halaman',['judul' => 'Daftar Mahasiswa']);
    }
    public function tabelMahasiswa(){
        return view('halaman',['judul' => 'Tabel Mahasiswa']);
    }
    public function blogMahasiswa(){
        return view('halaman',['judul' => 'Blog Mahasiswa']);
    }
    public function login(){
        return view('form-login');
    }


    public function prosesLogin(Request $request){
        $request->validate([
            'username' =>'required',
        ]);

        $validusername =  ['andi','rani','lisa','joko'];
        if (in_array($request->username, $validusername)){
            session(['username' => $request->username]);
            return redirect('/daftarmahasiswa');
        }else{
            // Username tidak ada di daftar
            return back()->withInput()->with('pesan',"Username tidak valid");
        }
    }
    public function logout(){
        // Hapus session 'username'
        session()->forget('username');
        return redirect('/login')->with('pesan','Logout berhasil');
    }

Tiga method pertama, yakni daftarMahasiswa(), tabelMahasiswa() dan blogMahasiswa()
dipakai untuk mengakses view yang sama, yakni halaman.blade.php. Selain itu, ketiganya juga
mengirim variabel judul dengan yang nilai string berbeda. Variabel judul ini bisa kita akses dari
dalam view halaman.blade.php.


# Pembuatan Middleware
Untuk membatasi hak akses ke halaman tertentu, akan ditangani oleh middleware yang saya

beri nama CekLogin. Berikut perintah php artisan untuk membuatnya:

php artisan make:middleware CekLogin

kode nya ubah menjadi seperti ini
public function handle(Request $request, Closure $next): Response
    {
        if ( session()->has('username')){
            return $next($request);
        }else{
            return redirect('/login')->with('pesan','Maaf Silahkan login terlebih dahulu');
        }
    }

diawali dengan pemeriksaan kondisi
apakah session 'username' di temukan atau tidak. Jika ditemukan (berarti user sudah login),
maka middleware CekLogin akan meneruskannya ke proses lain, yakni jalankan perintah
return $next($request).

Namun jika session 'username' tidak ditemukan, blok akses dengan cara me-redirect user ke
halaman '/login' beserta pesan "Maaf, silahkan login terlebih dahulu".

Urusan kita belum selesai, karena sebuah middleware harus didaftarkan terlebih dahulu ke file
Kernel.php. Saya ingin menjadikan CekLogin ini sebagai optional middleware, yakni
middleware yang baru akan aktif jika ditambahkan secara manual ke route atau controller.
Caranya, tulis CekLogin ke dalam property $routeMiddleware:

    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'login' => \App\Http\Middleware\CekLogin::class,
    ];
key 'login' untuk middleware CekLogin. Key ini sudah kita pasang ke
dalam route untuk membatasi akses ke halaman '/daftar-mahasiswa', '/tabel-mahasiswa' dan
'/blog-mahasiswa'.

# Pembuatan View
Untuk mini project ini saya butuh 2 buah view: form-login.blade.php untuk membuat form
login, serta halaman.blade.php untuk membuat view halaman.

cek langsung wkwkw



# Authentication
Salah satu alasan Taylor Otwell mengembangkan Laravel karena pada saat itu framework
Code Igniter tidak memiliki fitur authentication bawaan. Authentication adalah sebutan untuk
proses registrasi user, termasuk mekanisme login dan logout. Hampir semua project skala
menengah ke atas butuh sistem seperti ini. 

Oleh sebab itulah Laravel menyediakan fitur authentication bawaan yang sangat powerfull
namun juga sedikit rumit karena banyaknya hal 'magic' di Laravel. Maksudnya, untuk bisa
memodifikasi proses authentication, kita harus pelajari semua mekanisme yang dipakai
Laravel.
