<?php

namespace Modules\Pkl\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function do_login(Request $request)
    {
        $isEmail = filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL);
        // Tentukan bidang yang akan digunakan berdasarkan jenis input
        $field = $isEmail ? 'email' : 'username';
        $rememberMe = $request->has('remember_me'); // Cek apakah "Remember Me" dicentang
        if (Auth::attempt([$field => $request->input('email-username'), 'password' => $request->input('password')], $rememberMe)) {
            $user = Auth::user();
            // $getRole = Role::where('id', $user->primary_role_id)->get()->toArray();
            $getRole = Role::where('id', $user->primary_role_id)->first();

            session()->put('module_role_id', $getRole->id);
            session()->put('akses_module', $getRole->slug);
            session()->put('name_module', $getRole->name);
            // session()->put('user_role', 'admin');
            return redirect()->intended('/');
        } else {
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
