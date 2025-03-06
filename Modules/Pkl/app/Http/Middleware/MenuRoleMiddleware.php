<?php

namespace Modules\Pkl\Http\Middleware;

use App\Models\Menu;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MenuRoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $slugRole = session('active_role_slug');
            $roleId = session('active_role_id');

            $user = Auth::user();
            $user->name_module = session('active_role_name');

            View::share('biodata', $user);

            $menus = $this->menuNav($slugRole, $roleId);
            View::share('menus', $menus);

            $getRole = Role::where('id', $user->primary_role_id)->first();
            $mainRole = !empty($getRole) ? strtolower(trim($getRole->slug)) : 'unknown';
            $navHead = $this->headNav($mainRole);
            View::share('nav_head', $navHead);

            $userRoles = $this->shorcutRole($user->id);
            View::share('userRoles', $userRoles);
        }
        return $next($request);
    }

    private function shorcutRole($userId)
    {
        $aArrRoles = Role::leftJoin('role_users', 'roles.id', '=', 'role_users.role_id')
            ->where('role_users.user_id', $userId)
            ->select('roles.slug', 'roles.name', 'roles.description') // Memilih semua kolom dari roles
            ->get();

        return $aArrRoles;
    }

    private function menuNav($roleActive, $roleId, $type = 'main')
    {
        return Menu::leftJoin('role_menus', 'menus.id', '=', 'role_menus.menu_id')
            ->select('menus.*')
            ->whereNull('parent_id')
            ->where('type', $type)
            ->where('role_menus.role_id', $roleId)
            ->get()
            ->map(function ($menu) use ($roleActive, $roleId) {
                $menu->name = ucwords($menu->name);
                $menu->sub_menu = $this->subMenuNav($menu->id, $roleActive, $roleId);
                return $menu;
            });
    }

    private function subMenuNav($id, $roleActive, $roleId)
    {
        $subMenus = Menu::leftJoin('role_menus', 'menus.id', '=', 'role_menus.menu_id')
            ->select('menus.*')
            ->where('parent_id', $id)
            ->where('role_menus.role_id', $roleId)
            ->orderBy('menu_order', 'ASC')
            ->get();

        return $subMenus->isNotEmpty()
            ? $subMenus->map(function ($menu) use ($roleActive, $roleId) {
                $menu->name = ucwords($menu->name);
                $menu->sub_menu = $this->subMenuNav($menu->id, $roleActive, $roleId);
                return $menu;
            })
            : collect([]); // Tetap return Collection kosong agar konsisten

    }

    private function headNav($mainRole, $type = 'head')
    {
        if (empty($mainRole) || empty($type)) {
            return collect(); // Return collection kosong jika parameter tidak valid
        }

        return Menu::whereNull('parent_id')
            ->where('type', $type)
            ->get()
            ->map(function ($menu) use ($mainRole) {
                $menu->name = ucwords($menu->name);
                $menu->slug = str_replace('~|role|~', $mainRole, $menu->slug);
                $menu->view_path = str_replace('~|role|~', $mainRole, $menu->view_path);
                return $menu;
            });
    }
}
