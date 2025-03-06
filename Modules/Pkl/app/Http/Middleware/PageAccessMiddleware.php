<?php

namespace Modules\Pkl\Http\Middleware;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Role_user;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PageAccessMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $kode = 401; // Unauthorized (Tidak Terautentikasi)
        $msgError = 'Anda harus login terlebih dahulu untuk mengakses halaman ini';
        if (Auth::check()) {
            $kode = 403; // Forbidden (Terautentikasi tetapi tidak punya izin/otorisasi)
            $msgError = 'Anda tidak memiliki izin untuk mengakses halaman ini';
            $user = Auth::user();
            if (!empty($request->input('slug'))) {
                $slug = Crypt::decrypt($request->input('slug'));
                $getRole = $this->verificationRoleUser($user, $slug);
                $request->merge(
                    array_merge(
                        ['slug' => $slug], // Tambahkan roleId sebagai array
                        $getRole ? $getRole->toArray() : []
                    )
                );
                // $request->merge($getRole ? $getRole->toArray() : []);
                if (!empty($getRole)) {
                    return $next($request);
                }
            } else {
                $menu = $this->verificationMenu($request);
                $request->merge($menu);
                $input = $request->input();
                unset($input['params']);
                $request->replace($input);
                return $next($request);
            }
        }

        return $this->apiResponse(['message' => ''])
            ->statusCode($kode)
            ->send();
    }

    private function verificationMenu($request)
    {
        // $user = Auth::user();
        $roleName = session('active_role_slug');

        $page = $request->input('params');

        /**
         * - Verifikasi Hak Akses Menu Role berdasarkan user
         */

        $menu = json_decode(decryptData($page), true);
        $menu = Menu::find($menu['id'])->toArray();
        $menu['title'] = str_replace('~|role|~', $roleName, $menu['title']);
        $menu['slug'] = str_replace('~|role|~', $roleName, $menu['slug']);
        $menu['view_path'] = str_replace('~|role|~', $roleName, $menu['view_path']);
        return $menu;
    }

    private function verificationRoleUser($getUser, $slug)
    {
        $aArrRoles = Role_user::leftJoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('role_users.user_id', $getUser->id)
            ->where('roles.slug', $slug)
            ->first();
        return $aArrRoles;
    }
}
