<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aArrRoles = Role::all();
        foreach ($aArrRoles as $role) {
            if (method_exists($this, $role->slug)) {
                $this->{$role->slug}($role);
            }
        }
    }

    private function super_admin($role)
    {
        $menuIds = Menu::all()->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
            // $role->menus()->sync($menuIds);
            // $role->menus()->attach($menuIds);
        }
    }

    private function admin_sekolah($role)
    {
        $inMenu = $this->global();
        $inMenu = array_merge($inMenu,$this->menu_data());
        $inMenu = array_merge($inMenu,$this->menu_pkl());
        $inMenu = array_merge($inMenu,$this->master());
        $inMenu = array_merge($inMenu,$this->management());
        $inMenu = array_merge($inMenu,$this->setting());
        $menuIds = Menu::whereIn('slug', $inMenu)->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }

    private function wali_kelas($role)
    {
        $inMenu = $this->global();
        $inMenu = array_merge($inMenu,['dasirole']);
        $menuIds = Menu::whereIn('slug', $inMenu)->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }

    private function guru($role)
    {
        $inMenu = $this->global();
        $menuIds = Menu::whereIn('slug', $inMenu)->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }

    private function siswa($role)
    {
        $inMenu = $this->global();
        $inMenu = array_merge($inMenu,$this->menu_pkl_siswa());
        $menuIds = Menu::whereIn('slug', $inMenu)->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }

    private function iduka($role)
    {
        $inMenu = $this->global();
        $inMenu = array_merge($inMenu,['dasirole']);
        $menuIds = Menu::whereIn('slug', $inMenu)->pluck('id')->toArray();

        if (!empty($menuIds)) {
            $this->command->info($role->name);
            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }


    private function global()
    {
        $inMenu[] = 'dashboard_~|role|~';
        $inMenu[] = 'profile_~|role|~';
        return  $inMenu;
    }

    private function menu_data()
    {
        $inMenu[] = 'data';
        $inMenu[] = 'dapeg';
        $inMenu[] = 'dasi';
        $inMenu[] = 'dakel';
        return $inMenu;
    }

    private function menu_pkl()
    {
        $inMenu[] = 'pkl';
        $inMenu[] = 'peserta_pkl';
        $inMenu[] = 'penempatanpkl';
        $inMenu[] = 'pklpriode';
        $inMenu[] = 'pendaftaranpkl';
        $inMenu[] = 'konfirmasipkl';
        return $inMenu;
    }

    private function menu_pkl_siswa()
    {
        $inMenu[] = 'pkl_siswa';
        $inMenu[] = 'absensi_pkl_siswa';
        return $inMenu;
    }

    private function master()
    {
        $inMenu[] = 'master';
        $inMenu[] = 'masdudi';
        $inMenu[] = 'masju';
        $inMenu[] = 'masrombel';
        return $inMenu;
    }

    private function management()
    {
        $inMenu[] = 'management';
        $inMenu[] = 'mansi';
        $inMenu[] = 'manpeg';
        return $inMenu;
    }

    private function setting()
    {
        $inMenu[] = 'setting';
        $inMenu[] = 'config_app';
        $inMenu[] = 'upload_siswa';
        $inMenu[] = 'config_kurikulum';
        return $inMenu;
    }
}
