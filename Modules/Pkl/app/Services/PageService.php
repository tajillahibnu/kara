<?php

namespace Modules\Pkl\Services;

use Exception;

class PageService
{
    protected $viewPath;
    protected $sourceFile;
    protected $sourceFile2;
    protected $modulesName = 'pkl';
    public function __construct()
    {
        // Inisialisasi nilai properti
        $this->viewPath = '';
        $this->sourceFile = base_path('Modules/' . $this->modulesName . '/resources/views/dummy/blank.blade.php');
        $this->sourceFile2 = base_path('Modules/' . $this->modulesName . '/resources/views/dummy/plugins.blade.php');
    }

    public function show($request)
    {
        $html = '';
        $menu = $request->input();
        if (empty($menu['view_path'])) {
            $html = 'View path file does not exist';
            // throw new Exception('View path file does not exist!');
        }
        if ($html == '') {
            if (empty($menu['view_file'])) {
                throw new Exception('View file does not exist!');
            }

            $this->viewPath = $this->modulesName . '::' . str_replace('/', '.', $menu['view_path'] . '/' . $menu['view_file']);
            if (!view()->exists($this->viewPath)) {
                $this->createFilePage($menu['view_path'], $menu['view_file']);
                throw new Exception('View file does not exist! ' . $this->viewPath);
            } else {
                $html = view($this->viewPath)->render();
            }

            $pluginsLocation = $this->modulesName . '::' . str_replace('/', '.', $menu['view_path'] . '/plugins');
            if (view()->exists($pluginsLocation)) {
                $plugins = view($pluginsLocation)->render();
            }
        }
        try {
            $html = encryptData($html);
            $plugins = encryptData($plugins);
        } catch (\Throwable $e) {
            throw new Exception('View not found or error in rendering view.');
        }
        return ['name' => $menu['title'], 'url' => $menu['url'], 'html' => $html, 'plugins' => $plugins];
    }

    private function createFilePage($path, $file)
    {
        $destinationPath = base_path('Modules/' . $this->modulesName . '/resources/views/' . $path . '/' . $file . '.blade.php');
        $destinationPath2 = base_path('Modules/' . $this->modulesName . '/resources/views/' . $path . '/plugins.blade.php');
        $destinationDir = dirname($destinationPath); // Direktori tujuan

        // Buat folder jika belum ada
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true); // Buat folder secara rekursif
        }

        // Cek apakah file source ada
        if (file_exists($this->sourceFile)) {
            // Copy file template default ke tujuan
            copy($this->sourceFile, $destinationPath);
            copy($this->sourceFile2, $destinationPath2);
        } else {
            throw new \Exception("Default view file does not exist.");
        }
    }
}
