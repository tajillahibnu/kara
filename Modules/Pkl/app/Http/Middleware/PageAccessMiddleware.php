<?php

namespace Modules\Pkl\Http\Middleware;

use App\Models\Menu;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageAccessMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $menu = $this->verificationMenu($request);
            $request->merge($menu);
            $input = $request->input();
            unset($input['params']);
            $request->replace($input);
            return $next($request);
        }

        return $this->apiResponse([])
            ->statusCode(401)
            ->send();
    }

    private function verificationMenu($request)
    {
        // $user = Auth::user();
        // $roleId = session('module_role_id');
        $roleName = session('akses_module');

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
}
