<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $no = 1;
        $aArrMenu = [
            'dashboard',
            'data',
            'pkl',
            'master',
            'management',
            'setting',
            'headNav',
        ];
        for ($i = 1; $i <= count($aArrMenu); $i++) {
            $menuNumber = 1;
            $this->{$aArrMenu[$i - 1]}($i, $menuNumber);
            $menuNumber++;
        }
    }

    private function dashboard($id, $menuNumber)
    {

        $save['id']    = $id;
        $save['title'] = 'Dashboard';
        $save['name']  = 'Dashboard';
        $save['type']  = 'main';
        $save['slug']  = 'dashboard_~|role|~';
        $save['url']   = 'dashboard';
        $save['view_path']  = 'dashboard/~|role|~';
        $save['view_file']  = 'default';
        $save['level'] = '0';
        $save['menu_order'] = $menuNumber;
        $save['middlewares'] = json_encode(['auth']);
        Menu::create($save);
    }

    private function data($id,$menuNumber){
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'Data';
        $save['title']  = 'Data';
        $save['slug']   = 'data';
        $save['url']   = 'data';
        $save['level'] = '0';
        $save['type']  = 'main';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Pegawai';
        $save['name']       = 'Pegawai';
        $save['slug']       = 'dapeg';
        $save['url']        = 'data/dapeg';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'data/pegawai/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Siswa';
        $save['name']       = 'Siswa';
        $save['slug']       = 'dasi';
        $save['url']        = 'data/dasi';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'data/siswa/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Kelas';
        $save['name']       = 'Kelas';
        $save['slug']       = 'dakel';
        $save['url']        = 'data/dakel';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'data/kelas/';
        $save['view_file']      = 'default';
        Menu::create($save);
    }

    private function pkl($id,$menuNumber){
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'PKL';
        $save['title']  = 'PKL';
        $save['slug']   = 'pkl';
        $save['url']   = 'pkl';
        $save['level'] = '0';
        $save['type']  = 'main';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Periode';
        $save['name']       = 'Periode';
        $save['slug']       = 'pklpriode';
        $save['url']        = 'pkl/priode';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'pkl/priode/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Pendaftaran';
        $save['name']       = 'Pendaftaran PKL';
        $save['slug']       = 'pendaftaranpkl';
        $save['url']        = 'pkl/pendaftaran';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'pkl/pendaftaran/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Konfirmasi';
        $save['name']       = 'Konfirmasi';
        $save['slug']       = 'konfirmasipkl';
        $save['url']        = 'pkl/konfirmasi';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'pkl/konfirmasi/';
        $save['view_file']      = 'default';
        Menu::create($save);
    }

    private function master($id,$menuNumber){
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'Master';
        $save['title']  = 'Master';
        $save['slug']   = 'master';
        $save['url']   = 'master';
        $save['level'] = '0';
        $save['type']  = 'main';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Dunia Usaha dan Dunia Industri';
        $save['name']       = 'DU & DI';
        $save['slug']       = 'masdudi';
        $save['url']        = 'master/dudi';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'master/dudi/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Jurusan';
        $save['name']       = 'Jurusan';
        $save['slug']       = 'masju';
        $save['url']        = 'master/jurusan';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'master/kurikulum/jurusan/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Kelas';
        $save['name']       = 'Kelas';
        $save['slug']       = 'masrombel';
        $save['url']        = 'master/rombel';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'master/rombel/';
        $save['view_file']      = 'default';
        Menu::create($save);

        // $dd = $dd + 1;
        // $save['id']         = $id.$dd;
        // $save['parent_id']  = $id;
        // $save['title']      = 'Tahun Akademik';
        // $save['name']       = 'Tahun Akademik';
        // $save['slug']       = 'masta';
        // $save['url']        = 'master/tahun';
        // $save['level']      = '1';
        // $save['type']       = 'main';
        // $save['menu_order'] = $dd;
        // $save['view_path']      = 'master/tahun/';
        // $save['view_file']      = 'default';
        // Menu::create($save);
    }
    
    private function management($id,$menuNumber){
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'Management';
        $save['title']  = 'Management';
        $save['slug']   = 'management';
        $save['url']   = 'management';
        $save['level'] = '0';
        $save['type']  = 'main';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Management Siswa';
        $save['name']       = 'Siswa';
        $save['slug']       = 'mansi';
        $save['url']        = 'management/mansi';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'management/siswa/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Management Pegawai';
        $save['name']       = 'Pegawai';
        $save['slug']       = 'manpeg';
        $save['url']        = 'management/manpeg';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'management/pegawai/';
        $save['view_file']      = 'default';
        Menu::create($save);
    }

    private function setting($id, $menuNumber)
    {
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'Setting';
        $save['slug']   = 'setting';
        $save['url']   = 'setting';
        $save['level'] = '0';
        $save['type']  = 'main';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Setting Aplikasi';
        $save['name']       = 'Aplikasi';
        $save['slug']       = 'config_app';
        $save['url']        = 'setting/app';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']      = 'setting/app/';
        $save['view_file']      = 'default';
        Menu::create($save);

        $dd = $dd + 1;
        $save['id']         = $id.$dd;
        $save['parent_id']  = $id;
        $save['title']      = 'Setting Sekolah';
        $save['name']       = 'Sekolah';
        $save['slug']       = 'config_kurikulum';
        $save['url']        = 'setting/sekolah';
        $save['level']      = '1';
        $save['type']       = 'main';
        $save['menu_order'] = $dd;
        $save['view_path']  = 'setting/kurikulum/';
        $save['view_file']  = 'default';
        Menu::create($save);
    }

    private function headNav($id, $menuNumber)
    {
        $dd = $id;
        $save['id']    = $id;
        $save['name']  = 'Profile';
        $save['type']  = 'head';
        $save['slug']   = 'profile_~|role|~';
        $save['url']   = 'profile';
        $save['view_path']  = 'biodata/~|role|~';
        $save['view_file']  = 'default';
        $save['level'] = '0';
        $save['menu_order'] = $menuNumber;
        Menu::create($save);
        $dd = $dd + 1;

        // $save['id']    = $id.$dd;
        // $save['name']  = 'Profile';
        // $save['type']  = 'head';
        // $save['slug']   = 'profile_~|role|~';
        // $save['url']   = 'profile';
        // $save['view_path']  = 'biodata/~|role|~';
        // $save['view_file']  = 'default';
        // $save['level'] = '0';
        // $save['menu_order'] = $menuNumber;
        // Menu::create($save);
    }
}
