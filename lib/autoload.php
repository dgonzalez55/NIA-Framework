<?php
    //Segons la PSR-4, el namespace ha de ser el mateix que el path i el nom del fitxer ha de ser el mateix que el nom de la classe
    //More Info: https://www.php-fig.org/psr/psr-4/
    spl_autoload_register(function($className){
        // Replace the namespace separator with the directory separator
        $className = str_replace('\\', '/', $className);
        // Separate the namespace from the class name into $namespace and $className
        $nameSpace = substr($className, 0, strrpos($className, '/'));
        $className = substr($className, strrpos($className, '/') + 1);
        // Define a list of directories to search for class files
        $directories = array(
            APP_BASE_PATH . $nameSpace . '/',
            APP_BASE_PATH . strtolower($nameSpace) . '/',
            APP_BASE_PATH . 'vendor/' . $nameSpace . '/src/',
            APP_BASE_PATH . 'vendor/' . strtolower($nameSpace) . '/src/'
        );
        // Search for the class file in each directory
        foreach ($directories as $directory) {
            $files = glob($directory . '*.php');
            foreach ($files as $file) {
                if (strcasecmp(basename($file, '.php'), $className) === 0) {
                    require $file;
                    return;
                }
            }
        }
    });