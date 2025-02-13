<?php

namespace Modules\Pkl\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PklController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            // Jika sudah login, tampilkan halaman dashboard
            $userId = Auth::user()->id;
            $roleActive = session('akses_module');
            $shortcut = [];
            return view('pkl::index', compact('shortcut'));
        } else {
            // Jika belum login, tampilkan halaman login
            $data = [];
            return view('pkl::Auth.index', compact('data'));
        }
    }

    public function pageLogin()
    {
        $data = [];
        if (Auth::check()) {
            $userId = Auth::user()->id;
            echo $userId;
            echo 'aaaaa';
            // return redirect()->intended('/');
        } else {
            return view('pkl::Auth.index', compact('data'));
        }
    }
}
