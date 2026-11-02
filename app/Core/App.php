<?php
namespace App\Core;

/**
 * Class App (Router Sederhana Native PHP)
 * Format URL: index.php?c=controller_name&m=method_name
 * Default Controller: HomeController (Halaman Depan / Landing Page)
 */
class App {
    public static function run(): void {
        $controllerName = $_GET['c'] ?? 'home';
        $methodName     = $_GET['m'] ?? 'index';

        // Format nama class controller: User -> UserController
        $controllerClass = "App\\Controllers\\" . ucfirst($controllerName) . "Controller";

        if (!class_exists($controllerClass)) {
            // Fallback jika tidak ditemukan
            $controllerClass = "App\\Controllers\\HomeController";
            $methodName = "index";
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            $methodName = "index";
        }

        // Panggil method
        $controller->$methodName();
    }
}
