<?php
    //Segons la PSR-4, el namespace ha de ser el mateix que el path i el nom del fitxer ha de ser el mateix que el nom de la classe
    //More Info: https://www.php-fig.org/psr/psr-4/
    spl_autoload_register(function($className){
        // Replace the namespace separator with the directory separator
        $className = str_replace('\\', '/', $className);
        // Separate the namespace from the class name into $namespace and $className
        $nameSpace = substr($className, 0, strrpos($className, '/'));
        $className = substr($className, strrpos($className, '/') + 1);
        // Convert the class name to a file path
        $filePath = APP_BASE_PATH . "$nameSpace/$className.php";
        // Convert the class name to a file path (vendor - composer)
        $filePathExt = APP_BASE_PATH . "vendor/$nameSpace/src/$className.php";
        // Include the file if it exists
        file_exists($filePath) ? require $filePath : (file_exists($filePathExt) ? require $filePathExt : null);
    });