<?php
    //Segons la PSR-4, el namespace ha de ser el mateix que el path i el nom del fitxer ha de ser el mateix que el nom de la classe
    //More Info: https://www.php-fig.org/psr/psr-4/
    spl_autoload_register(function ($className){
        // Convert the class name to a file path
        $filePath = APP_BASE_PATH . str_replace('\\', '/', $className) . '.php';
        // Check if the file exists
        if (file_exists($filePath)) {
            // If the file exists, include it
            require $filePath;
        }
    });