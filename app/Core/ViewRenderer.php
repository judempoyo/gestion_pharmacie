<?php
namespace App\Core;

trait ViewRenderer {
    protected function render(string $layoutpath, string $viewPath, array $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../../app/Views/$viewPath.php";
        $content = ob_get_clean();
        include __DIR__ . "/../../app/Views/layouts/$layoutpath.php";
    }
}