<?php

namespace Modules\Pkl\Services\Menu;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Rombel;

class RoleToMenuService
{
    public function showMenuRole($slugRole, $biodata_id)
    {
        $aArrData = [];
        switch ($slugRole) {
            case 'wali_kelas':
                $getRole = Role::where('slug', $slugRole)->first();
                $aArrData = $this->wali_kelas($slugRole, $getRole->id, $biodata_id);
                break;
            default:
                # code...
                break;
        }
        return $aArrData;
    }

    private function wali_kelas($slugRole, $roleId, $biodata_id)
    {
        $aArrData = [];
        $getRombel = Rombel::where('walikelas_id', $biodata_id);
        // dd($getRombel->first());
        if ($getRombel->exists()) {
            // echo $slugRole;
            $aArrData = $getRombel->first()->toArray();
            $aArrData = $this->menuNav($slugRole, $roleId, 'menu_pkl_siswa');
        }
        return $aArrData;
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
}
