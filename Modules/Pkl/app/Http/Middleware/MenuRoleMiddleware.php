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
            $roleActive = session('akses_module');
            
            $user = Auth::user();
            $user->name_module = session('name_module');
            // dd($user);
            View::share('biodata', $user);

            $menus = $this->menuNav($roleActive);
            View::share('menus', $menus);

            $userRoles = $this->shorcutRole();
            View::share('userRoles', $userRoles);
        }
        return $next($request);
    }

    private function shorcutRole()
    {
        $aArrRoles = Role::all();
        return $aArrRoles;
    }

    private function menuNav($roleActive,$type = 'main')
    {
        $menus = Menu::where('parent_id', null)
            ->where('type', $type)
            ->get();
        foreach ($menus as $value) {
            $value->name = ucwords($value->name);
            $value->sub_menu = $this->subMenuNav($value->id, $roleActive);;
        }
        return $menus;
    }

    private function subMenuNav($id, $roleActive)
    {
        $aArrSubMenu = Menu::select("*")
            ->where('parent_id', $id)
            ->orderBy('menu_order', 'ASC')
            ->get();
        if (!$aArrSubMenu->isEmpty()) {
            foreach ($aArrSubMenu as $key => $value) {
                $value->name = ucwords($value->name);
                $value->sub_menu = $this->subMenuNav($value->id, $roleActive);
            }
        }
        // return $aArrSubMenu->isEmpty() ? (object)[] : $aArrSubMenu;
        return $aArrSubMenu->isEmpty() ? [] : $aArrSubMenu;
    }
}
