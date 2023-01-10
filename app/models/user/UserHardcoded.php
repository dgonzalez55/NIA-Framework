<?php 
    namespace app\models\user;
    use app\datasources\HardcodedDB;

    // * Aquesta classe juga un paper de tipus ORM (Object Relational Mapping), mappeja les dades de la base de dades a objectes

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class UserHardcoded extends User{
        public static function loadUser(string $email, string $pass):?self{
            $result = null;
            if(!empty($email) && !empty($pass)){
                $memorydb = HardcodedDB::getInstance();
                $dataset  = $memorydb->findOne('users', ['user'=>strtolower($email)]);
                $password = $dataset['pass'] ?? '';
                if(password_verify($pass,$password)){
                    $result = new self($dataset['id'],$dataset['user'],$dataset['rol']);
                }
            }
            return $result;
        }
    }