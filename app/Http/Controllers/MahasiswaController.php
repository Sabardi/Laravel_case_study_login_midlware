<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //
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
            return redirect('/daftarMahasiswa');
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
}
