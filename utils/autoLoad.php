<?php 
spl_autoload_register(function ($class_name) {
    // Convert class name to file path
    $file_path = '../../Model/' . $class_name . '.php';
    $file_path_from_post = '../Model/'. $class_name . '.php';

    // Check if the file exists
    if (file_exists($file_path)) {
        // Load the class file
        require_once $file_path;
    }

    if (file_exists($file_path_from_post)) {
        // Load the class file
        require_once $file_path_from_post ;
    }
});

