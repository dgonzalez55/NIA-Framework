<?php 
    namespace app\models\regEntries;
    use app\datasources\CookieDB;

    // * Aquesta classe juga un paper de tipus ORM (Object Relational Mapping), mappeja les dades de la base de dades a objectes

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class RegisterEntriesCookie extends RegisterEntries{
        public static function load(int $idUser):?self{
            $result = null;
            if($idUser>0){                
                $cookieDB = CookieDB::getInstance();
                $dataset  = $cookieDB->find('marcatges'.hash("sha512",$idUser));
                $result = new self();
                foreach($dataset as $regEntry){
                    $regId      = isset($regEntry['id']) ? $regEntry['id']: null;
                    $timestamp  = isset($regEntry['timestamp']) ? $regEntry['timestamp'] : null;
                    $regType    = isset($regEntry['type']) ? $regEntry['type'] : null;
                    if(!is_null($regId) && !is_null($regType) && !is_null($timestamp)){
                        $regEntry = new RegisterEntry($regId,$regType,$timestamp);
                        $result->add($regEntry);
                    }
                }
                $result;
            }
            return $result;
        }

        public function save(int $idUser):void{
            $cookieDB = CookieDB::getInstance();
            $cookieDB->insert('marcatges'.hash("sha512",$idUser),$this->all());
        }
    }