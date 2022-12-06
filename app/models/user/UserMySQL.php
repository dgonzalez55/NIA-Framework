<?php 
    namespace app\models\user;
    use app\models\user\User;
    use app\datasources\MySQLDB;

    // ? No podem tenir una propietat de tipus MySQL ja que utilitza la llibreria PDO que no és serialitzable
    // ? Ens interessa serialitzar la classe per poder-la guardar a la sessió (el dataset és una propietat del model)
    // ? MySQL implementa el patró de disseny Singleton i per tant no podem tenir més d'una instància de la classe
    // * Aquesta classe juga un paper de tipus ORM (Object Relational Mapping), mappeja les dades de la base de dades a objectes

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class UserMySQL extends User{
        public static function loadUser(string $email, string $pass):?self{
            $result = null;
            if(!empty($email) && !empty($pass)){
                $mysql    = MySQLDB::getInstance();
                $dataset  = $mysql->findOne('users', ['email'=>strtolower($email)]);
                $password = $dataset['password'] ?? '';
                if(password_verify($pass,$password)){
                    $result = new self($dataset['idUser'],$dataset['email'],$dataset['role']);
                }
            }
            return $result;
        }
    }