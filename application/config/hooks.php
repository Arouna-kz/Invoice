<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['pre_system'] = function() {
    require_once FCPATH . 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(FCPATH);
    $dotenv->load();
};

// $hook['pre_system'] = function() {
//     // Chemin absolu vérifié
//     $dotenv_path = APPPATH . 'third_party/dotenv/';
    
//     // Vérification critique des fichiers
//     if (!file_exists($dotenv_path . 'Dotenv.php')) {
//         die("Fichier Dotenv.php manquant dans: " . $dotenv_path);
//     }

//     // Inclusion avec namespace
//     // require_once $dotenv_path . 'Dotenv.php';
//     require_once $dotenv_path . 'Loader/Loader.php';
//     require_once $dotenv_path . 'Parser/Parser.php';

//     // Initialisation avec vérification de classe
//     if (!class_exists('Dotenv\Dotenv')) {
//         die("La classe Dotenv n'est pas disponible après inclusion");
//     }

//     try {
//         $dotenv = Dotenv\Dotenv::createImmutable(FCPATH);
//         $dotenv->safeLoad(); // Ne lance pas d'exception si .env n'existe pas
//     } catch (Throwable $e) {
//         log_message('error', 'Dotenv Error: ' . $e->getMessage());
//         if (ENVIRONMENT === 'development') {
//             show_error('Dotenv Error: ' . $e->getMessage());
//         }
//     }
// };